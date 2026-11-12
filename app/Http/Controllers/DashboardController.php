<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Category;
use App\Models\Supplier;
use App\Models\Purchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // بيانات الإحصائيات
        $stats = $this->getDashboardStats();
        
        // بيانات الرسوم البيانية
        $charts = $this->getChartData();
        
        // التنبيهات
        $alerts = $this->getAlerts();
        
        // المنتجات الحديثة
        $recentProducts = $this->getRecentProducts();
        
        return view('dashboard.index', compact('stats', 'charts', 'alerts', 'recentProducts'));
    }

    private function getDashboardStats()
    {
        $today = Carbon::today();
        $yesterday = Carbon::yesterday();
        $lastMonth = Carbon::now()->subMonth();
        
        return [
            'total_sales' => [
                'value' => Sale::whereDate('sale_date', $today)->sum('total_amount'),
                'change' => $this->calculateChange(
                    Sale::whereDate('sale_date', $yesterday)->sum('total_amount'),
                    Sale::whereDate('sale_date', $today)->sum('total_amount')
                ),
                'type' => 'sales'
            ],
            
            'total_products' => [
                'value' => Product::count(),
                'change' => $this->calculateChange(
                    Product::whereDate('created_at', '<', $today)->count(),
                    Product::count()
                ),
                'type' => 'products'
            ],
            
            'total_debts' => [
                'value' => Customer::sum('balance'),
                'change' => 0, // يمكن حساب التغيير إذا كان لديك سجل تاريخي
                'type' => 'debts'
            ],
            
            'total_profit' => [
                'value' => $this->calculateTodayProfit(),
                'change' => 0, // يمكن حساب التغيير إذا كان لديك سجل تاريخي
                'type' => 'profit'
            ]
        ];
    }

    private function getChartData()
    {
        $days = 7;
        $salesData = [];
        $dates = [];
        
        for ($i = $days - 1; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $dates[] = $date->format('D');
            
            $total = Sale::whereDate('sale_date', $date)
                ->sum('total_amount');
            
            $salesData[] = $total;
        }
        
        // توزيع المنتجات حسب الفئة
        $categoryDistribution = Category::withCount('products')
            ->having('products_count', '>', 0)
            ->get()
            ->pluck('products_count', 'name')
            ->toArray();
        
        return [
            'sales' => [
                'labels' => $this->translateDays($dates),
                'data' => $salesData
            ],
            'categories' => $categoryDistribution
        ];
    }

    private function getAlerts()
    {
        $alerts = [];
        
        // تنبيهات المخزون المنخفض
        $lowStockProducts = Product::whereColumn('quantity', '<=', 'minimum_quantity')
            ->orWhere('quantity', '<', 10)
            ->latest()
            ->limit(5)
            ->get();
        
        foreach ($lowStockProducts as $product) {
            $alerts[] = [
                'type' => $product->quantity < 5 ? 'critical' : 'warning',
                'icon' => 'fas fa-exclamation-triangle',
                'title' => 'نقص ' . ($product->quantity < 5 ? 'حاد' : '') . ' في المخزون',
                'message' => 'منتج "' . $product->name . '" كميته ' . $product->quantity,
                'time' => $product->updated_at->diffForHumans()
            ];
        }
        
        // تنبيهات الصلاحية
        $expiringProducts = Product::where('expiry_date', '>=', now())
            ->where('expiry_date', '<=', now()->addDays(7))
            ->latest()
            ->limit(3)
            ->get();
        
        foreach ($expiringProducts as $product) {
            $days = now()->diffInDays($product->expiry_date);
            $alerts[] = [
                'type' => 'warning',
                'icon' => 'fas fa-clock',
                'title' => 'منتج قريب من الانتهاء',
                'message' => '"' . $product->name . '" تنتهي صلاحيته خلال ' . $days . ' أيام',
                'time' => $product->updated_at->diffForHumans()
            ];
        }
        
        // تنبيهات الديون
        $highDebtCustomers = Customer::where('balance', '>', 1000)
            ->latest()
            ->limit(2)
            ->get();
        
        foreach ($highDebtCustomers as $customer) {
            $alerts[] = [
                'type' => 'info',
                'icon' => 'fas fa-users',
                'title' => 'عميل متأخر في السداد',
                'message' => $customer->name . ' مدين بمبلغ ' . number_format($customer->balance, 2) . ' ر.س',
                'time' => $customer->updated_at->diffForHumans()
            ];
        }
        
        return $alerts;
    }

    private function getRecentProducts()
    {
        return Product::with('category')
            ->latest()
            ->limit(10)
            ->get()
            ->map(function($product) {
                $status = 'normal';
                if ($product->quantity <= $product->minimum_quantity || $product->quantity < 10) {
                    $status = 'low';
                } elseif ($product->expiry_date && $product->expiry_date <= now()->addDays(7)) {
                    $status = 'expiring';
                }
                
                return [
                    'name' => $product->name,
                    'category' => $product->category->name ?? 'غير مصنف',
                    'quantity' => $product->quantity,
                    'price' => $product->sale_price,
                    'status' => $status
                ];
            });
    }

    private function calculateTodayProfit()
    {
        $today = Carbon::today();
        
        $sales = Sale::whereDate('sale_date', $today)
            ->with('items.product')
            ->get();
        
        $totalProfit = 0;
        
        foreach ($sales as $sale) {
            foreach ($sale->items as $item) {
                if ($item->product) {
                    $cost = $item->product->purchase_price * $item->quantity;
                    $revenue = $item->price * $item->quantity;
                    $totalProfit += ($revenue - $cost);
                }
            }
        }
        
        return $totalProfit;
    }

    private function calculateChange($oldValue, $newValue)
    {
        if ($oldValue == 0) {
            return $newValue > 0 ? 100 : 0;
        }
        
        return (($newValue - $oldValue) / $oldValue) * 100;
    }

    private function translateDays($englishDays)
    {
        $translations = [
            'Sat' => 'السبت',
            'Sun' => 'الأحد',
            'Mon' => 'الاثنين',
            'Tue' => 'الثلاثاء',
            'Wed' => 'الأربعاء',
            'Thu' => 'الخميس',
            'Fri' => 'الجمعة'
        ];
        
        return array_map(function($day) use ($translations) {
            return $translations[$day] ?? $day;
        }, $englishDays);
    }

    public function getStatsData(Request $request)
    {
        $period = $request->period ?? 'today';
        
        switch ($period) {
            case 'week':
                $startDate = Carbon::now()->startOfWeek();
                $endDate = Carbon::now()->endOfWeek();
                break;
            case 'month':
                $startDate = Carbon::now()->startOfMonth();
                $endDate = Carbon::now()->endOfMonth();
                break;
            case 'year':
                $startDate = Carbon::now()->startOfYear();
                $endDate = Carbon::now()->endOfYear();
                break;
            default:
                $startDate = Carbon::today();
                $endDate = Carbon::today();
        }
        
        $stats = [
            'sales' => Sale::whereBetween('sale_date', [$startDate, $endDate])->sum('total_amount'),
            'products' => Product::whereBetween('created_at', [$startDate, $endDate])->count(),
            'customers' => Customer::whereBetween('created_at', [$startDate, $endDate])->count(),
            'profit' => $this->calculateProfitForPeriod($startDate, $endDate)
        ];
        
        return response()->json($stats);
    }

    private function calculateProfitForPeriod($startDate, $endDate)
    {
        $sales = Sale::whereBetween('sale_date', [$startDate, $endDate])
            ->with('items.product')
            ->get();
        
        $totalProfit = 0;
        
        foreach ($sales as $sale) {
            foreach ($sale->items as $item) {
                if ($item->product) {
                    $cost = $item->product->purchase_price * $item->quantity;
                    $revenue = $item->price * $item->quantity;
                    $totalProfit += ($revenue - $cost);
                }
            }
        }
        
        return $totalProfit;
    }
}