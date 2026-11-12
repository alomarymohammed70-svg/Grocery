<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\Supplier;
use App\Models\Product;
use App\Models\PurchaseItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PurchaseController extends Controller
{
    public function index()
    {
        $purchases = Purchase::with('supplier')->latest()->paginate(20);
        return view('purchases.index', compact('purchases'));
    }

    public function create()
    {
        $suppliers = Supplier::where('status', 'active')->get();
        $products = Product::with('category')->get();
        
        $invoiceNumber = 'PUR-' . date('Ymd') . '-' . str_pad(Purchase::count() + 1, 3, '0', STR_PAD_LEFT);
        
        return view('purchases.create', compact('suppliers', 'products', 'invoiceNumber'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'invoice_number' => 'required|unique:purchases',
            'purchase_date' => 'required|date',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.purchase_price' => 'required|numeric|min:0',
            'subtotal' => 'required|numeric|min:0',
            'tax' => 'required|numeric|min:0',
            'discount' => 'required|numeric|min:0',
            'total' => 'required|numeric|min:0',
            'payment_method' => 'required|in:cash,transfer,credit',
            'notes' => 'nullable|string'
        ]);

        DB::beginTransaction();
        try {
            // إنشاء الفاتورة
            $purchase = Purchase::create([
                'supplier_id' => $validated['supplier_id'],
                'invoice_number' => $validated['invoice_number'],
                'purchase_date' => $validated['purchase_date'],
                'subtotal' => $validated['subtotal'],
                'tax' => $validated['tax'],
                'discount' => $validated['discount'],
                'total' => $validated['total'],
                'payment_method' => $validated['payment_method'],
                'notes' => $validated['notes'] ?? null,
                'status' => 'completed'
            ]);

            // إضافة العناصر
            foreach ($validated['items'] as $item) {
                $purchaseItem = PurchaseItem::create([
                    'purchase_id' => $purchase->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'purchase_price' => $item['purchase_price'],
                    'total' => $item['quantity'] * $item['purchase_price']
                ]);

                // تحديث مخزون المنتج
                $product = Product::find($item['product_id']);
                $product->increment('quantity', $item['quantity']);
                $product->update([
                    'purchase_price' => $item['purchase_price']
                ]);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'تم حفظ فاتورة الشراء بنجاح',
                'purchase_id' => $purchase->id
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ أثناء حفظ الفاتورة: ' . $e->getMessage()
            ], 500);
        }
    }

    public function show(Purchase $purchase)
    {
        $purchase->load(['supplier', 'items.product']);
        return view('purchases.show', compact('purchase'));
    }

    public function getSuppliers()
    {
        $suppliers = Supplier::where('status', 'active')->get();
        return response()->json($suppliers);
    }

    public function getProducts()
    {
        $products = Product::with('category')->get();
        return response()->json($products);
    }

    public function generateInvoiceNumber()
    {
        $count = Purchase::whereDate('created_at', today())->count() + 1;
        $invoiceNumber = 'PUR-' . date('Ymd') . '-' . str_pad($count, 3, '0', STR_PAD_LEFT);
        
        return response()->json(['invoice_number' => $invoiceNumber]);
    }
}