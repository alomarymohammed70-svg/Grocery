<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')
            ->latest()
            ->paginate(20);
            
        $categories = Category::all();
        $totalProducts = Product::count();
        $lowStockProducts = Product::whereColumn('quantity', '<=', 'minimum_quantity')->count();
        
        return view('products.index', compact('products', 'categories', 'totalProducts', 'lowStockProducts'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'barcode' => 'required|string|unique:products,barcode',
            'purchase_price' => 'required|numeric|min:0',
            'sale_price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'minimum_quantity' => 'nullable|integer|min:0',
            'expiry_date' => 'nullable|date',
            'description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
                'message' => 'الرجاء مراجعة البيانات المدخلة'
            ]);
        }

        DB::beginTransaction();
        try {
            $product = Product::create([
                'name' => $request->name,
                'category_id' => $request->category_id,
                'barcode' => $request->barcode,
                'purchase_price' => $request->purchase_price,
                'sale_price' => $request->sale_price,
                'quantity' => $request->quantity,
                'minimum_quantity' => $request->minimum_quantity ?? 10,
                'expiry_date' => $request->expiry_date,
                'description' => $request->description,
                'status' => 'active'
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'تم إضافة المنتج بنجاح',
                'product' => $product->load('category'),
                'html' => view('products.partials.product_row', ['product' => $product])->render()
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ أثناء إضافة المنتج: ' . $e->getMessage()
            ]);
        }
    }

   public function update(Request $request, $id)
{
    try {
        $product = Product::findOrFail($id);
        
        // إذا كانت البيانات تأتي من modal المخزون (بيانات محدودة)
        if ($request->ajax() || $request->wantsJson()) {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'quantity' => 'required|integer|min:0',
                'minimum_quantity' => 'nullable|integer|min:1',
                'purchase_price' => 'required|numeric|min:0',
                'expiry_date' => 'nullable|date',
            ]);
        } else {
            // إذا كانت البيانات تأتي من صفحة المنتجات الكاملة
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'category_id' => 'required|exists:categories,id',
                'barcode' => 'required|string|unique:products,barcode,' . $product->id,
                'purchase_price' => 'required|numeric|min:0',
                'sale_price' => 'required|numeric|min:0',
                'quantity' => 'required|integer|min:0',
                'minimum_quantity' => 'nullable|integer|min:1',
                'expiry_date' => 'nullable|date',
                'description' => 'nullable|string',
            ]);
        }

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
                'message' => 'الرجاء مراجعة البيانات المدخلة'
            ]);
        }

        DB::beginTransaction();
        
        try {
            // تحديث البيانات الأساسية
            $product->name = $request->name;
            $product->quantity = $request->quantity;
            $product->minimum_quantity = $request->minimum_quantity ?? 10;
            $product->purchase_price = $request->purchase_price;
            $product->expiry_date = $request->expiry_date;
            
            // تحديث البيانات الإضافية إذا وجدت
            if ($request->has('category_id')) {
                $product->category_id = $request->category_id;
            }
            
            if ($request->has('sale_price')) {
                $product->sale_price = $request->sale_price;
            }
            
            if ($request->has('barcode')) {
                $product->barcode = $request->barcode;
            }
            
            if ($request->has('description')) {
                $product->description = $request->description;
            }
            
            $product->save();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'تم تحديث المنتج بنجاح',
                'product' => $product->load('category')
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ أثناء تحديث المنتج: ' . $e->getMessage()
            ]);
        }
        
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'المنتج غير موجود'
        ]);
    }
}

    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        // التحقق من عدم وجود عمليات بيع مرتبطة
        if ($product->saleItems()->count() > 0) {
            return response()->json([
                'success' => false,
                'message' => 'لا يمكن حذف المنتج لأنه مرتبط بعمليات بيع'
            ]);
        }

        // التحقق من عدم وجود مشتريات مرتبطة
        if ($product->purchaseItems()->count() > 0) {
            return response()->json([
                'success' => false,
                'message' => 'لا يمكن حذف المنتج لأنه مرتبط بمشتريات'
            ]);
        }

        DB::beginTransaction();
        try {
            $product->delete();
            
            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'تم حذف المنتج بنجاح'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ أثناء حذف المنتج: ' . $e->getMessage()
            ]);
        }
    }

    public function search(Request $request)
    {
        $search = $request->input('search', '');
        $categoryId = $request->input('category_id');
        $statusFilter = $request->input('status');
        
        $query = Product::with('category');
        
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('barcode', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }
        
        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }
        
        if ($statusFilter) {
            if ($statusFilter === 'low') {
                $query->whereColumn('quantity', '<=', 'minimum_quantity');
            } elseif ($statusFilter === 'expiring') {
                $query->whereNotNull('expiry_date')
                      ->where('expiry_date', '<=', now()->addDays(7))
                      ->where('expiry_date', '>', now());
            } elseif ($statusFilter === 'expired') {
                $query->whereNotNull('expiry_date')
                      ->where('expiry_date', '<', now());
            }
        }
        
        $products = $query->latest()->get();
        
        return response()->json([
            'success' => true,
            'products' => $products,
            'html' => view('products.partials.products_table', compact('products'))->render()
        ]);
    }

    public function getProductDetails($id)
    {
        $product = Product::with('category')->findOrFail($id);
        
        return response()->json([
            'success' => true,
            'product' => $product
        ]);
    }

    public function generateBarcode()
    {
        $barcode = 'PRD-' . date('Ymd') . '-' . strtoupper(Str::random(6));
        
        return response()->json([
            'success' => true,
            'barcode' => $barcode
        ]);
    }

    public function checkBarcode($barcode)
    {
        $exists = Product::where('barcode', $barcode)->exists();
        
        return response()->json([
            'success' => true,
            'exists' => $exists
        ]);
    }

    public function updateStock(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        
        $validator = Validator::make($request->all(), [
            'quantity' => 'required|integer|min:0',
            'operation' => 'required|in:add,subtract'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ]);
        }

        DB::beginTransaction();
        try {
            if ($request->operation === 'add') {
                $product->increment('quantity', $request->quantity);
            } else {
                if ($product->quantity < $request->quantity) {
                    throw new \Exception('الكمية المتاحة أقل من الكمية المراد خصمها');
                }
                $product->decrement('quantity', $request->quantity);
            }
            
            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'تم تحديث المخزون بنجاح',
                'new_quantity' => $product->quantity
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function getStats()
    {
        $stats = [
            'total_products' => Product::count(),
            'total_value' => Product::sum(DB::raw('quantity * purchase_price')),
            'low_stock' => Product::whereColumn('quantity', '<=', 'minimum_quantity')->count(),
            'expiring_soon' => Product::whereNotNull('expiry_date')
                ->where('expiry_date', '<=', now()->addDays(7))
                ->where('expiry_date', '>', now())
                ->count(),
        ];
        
        return response()->json([
            'success' => true,
            'stats' => $stats
        ]);
    }
public function edit($id)
{
    $product = Product::findOrFail($id);

    return response()->json([
        'success' => true,
        'product' => $product
    ]);
}

}
