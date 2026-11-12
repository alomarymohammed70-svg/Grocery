<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\Product;
use App\Models\Category;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class SalesController extends Controller
{
    // عرض واجهة نقطة البيع
    public function index()
    {
        // حساب رقم الفاتورة التالي
        $nextSaleNumber = $this->generateNextSaleNumber();
        
        return view('sales.index', [
            'products' => Product::with('category')->get(),
            'categories' => Category::all(),
            'customers' => Customer::all(),
            'taxRate' => 0, // يمكنك تغييره إذا كان لديك ضريبة
            'nextSaleNumber' => $nextSaleNumber,
        ]);
    }
    
    // حفظ عملية البيع
    public function store(Request $request)
    {
        // التحقق من البيانات الأساسية
        $request->validate([
            'items' => 'required|array|min:1',
            'total' => 'required|numeric|min:0',
            'payment_type' => 'required|in:cash,credit',
            'paid_amount' => 'required|numeric|min:0',
        ]);
        
        // إذا كان البيع بالدين، يجب اختيار عميل
        if ($request->payment_type === 'credit') {
            $request->validate([
                'customer_id' => 'required|exists:customers,id',
            ]);
        }
        
        DB::beginTransaction();
        
        try {
            // إنشاء عملية البيع
            $sale = Sale::create([
                'user_id' => Auth::id(),
                'customer_id' => $request->payment_type === 'credit' ? $request->customer_id : null,
                'total_amount' => $request->total,
                'paid_amount' => $request->paid_amount,
                'sale_type' => $request->payment_type === 'credit' ? 'credit' : 'cash',
                'sale_date' => now(),
            ]);
            
            // إضافة عناصر البيع
            foreach ($request->items as $item) {
                $saleItem = SaleItem::create([
                    'sale_id' => $sale->id,
                    'product_id' => (!$item['isQuickProduct'] && is_numeric($item['id'])) 
                        ? $item['id'] 
                        : null,
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'total' => $item['total'],
                ]);
                
                // تحديث مخزون المنتج (للمنتجات العادية فقط)
                if (!$item['isQuickProduct'] && $item['id']) {
                    $product = Product::find($item['id']);
                    if ($product) {
                        // التحقق من توفر الكمية
                        if ($product->quantity < $item['quantity']) {
                            throw new \Exception('الكمية غير متوفرة للمنتج: ' . $item['name']);
                        }
                        
                        // خصم الكمية من المخزون
                        $product->decrement('quantity', $item['quantity']);
                        
                        // يمكنك إضافة تنبيه إذا كان المخزون أصبح منخفضاً
                        if ($product->quantity <= $product->minimum_quantity) {
                            // هنا يمكنك إضافة تنبيه أو تسجيل في جدول التنبيهات
                        }
                    }
                }
            }
            
            // تحديث رصيد العميل إذا كان البيع بالدين
            if ($request->payment_type === 'credit' && $request->customer_id) {
                $customer = Customer::find($request->customer_id);
                if ($customer) {
                    $remaining = $request->total - $request->paid_amount;
                    $customer->increment('balance', $remaining);
                }
            }
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'تم حفظ الفاتورة بنجاح',
                'sale_id' => $sale->id,
                'sale_number' => $sale->id, // استخدام ID كرقم فاتورة
                'print_url' => route('sales.print', $sale->id),
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ أثناء حفظ الفاتورة: ' . $e->getMessage(),
            ], 500);
        }
    }
    
    // دالة لإنشاء رقم فاتورة (بسيطة)
    private function generateNextSaleNumber()
    {
        $lastSale = Sale::latest()->first();
        return $lastSale ? $lastSale->id + 1 : 1;
    }
    
    // طباعة الفاتورة
    public function print($id)
    {
        $sale = Sale::with(['items.product', 'customer', 'user'])->findOrFail($id);
        
        return view('sales.print', compact('sale'));
    }
    
    // عرض قائمة المبيعات
    public function list()
    {
        $sales = Sale::with(['customer', 'user'])
                    ->orderBy('created_at', 'desc')
                    ->paginate(20);
        
        return view('sales.list', compact('sales'));
    }
    
    // عرض تفاصيل فاتورة
    public function show($id)
    {
        $sale = Sale::with(['items.product', 'customer', 'user'])->findOrFail($id);
        
        return view('sales.show', compact('sale'));
    }
    
    // إلغاء فاتورة
    public function cancel($id)
    {
        $sale = Sale::findOrFail($id);
        
        DB::beginTransaction();
        
        try {
            // استرجاع الكميات للمنتجات
            foreach ($sale->items as $item) {
                if ($item->product_id) {
                    $product = Product::find($item->product_id);
                    if ($product) {
                        $product->increment('quantity', $item->quantity);
                    }
                }
            }
            
            // استرجاع رصيد العميل إذا كان بيع بالدين
            if ($sale->customer_id && $sale->sale_type === 'credit') {
                $customer = Customer::find($sale->customer_id);
                if ($customer) {
                    $remaining = $sale->total_amount - $sale->paid_amount;
                    $customer->decrement('balance', $remaining);
                }
            }
            
            // حذف الفاتورة (أو يمكنك تغيير حالة الفاتورة)
            $sale->delete();
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'تم إلغاء الفاتورة بنجاح',
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ أثناء إلغاء الفاتورة',
            ], 500);
        }
    }
}