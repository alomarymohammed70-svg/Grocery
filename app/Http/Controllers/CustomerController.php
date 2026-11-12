<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\CustomerPayment;
use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    // عرض صفحة العملاء
    public function index()
    {
        $customers = Customer::withCount([
            'sales as total_sales_count',
            'sales as credit_sales_count' => function($query) {
                $query->where('sale_type', 'credit');
            }
        ])->get();
        
        // حساب الإحصائيات
        $totalCustomers = $customers->count();
        $totalDebt = $customers->sum('balance');
        $debtorsCount = $customers->where('balance', '>', 0)->count();
        
        $stats = [
            'total_customers' => $totalCustomers,
            'total_debt' => $totalDebt,
            'debtors_count' => $debtorsCount
        ];
        
        return view('customers.index', compact('customers', 'stats'));
    }

    // الحصول على تفاصيل عميل مع فواتيره ومدفوعاته
   // الحصول على تفاصيل عميل مع فواتيره ومدفوعاته
// الحصول على تفاصيل عميل مع فواتيره ومدفوعاته
public function show($id)
{
    try {
        $customer = Customer::findOrFail($id);
        
        // الحصول على فواتير الدين للعميل
        $invoices = Sale::where('customer_id', $id)
            ->where('sale_type', 'credit')
            ->select('id', 'invoice_number', 'total_amount', 'paid_amount', 'created_at')
            ->get()
            ->map(function ($sale) {
                $paidAmount = CustomerPayment::where('sale_id', $sale->id)->sum('amount');
                $total = $sale->total_amount ?? 0; // استخدام total_amount بدلاً من total
                $paid = $paidAmount;
                $remaining = $total - $paid;
                
                return [
                    'id' => $sale->id,
                    'invoice_number' => $sale->invoice_number,
                    'total' => $total,
                    'paid_amount' => $paid,
                    'remaining_amount' => $remaining,
                    'created_at' => $sale->created_at,
                    'paid' => $paid,
                    'remaining' => $remaining
                ];
            });
        
        // الحصول على مدفوعات العميل
        $payments = CustomerPayment::where('customer_id', $id)
            ->with(['sale' => function($query) {
                $query->select('id', 'invoice_number');
            }])
            ->get()
            ->map(function ($payment) {
                return [
                    'id' => $payment->id,
                    'sale_id' => $payment->sale_id,
                    'sale' => $payment->sale,
                    'amount' => $payment->amount,
                    'payment_method' => $payment->payment_method,
                    'notes' => $payment->notes,
                    'created_at' => $payment->created_at
                ];
            });
        
        return response()->json([
            'success' => true,
            'data' => [
                'customer' => $customer,
                'invoices' => $invoices,
                'payments' => $payments
            ]
        ]);
        
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'لم يتم العثور على العميل: ' . $e->getMessage()
        ], 404);
    }
}

    // الحصول على بيانات العميل للتعديل
    public function edit($id)
    {
        try {
            $customer = Customer::findOrFail($id);
            
            return response()->json([
                'success' => true,
                'data' => $customer
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'لم يتم العثور على العميل'
            ], 404);
        }
    }

    // حفظ عميل جديد
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20|unique:customers,phone',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string|max:500',
            'notes' => 'nullable|string|max:1000'
        ]);
        
        try {
            DB::beginTransaction();
            
            $customer = Customer::create($validated);
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'تم إضافة العميل بنجاح',
                'customer' => $customer
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ في إضافة العميل: ' . $e->getMessage()
            ], 500);
        }
    }

    // تحديث بيانات العميل
    public function update(Request $request, $id)
    {
        $customer = Customer::findOrFail($id);
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20|unique:customers,phone,' . $id,
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string|max:500',
            'notes' => 'nullable|string|max:1000'
        ]);
        
        try {
            DB::beginTransaction();
            
            $customer->update($validated);
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'تم تحديث بيانات العميل بنجاح',
                'customer' => $customer
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ في تحديث البيانات: ' . $e->getMessage()
            ], 500);
        }
    }

    // حذف عميل
    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            
            $customer = Customer::findOrFail($id);
            
            // التحقق من عدم وجود ديون مستحقة
            if ($customer->balance > 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'لا يمكن حذف عميل لديه ديون مستحقة'
                ], 400);
            }
            
            $customer->delete();
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'تم حذف العميل بنجاح'
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ في حذف العميل: ' . $e->getMessage()
            ], 500);
        }
    }

    // البحث عن العملاء
    public function search(Request $request)
    {
        $search = $request->get('search', '');
        
        $customers = Customer::where('name', 'like', "%{$search}%")
            ->orWhere('phone', 'like', "%{$search}%")
            ->orWhere('email', 'like', "%{$search}%")
            ->get();
        
        // تحضير HTML للجدول
        $html = '';
        if ($customers->isEmpty()) {
            $html = '<tr>
                <td colspan="5" style="text-align: center; padding: 40px; color: #8e8e93;">
                    <i class="fas fa-users" style="font-size: 48px; margin-bottom: 15px; opacity: 0.3;"></i>
                    <p>لا توجد عملاء</p>
                    <small>ابدأ بإضافة عميل جديد</small>
                </td>
            </tr>';
        } else {
            foreach ($customers as $customer) {
                // حساب حالة الرصيد
                $balance = $customer->balance;
                if ($balance == 0) {
                    $balanceClass = 'zero';
                    $balanceText = 'بدون ديون';
                } elseif ($balance > 0 && $balance <= 500) {
                    $balanceClass = 'low';
                    $balanceText = number_format($balance, 2) . ' ر.س';
                } elseif ($balance > 500) {
                    $balanceClass = 'high';
                    $balanceText = number_format($balance, 2) . ' ر.س';
                } else {
                    $balanceClass = 'positive';
                    $balanceText = number_format($balance, 2) . ' ر.س';
                }
                
                // حساب عدد الفواتير
                $invoiceCount = Sale::where('customer_id', $customer->id)
                    ->where('sale_type', 'credit')
                    ->count();
                
                $html .= '<tr data-customer-id="' . $customer->id . '">
                    <td>
                        <div class="customer-info">
                            <div class="customer-avatar">';
                
                $names = explode(' ', $customer->name);
                if (count($names) >= 2) {
                    $html .= substr($names[0], 0, 1) . substr($names[1], 0, 1);
                } else {
                    $html .= substr($customer->name, 0, 2);
                }
                
                $html .= '</div>
                            <div class="customer-details">
                                <h4>' . $customer->name . '</h4>
                                <p>' . $customer->phone . '</p>
                            </div>
                        </div>
                    </td>
                    <td>' . $customer->phone . '</td>
                    <td class="balance-cell">
                        <span class="balance-badge ' . $balanceClass . '">
                            ' . $balanceText . '
                        </span>
                    </td>
                    <td>
                        <span class="invoices-count">' . $invoiceCount . ' فاتورة</span>
                    </td>
                    <td class="actions-cell">
                        <div class="action-buttons">
                            <button class="btn-action btn-view" onclick="openCustomerDetailsModal(' . $customer->id . ')" title="عرض التفاصيل">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="btn-action btn-edit" onclick="openEditCustomerModal(' . $customer->id . ')" title="تعديل">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn-action btn-pay" onclick="openPayDebtModal(' . $customer->id . ')" title="تسديد دين" ' . ($customer->balance <= 0 ? 'disabled style="opacity:0.5;cursor:not-allowed;"' : '') . '>
                                <i class="fas fa-money-bill-wave"></i>
                            </button>
                        </div>
                    </td>
                </tr>';
            }
        }
        
        return response()->json([
            'success' => true,
            'html' => $html
        ]);
    }
    // دالة debug للتشخيص
public function debug($id)
{
    try {
        $customer = Customer::find($id);
        
        if (!$customer) {
            return response()->json([
                'found' => false,
                'message' => 'العميل غير موجود',
                'customer_id' => $id
            ]);
        }
        
        $salesCount = Sale::where('customer_id', $id)->count();
        $creditSalesCount = Sale::where('customer_id', $id)
            ->where('sale_type', 'credit')
            ->count();
        
        $paymentsCount = CustomerPayment::where('customer_id', $id)->count();
        
        return response()->json([
            'found' => true,
            'customer' => [
                'id' => $customer->id,
                'name' => $customer->name,
                'balance' => $customer->balance
            ],
            'counts' => [
                'total_sales' => $salesCount,
                'credit_sales' => $creditSalesCount,
                'payments' => $paymentsCount
            ],
            'database_columns' => [
                'sales_table' => \Schema::getColumnListing('sales'),
                'customer_payments_table' => \Schema::getColumnListing('customer_payments'),
                'payments_table' => \Schema::getColumnListing('payments')
            ]
        ]);
        
    } catch (\Exception $e) {
        return response()->json([
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ], 500);
    }
}
}