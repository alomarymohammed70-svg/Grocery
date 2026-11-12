<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\CustomerPayment;
use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerPaymentController extends Controller
{
    // حفظ دفعة جديدة
    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'amount' => 'required|numeric|min:0.01',
            'payment_method' => 'required|in:cash,transfer,check',
            'payment_date' => 'required|date',
            'notes' => 'nullable|string|max:1000',
            'sale_id' => 'nullable|exists:sales,id'
        ]);
        
        try {
            DB::beginTransaction();
            
            // الحصول على العميل
            $customer = Customer::findOrFail($validated['customer_id']);
            
            // التحقق من أن المبلغ لا يتجاوز الرصيد
            if ($validated['amount'] > $customer->balance) {
                return response()->json([
                    'success' => false,
                    'message' => 'مبلغ السداد أكبر من الرصيد المستحق'
                ], 400);
            }
            
            // حفظ الدفعة
            $payment = CustomerPayment::create($validated);
            
            // تحديث رصيد العميل
            $customer->balance = $customer->balance - $validated['amount'];
            $customer->save();
            
            // إذا كان هناك فاتورة محددة، تحديث حالة الدفع للفاتورة
            if (!empty($validated['sale_id'])) {
                $sale = Sale::find($validated['sale_id']);
                if ($sale) {
                    $totalPaid = CustomerPayment::where('sale_id', $sale->id)->sum('amount');
                    $remaining = $sale->total - $totalPaid;
                    
                    if ($remaining <= 0) {
                        $sale->payment_status = 'paid';
                    } elseif ($totalPaid > 0) {
                        $sale->payment_status = 'partial';
                    }
                    
                    $sale->save();
                }
            }
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'تم تسجيل الدفعة بنجاح',
                'payment' => $payment,
                'new_balance' => $customer->balance
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ في تسجيل الدفعة: ' . $e->getMessage()
            ], 500);
        }
    }

    // الحصول على مدفوعات عميل معين
    public function getCustomerPayments($customerId)
    {
        try {
            $payments = CustomerPayment::where('customer_id', $customerId)
                ->orderBy('created_at', 'desc')
                ->get();
            
            return response()->json([
                'success' => true,
                'payments' => $payments
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ في جلب المدفوعات'
            ], 500);
        }
    }

    // حذف دفعة
    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            
            $payment = CustomerPayment::findOrFail($id);
            $customer = Customer::find($payment->customer_id);
            
            if ($customer) {
                // استرجاع المبلغ إلى رصيد العميل
                $customer->balance = $customer->balance + $payment->amount;
                $customer->save();
            }
            
            // إذا كان هناك فاتورة محددة، تحديث حالة الدفع للفاتورة
            if ($payment->sale_id) {
                $sale = Sale::find($payment->sale_id);
                if ($sale) {
                    $totalPaid = CustomerPayment::where('sale_id', $sale->id)
                        ->where('id', '!=', $payment->id)
                        ->sum('amount');
                    $remaining = $sale->total - $totalPaid;
                    
                    if ($remaining <= 0) {
                        $sale->payment_status = 'paid';
                    } elseif ($totalPaid > 0) {
                        $sale->payment_status = 'partial';
                    } else {
                        $sale->payment_status = 'unpaid';
                    }
                    
                    $sale->save();
                }
            }
            
            $payment->delete();
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'تم حذف الدفعة بنجاح'
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ في حذف الدفعة: ' . $e->getMessage()
            ], 500);
        }
    }
}