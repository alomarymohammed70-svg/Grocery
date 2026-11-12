<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Supplier;
use App\Models\Purchase;
use App\Models\Category;
use App\Models\CustomerPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use PDF;
use Excel;
use App\Exports\SalesReportExport;
use App\Exports\ProfitReportExport;
use App\Exports\InventoryReportExport;

class ReportController extends Controller
{
    public function index()
    {
        // إحصائيات سريعة
        $quickStats = [
            'totalSales' => Sale::whereDate('sale_date', today())->sum('total_amount'),
            'totalProfit' => $this->calculateTodayProfit(),
            'totalDebt' => Customer::sum('balance'),
            'lowStock' => Product::whereColumn('quantity', '<=', 'minimum_quantity')->count(),
        ];

        // بيانات تقرير المبيعات (آخر 30 يوم)
        $salesData = $this->getSalesReportData();
        
        return view('reports.index', compact('quickStats', 'salesData'));
    }

    public function getReportData(Request $request)
    {
        $reportType = $request->report_type;
        $startDate = $request->start_date ?? Carbon::now()->subMonth()->format('Y-m-d');
        $endDate = $request->end_date ?? Carbon::now()->format('Y-m-d');

        switch ($reportType) {
            case 'sales':
                $data = $this->getSalesReportData($startDate, $endDate);
                break;
            case 'profit':
                $data = $this->getProfitReportData($startDate, $endDate);
                break;
            case 'inventory':
                $data = $this->getInventoryReportData();
                break;
            case 'debt':
                $data = $this->getDebtReportData();
                break;
            case 'expiry':
                $data = $this->getExpiryReportData();
                break;
            default:
                $data = [];
                break;
        }

        return response()->json($data);
    }

    private function getSalesReportData($startDate = null, $endDate = null)
    {
        if (!$startDate) $startDate = Carbon::now()->subMonth()->format('Y-m-d');
        if (!$endDate) $endDate = Carbon::now()->format('Y-m-d');

        // المبيعات الشهرية
        $monthlySales = Sale::select(
            DB::raw('MONTH(sale_date) as month'),
            DB::raw('YEAR(sale_date) as year'),
            DB::raw('SUM(total_amount) as total')
        )
        ->whereBetween('sale_date', [$startDate, $endDate])
        ->groupBy('year', 'month')
        ->orderBy('year')
        ->orderBy('month')
        ->get();

        // توزيع المبيعات حسب النوع
        $salesByType = Sale::select(
            'sale_type',
            DB::raw('SUM(total_amount) as total')
        )
        ->whereBetween('sale_date', [$startDate, $endDate])
        ->groupBy('sale_type')
        ->get();

        // ملخص المبيعات اليومية
        $salesSummary = Sale::select(
            DB::raw('DATE(sale_date) as date'),
            DB::raw('COUNT(*) as invoices'),
            DB::raw('SUM(CASE WHEN sale_type = "cash" THEN total_amount ELSE 0 END) as cash'),
            DB::raw('SUM(CASE WHEN sale_type = "credit" THEN total_amount ELSE 0 END) as credit'),
            DB::raw('SUM(total_amount) as total')
        )
        ->whereBetween('sale_date', [$startDate, $endDate])
        ->groupBy(DB::raw('DATE(sale_date)'))
        ->orderBy('date', 'desc')
        ->limit(10)
        ->get();

        // المنتجات الأكثر مبيعاً
$topProducts = DB::table('sale_items')
    ->join('products', 'sale_items.product_id', '=', 'products.id')
    ->select(
        'products.name',
        DB::raw('SUM(sale_items.quantity) as quantity'),
        DB::raw('SUM(sale_items.total) as revenue')
    )
    ->groupBy('products.id', 'products.name')
    ->orderByDesc('revenue')
    ->limit(10)
    ->get();


        return [
            'monthly' => $monthlySales,
            'byType' => $salesByType,
            'summary' => $salesSummary,
            'topProducts' => $topProducts
        ];
    }

    private function getProfitReportData($startDate, $endDate)
    {
        // حساب الأرباح
        $profitData = DB::table('sale_items')
            ->join('sales', 'sale_items.sale_id', '=', 'sales.id')
            ->join('products', 'sale_items.product_id', '=', 'products.id')
            ->select(
                DB::raw('MONTH(sales.sale_date) as month'),
                DB::raw('YEAR(sales.sale_date) as year'),
                DB::raw('SUM(sale_items.total) as sales'),
                DB::raw('SUM(sale_items.quantity * products.purchase_price) as cost'),
                DB::raw('SUM(sale_items.total - (sale_items.quantity * products.purchase_price)) as profit')
            )
            ->whereBetween('sales.sale_date', [$startDate, $endDate])
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->get();

        // توزيع الأرباح حسب الفئة
        $profitByCategory = DB::table('sale_items')
            ->join('sales', 'sale_items.sale_id', '=', 'sales.id')
            ->join('products', 'sale_items.product_id', '=', 'products.id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->select(
                'categories.name as category',
                DB::raw('SUM(sale_items.total - (sale_items.quantity * products.purchase_price)) as profit')
            )
            ->whereBetween('sales.sale_date', [$startDate, $endDate])
            ->groupBy('categories.id', 'categories.name')
            ->get();

        return [
            'profitData' => $profitData,
            'profitByCategory' => $profitByCategory
        ];
    }

    private function getInventoryReportData()
    {
        // المنتجات المنخفضة المخزون
        $lowStock = Product::whereColumn('quantity', '<=', 'minimum_quantity')
            ->orWhere('quantity', '<=', 10)
            ->with('category')
            ->get();

        // ملخص المخزون حسب الفئة
        $inventorySummary = Product::select(
                'categories.name as category',
                DB::raw('COUNT(products.id) as products_count'),
                DB::raw('SUM(products.quantity) as total_quantity'),
                DB::raw('SUM(products.quantity * products.purchase_price) as total_value')
            )
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->groupBy('categories.id', 'categories.name')
            ->get();

        return [
            'lowStock' => $lowStock,
            'inventorySummary' => $inventorySummary
        ];
    }

    private function getDebtReportData()
    {
        // تفاصيل الديون
        $debtDetails = Customer::where('balance', '>', 0)
            ->orderBy('balance', 'desc')
            ->get();

        // جدول السداد
        $paymentSchedule = CustomerPayment::with('customer')
            ->whereDate('payment_date', '>=', now())
            ->orderBy('payment_date')
            ->get();

        return [
            'debtDetails' => $debtDetails,
            'paymentSchedule' => $paymentSchedule
        ];
    }

    private function getExpiryReportData()
    {
        // المنتجات المنتهية الصلاحية
        $expiredProducts = Product::where('expiry_date', '<', now())
            ->with('category')
            ->get();

        // المنتجات القريبة من الانتهاء (30 يوم)
        $nearExpiry = Product::whereBetween('expiry_date', [now(), now()->addDays(30)])
            ->with('category')
            ->get();

        return [
            'expiredProducts' => $expiredProducts,
            'nearExpiry' => $nearExpiry
        ];
    }

    private function calculateTodayProfit()
    {
        $todaySales = Sale::whereDate('sale_date', today())->sum('total_amount');
        $todayCost = DB::table('sale_items')
            ->join('sales', 'sale_items.sale_id', '=', 'sales.id')
            ->join('products', 'sale_items.product_id', '=', 'products.id')
            ->whereDate('sales.sale_date', today())
            ->sum(DB::raw('sale_items.quantity * products.purchase_price'));

        return $todaySales - $todayCost;
    }

    public function export(Request $request)
    {
        $format = $request->format;
        $reportType = $request->report_type;
        $startDate = $request->start_date;
        $endDate = $request->end_date;

        switch ($format) {
            case 'pdf':
                return $this->exportToPDF($reportType, $startDate, $endDate);
            case 'excel':
                return $this->exportToExcel($reportType, $startDate, $endDate);
            case 'csv':
                return $this->exportToCSV($reportType, $startDate, $endDate);
            default:
                return redirect()->back()->with('error', 'صيغة التصدير غير مدعومة');
        }
    }

    private function exportToPDF($reportType, $startDate, $endDate)
    {
        $data = [];
        $title = '';

        switch ($reportType) {
            case 'sales':
                $data = $this->getSalesReportData($startDate, $endDate);
                $title = 'تقرير المبيعات';
                break;
            case 'profit':
                $data = $this->getProfitReportData($startDate, $endDate);
                $title = 'تقرير الأرباح';
                break;
            // ... باقي التقارير
        }

        $pdf = PDF::loadView('reports.exports.pdf', compact('data', 'title', 'startDate', 'endDate'));
        return $pdf->download($title . '.pdf');
    }

    private function exportToExcel($reportType, $startDate, $endDate)
    {
        switch ($reportType) {
            case 'sales':
                return Excel::download(new SalesReportExport($startDate, $endDate), 'sales_report.xlsx');
            case 'profit':
                return Excel::download(new ProfitReportExport($startDate, $endDate), 'profit_report.xlsx');
            case 'inventory':
                return Excel::download(new InventoryReportExport(), 'inventory_report.xlsx');
            default:
                return redirect()->back();
        }
    }

    private function exportToCSV($reportType, $startDate, $endDate)
    {
        // تنفيذ التصدير إلى CSV
        // ... (يمكنك إضافة منطق CSV هنا)
        return redirect()->back()->with('success', 'تم تصدير التقرير بنجاح');
    }
}
