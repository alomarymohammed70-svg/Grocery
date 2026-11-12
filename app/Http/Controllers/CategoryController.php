<?php

namespace App\Http\Controllers;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function index()
{
    $categories = Category::withCount('products')->latest()->get();
    $totalCategories = $categories->count();

    $stats = [
        'total_products'   => Product::count(),
        'low_stock_count'  => Product::whereColumn('quantity', '<=', 'minimum_quantity')->count(),
        'expiring_count'   => Product::whereNotNull('expiry_date')
                                ->where('expiry_date', '<=', now()->addDays(7))
                                ->where('expiry_date', '>', now())
                                ->count(),
        'total_value'      => Product::sum(DB::raw('quantity * purchase_price')),
        'new_this_month'   => Product::whereMonth('created_at', now()->month)->count(),
        'critical_count'   => Product::whereColumn('quantity', '<=', 'minimum_quantity')->count(),
        'value_change'     => 0,
        'good_stock'       => Product::whereColumn('quantity', '>', 'minimum_quantity')->count(),
        'total_debt' => 0,
        'debtors_count' => 0,
    ];

    return view('categories.index', compact('categories', 'totalCategories', 'stats'));
}


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'        => 'required|string|max:255|unique:categories,name',
            'description' => 'nullable|string',
            'color_code'  => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors'  => $validator->errors(),
                'message' => 'الرجاء مراجعة البيانات المدخلة'
            ]);
        }

        DB::beginTransaction();
        try {
            $category = Category::create([
                'name'        => $request->name,
                'description' => $request->description,
                'color_code'  => $request->color_code
            ]);

            DB::commit();

            // مهم: رجّع الصنف مع products_count عشان يظهر في الصف الجديد مباشرة
            $category = Category::withCount('products')->find($category->id);

            return response()->json([
                'success'  => true,
                'message'  => 'تم إضافة الصنف بنجاح',
                'category' => $category,
                'html'     => view('categories.partials.category_row', compact('category'))->render()
            ]);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ أثناء إضافة الصنف: ' . $e->getMessage()
            ]);
        }
    }

    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name'        => 'required|string|max:255|unique:categories,name,' . $category->id,
            'description' => 'nullable|string',
            'color_code'  => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors'  => $validator->errors(),
                'message' => 'الرجاء مراجعة البيانات المدخلة'
            ]);
        }

        DB::beginTransaction();
        try {
            $category->update([
                'name'        => $request->name,
                'description' => $request->description,
                'color_code'  => $request->color_code
            ]);

            DB::commit();

            // رجّعه مع products_count بعد التحديث
            $category = Category::withCount('products')->find($category->id);

            return response()->json([
                'success'  => true,
                'message'  => 'تم تحديث الصنف بنجاح',
                'category' => $category
            ]);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ أثناء تحديث الصنف: ' . $e->getMessage()
            ]);
        }
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);

        // التحقق من وجود منتجات مرتبطة
        if ($category->products()->count() > 0) {
            return response()->json([
                'success' => false,
                'message' => 'لا يمكن حذف هذا الصنف لأنه يحتوي على منتجات'
            ]);
        }

        DB::beginTransaction();
        try {
            $category->delete();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'تم حذف الصنف بنجاح'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ أثناء حذف الصنف: ' . $e->getMessage()
            ]);
        }
    }

    public function search(Request $request)
    {
        $search = $request->input('search', '');

        $categories = Category::withCount('products')
            ->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            })
            ->latest()
            ->get();

        return response()->json([
            'success'    => true,
            'categories' => $categories,
            'html'       => view('categories.partials.categories_table', compact('categories'))->render()
        ]);
    }

    public function getCategoryDetails($id)
    {
        $category = Category::with(['products' => function ($query) {
            $query->select('id', 'name', 'category_id', 'quantity', 'sale_price');
        }])->findOrFail($id);

        return response()->json([
            'success'  => true,
            'category' => $category,
            'products' => $category->products
        ]);
    }
}
