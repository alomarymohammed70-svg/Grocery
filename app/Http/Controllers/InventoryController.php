<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Carbon\Carbon;
use DB;

class InventoryController extends Controller
{
    public function index()
    {
        // قيمة قرب الانتهاء من settings
        $expiryDays = DB::table('settings')
            ->where('key', 'product_expiry_days')
            ->value('value') ?? 7;

        // إحصائيات
        $totalProducts = Product::count();

        $lowStockCount = Product::whereColumn('quantity', '<=', 'minimum_quantity')->count();

        $expiringCount = Product::whereNotNull('expiry_date')
            ->whereDate('expiry_date', '>=', now())
            ->whereDate('expiry_date', '<=', now()->addDays($expiryDays))
            ->count();

        $totalValue = Product::sum(DB::raw('quantity * purchase_price'));

        $stats = [
    'total_products'   => $totalProducts,
    'low_stock_count'  => $lowStockCount,
    'expiring_count'   => $expiringCount,
    'total_value'      => $totalValue,
    'value_change'     => 0,
    'new_this_month'   => 0,
    'critical_count'   => $lowStockCount,
];


        // البيانات الأولية
        $categories = Category::all();

        $products = Product::with('category')
            ->orderBy('name')
            ->paginate(10);

        // تنبيهات
        $lowStockAlerts = Product::whereColumn('quantity', '<=', 'minimum_quantity')
            ->limit(10)
            ->get()
            ->map(function ($product) {
                return [
                    'product_id' => $product->id,
                    'type' => 'critical',
                    'message' => "المنتج {$product->name} وصل للحد الأدنى ({$product->quantity})",
                    'is_critical' => true,
                ];
            });

        $expiryAlerts = Product::whereNotNull('expiry_date')
            ->whereDate('expiry_date', '<=', now()->addDays($expiryDays))
            ->get()
            ->map(function ($product) {
                return [
                    'product_id' => $product->id,
                    'message' => "المنتج {$product->name} تاريخ انتهائه {$product->expiry_date}",
                    'is_expired' => $product->expiry_date < now(),
                ];
            });

    $movementData = [
    'labels'    => [],
    'sales'     => [],
    'purchases' => [],
];


       return view('inventory.index', compact(
    'stats',
    'categories',
    'products',
    'lowStockAlerts',
    'expiryAlerts',
    'movementData' // ✅ مهم
));

    }

    // AJAX: جدول المخزون
    public function table(Request $request)
    {
        $query = Product::with('category');

        if ($request->status) {
            if ($request->status === 'low') {
                $query->whereColumn('quantity', '<=', 'minimum_quantity');
            }
        }

        if ($request->category) {
            $query->where('category_id', $request->category);
        }

        $products = $query->orderBy('name')->paginate(10);

        return response()->json([
            'html' => view('inventory._table', compact('products'))->render(),
            'total' => $products->total()
        ]);
    }

    // AJAX: التنبيهات
    public function alerts()
    {
        $lowStock = Product::whereColumn('quantity', '<=', 'minimum_quantity')->get();
        return view('inventory._alerts', compact('lowStock'));
    }
}
