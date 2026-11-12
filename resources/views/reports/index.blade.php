<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>التقارير | نظام إدارة البقالة</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/sidebar.css') }}">

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700&display=swap');

        :root {
            --success-color: #34c759;
            --warning-color: #ff9500;
            --danger-color: #ff3b30;
            --dark-color: #1c1c1e;
            --light-color: #f2f2f7;
            --sidebar-width: 280px;
            --header-height: 70px;
            --transition-speed: 0.3s;
            --border-radius: 16px;
        }
.logout-item{
    width: 100%;
    border: none;
    background: transparent;
    text-align: right;
    cursor: pointer;
}

.logout-item:hover{
    background: rgba(255, 80, 80, 0.12);
}

.logout-item i{
    color: #ff6b6b;
}
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Tajawal', sans-serif;
            background-color: #f2f2f7;
            color: #1c1c1e;
            min-height: 100vh;
            overflow-x: hidden;
        }

        .dashboard-container {
            display: flex;
            min-height: 100vh;
        }

        /* المحتوى الرئيسي */
        .main-content {
            flex: 1;
            padding: 20px;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* شريط العنوان العلوي */
        .top-bar {
            background: white;
            border-radius: var(--border-radius);
            padding: 20px 25px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            margin-bottom: 20px;
            flex-shrink: 0;
        }

        .page-title {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .page-title h1 {
            font-size: 28px;
            font-weight: 700;
            color: var(--dark-color);
        }

        .page-title p {
            color: #8e8e93;
            font-size: 15px;
            margin-top: 5px;
        }

        .top-bar-actions {
            display: flex;
            gap: 15px;
            align-items: center;
        }

        /* زر التصدير */
        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 12px;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 10px;
            transition: all var(--transition-speed) ease;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 102, 255, 0.3);
        }

        .btn-secondary {
            background: white;
            color: var(--dark-color);
            border: 1px solid #e5e5ea;
            padding: 12px 24px;
            border-radius: 12px;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 10px;
            transition: all var(--transition-speed) ease;
        }

        .btn-secondary:hover {
            background: #f2f2f7;
            transform: translateY(-2px);
        }

        /* أزرار التحكم بالتقارير */
        .report-controls {
            display: flex;
            gap: 15px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }

        .report-tabs {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            flex: 1;
        }

        .report-tab {
            padding: 12px 24px;
            background: white;
            border: 2px solid #e5e5ea;
            border-radius: 12px;
            font-weight: 500;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all var(--transition-speed) ease;
            min-width: 120px;
            justify-content: center;
        }

        .report-tab:hover {
            border-color: var(--primary-color);
            color: var(--primary-color);
        }

        .report-tab.active {
            background: var(--primary-color);
            border-color: var(--primary-color);
            color: white;
        }

        .date-filter {
            display: flex;
            gap: 10px;
            align-items: center;
            background: white;
            padding: 12px 20px;
            border-radius: 12px;
            border: 1px solid #e5e5ea;
        }

        .date-filter input {
            border: 1px solid #e5e5ea;
            border-radius: 8px;
            padding: 8px 12px;
            font-family: inherit;
        }

        .date-filter button {
            padding: 8px 16px;
            background: var(--primary-color);
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 500;
        }

        /* إحصائيات سريعة */
        .quick-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 20px;
            margin-bottom: 25px;
        }

        .stat-card {
            background: white;
            border-radius: var(--border-radius);
            padding: 25px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            display: flex;
            align-items: center;
            gap: 20px;
            transition: all var(--transition-speed) ease;
            border-top: 4px solid transparent;
        }

        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 24px rgba(0,0,0,0.1);
        }

        .stat-card.sales {
            border-top-color: var(--primary-color);
        }

        .stat-card.profit {
            border-top-color: var(--success-color);
        }

        .stat-card.debt {
            border-top-color: var(--warning-color);
        }

        .stat-card.inventory {
            border-top-color: var(--secondary-color);
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            color: white;
            flex-shrink: 0;
        }

        .stat-card.sales .stat-icon {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        }

        .stat-card.profit .stat-icon {
            background: linear-gradient(135deg, var(--success-color), #4cd964);
        }

        .stat-card.debt .stat-icon {
            background: linear-gradient(135deg, var(--warning-color), #ffcc00);
        }

        .stat-card.inventory .stat-icon {
            background: linear-gradient(135deg, var(--secondary-color), #5ac8fa);
        }

        .stat-content {
            flex: 1;
        }

        .stat-value {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 5px;
            line-height: 1;
        }

        .stat-label {
            color: #8e8e93;
            font-size: 14px;
            margin-bottom: 8px;
        }

        .stat-trend {
            display: flex;
            align-items: center;
            gap: 5px;
            font-size: 12px;
            font-weight: 500;
        }

        .stat-trend.positive {
            color: var(--success-color);
        }

        .stat-trend.negative {
            color: var(--danger-color);
        }

        /* محتوى التقارير */
        .reports-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .report-section {
            background: white;
            border-radius: var(--border-radius);
            padding: 30px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            display: none;
        }

        .report-section.active {
            display: block;
            animation: fadeIn 0.5s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 2px solid #f2f2f7;
        }

        .section-header h2 {
            font-size: 20px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        /* الرسوم البيانية */
        .charts-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
            gap: 25px;
            margin-bottom: 30px;
        }

        .chart-card {
            background: white;
            border-radius: var(--border-radius);
            padding: 25px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            border: 1px solid #f2f2f7;
        }

        .chart-card h3 {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .chart-wrapper {
            position: relative;
            height: 300px;
            width: 100%;
        }

        /* الجداول */
        .tables-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(500px, 1fr));
            gap: 25px;
        }

        .table-card {
            background: white;
            border-radius: var(--border-radius);
            padding: 25px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            border: 1px solid #f2f2f7;
            display: flex;
            flex-direction: column;
        }

        .table-card h3 {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .table-scroll {
            overflow-x: auto;
            flex: 1;
        }

        .report-table {
            width: 100%;
            border-collapse: collapse;
            min-width: 600px;
        }

        .report-table th {
            text-align: right;
            padding: 15px;
            color: #8e8e93;
            font-weight: 500;
            border-bottom: 2px solid #e5e5ea;
            background: #fafafa;
            position: sticky;
            top: 0;
        }

        .report-table td {
            padding: 15px;
            border-bottom: 1px solid #f2f2f7;
            text-align: right;
        }

        .report-table tbody tr:hover {
            background: #fafafa;
        }

        .badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 500;
        }

        .badge-success {
            background: rgba(52, 199, 89, 0.1);
            color: var(--success-color);
        }

        .badge-warning {
            background: rgba(255, 149, 0, 0.1);
            color: var(--warning-color);
        }

        .badge-danger {
            background: rgba(255, 59, 48, 0.1);
            color: var(--danger-color);
        }

        .badge-info {
            background: rgba(0, 122, 255, 0.1);
            color: var(--primary-color);
        }

        /* حالة النفاد */
        .stock-level {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 10px;
            font-size: 12px;
            font-weight: 500;
        }

        .stock-level.low {
            background: rgba(255, 59, 48, 0.1);
            color: var(--danger-color);
        }

        .stock-level.medium {
            background: rgba(255, 149, 0, 0.1);
            color: var(--warning-color);
        }

        .stock-level.high {
            background: rgba(52, 199, 89, 0.1);
            color: var(--success-color);
        }

        /* نافذة التصدير */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
            background: rgba(0,0,0,0.5);
            z-index: 2000;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .modal.active {
            display: flex;
        }

        .modal-content {
            background: white;
            border-radius: 20px;
            width: 100%;
            max-width: 500px;
            max-height: 90vh;
            overflow-y: auto;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        }

        .modal-header {
            padding: 25px;
            border-bottom: 1px solid #e5e5ea;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .modal-header h3 {
            font-size: 20px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .btn-close {
            background: none;
            border: none;
            font-size: 20px;
            color: #8e8e93;
            cursor: pointer;
            padding: 5px;
            transition: color var(--transition-speed) ease;
        }

        .btn-close:hover {
            color: var(--danger-color);
        }

        .modal-body {
            padding: 25px;
        }

        .export-options {
            display: grid;
            gap: 15px;
        }

        .export-option {
            padding: 15px;
            border: 2px solid #e5e5ea;
            border-radius: 12px;
            cursor: pointer;
            transition: all var(--transition-speed) ease;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .export-option:hover {
            border-color: var(--primary-color);
        }

        .export-option.selected {
            border-color: var(--primary-color);
            background: rgba(0, 102, 255, 0.1);
        }

        .export-option i {
            font-size: 24px;
            color: var(--primary-color);
        }

        .export-option-content h4 {
            font-weight: 600;
            margin-bottom: 5px;
        }

        .export-option-content p {
            color: #8e8e93;
            font-size: 14px;
        }

        .modal-footer {
            padding: 25px;
            border-top: 1px solid #e5e5ea;
            display: flex;
            justify-content: flex-end;
            gap: 15px;
        }

        /* زر القائمة المتنقلة للجوّال */
        .mobile-menu-btn {
            display: none;
            background: none;
            border: none;
            font-size: 24px;
            color: var(--dark-color);
            cursor: pointer;
            padding: 10px;
            transition: color var(--transition-speed) ease;
        }

        .mobile-menu-btn:hover {
            color: var(--primary-color);
        }

        /* تصميم للجوّال */
        @media (max-width: 1024px) {
            .charts-container {
                grid-template-columns: 1fr;
            }
            
            .tables-container {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 768px) {
           
            
            .mobile-menu-btn {
                display: block;
            }
            
            .top-bar {
                flex-direction: column;
                gap: 15px;
                align-items: flex-start;
            }
            
            .top-bar-actions {
                width: 100%;
                justify-content: flex-start;
            }
            
            .report-controls {
                flex-direction: column;
            }
            
            .report-tabs {
                width: 100%;
            }
            
            .report-tab {
                flex: 1;
                min-width: calc(50% - 5px);
                text-align: center;
                justify-content: center;
            }
            
            .date-filter {
                width: 100%;
                justify-content: space-between;
            }
            
            .quick-stats {
                grid-template-columns: 1fr;
            }
            
            .chart-card, .table-card {
                min-width: 100%;
            }
            
            .table-scroll {
                min-height: 0;
            }
        }

        @media (max-width: 480px) {
            .report-tab {
                min-width: 100%;
            }
            
            .date-filter {
                flex-direction: column;
                align-items: stretch;
            }
            
            .section-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }
            
            .modal-footer {
                flex-direction: column;
            }
            
            .modal-footer button {
                width: 100%;
            }
        }

        /* تحسينات التمرير */
        ::-webkit-scrollbar {
            width: 6px;
        }

        ::-webkit-scrollbar-track {
            background: #f2f2f7;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb {
            background: #c7c7cc;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #8e8e93;
        }

        /* حالة فارغة */
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #8e8e93;
        }

        .empty-state i {
            font-size: 64px;
            margin-bottom: 20px;
            opacity: 0.3;
        }

        .empty-state p {
            font-size: 18px;
            margin-bottom: 10px;
        }

        .empty-state small {
            font-size: 14px;
        }

        /* رسالة التنبيه */
        .alert-message {
            position: fixed;
            top: 20px;
            right: 20px;
            background: var(--success-color);
            color: white;
            padding: 15px 25px;
            border-radius: 12px;
            display: none;
            align-items: center;
            gap: 10px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.2);
            z-index: 3000;
            transform: translateX(150%);
            transition: transform 0.3s ease;
        }

        .alert-message.show {
            display: flex;
        }

        .alert-message.error {
            background: var(--danger-color);
        }

        .alert-message.warning {
            background: var(--warning-color);
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <!-- الشريط الجانبي -->
        @include('partials.sidebar')

        
        <!-- المحتوى الرئيسي -->
        <div class="main-content">
            <!-- شريط العنوان العلوي -->
            <div class="top-bar">
                <div class="page-title">
                    <button class="mobile-menu-btn" onclick="toggleSidebar()">
                        <i class="fas fa-bars"></i>
                    </button>
                    <div>
                        <h1>التقارير والإحصائيات</h1>
                        <p>متابعة أداء المتجر واتخاذ قرارات مبنية على بيانات دقيقة</p>
                    </div>
                </div>
                
                <div class="top-bar-actions">
                    <button class="btn-primary" onclick="openExportModal()">
                        <i class="fas fa-download"></i>
                        تصدير تقرير
                    </button>
                </div>
            </div>
            
            <!-- إحصائيات سريعة -->
            <div class="quick-stats">
                <div class="stat-card sales">
                    <div class="stat-icon">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-value" id="totalSales">{{ number_format($quickStats['totalSales'], 2) }} ر.س</div>
                        <div class="stat-label">إجمالي المبيعات اليوم</div>
                        <div class="stat-trend positive">
                            <i class="fas fa-arrow-up"></i>
                            <span>12% عن الأمس</span>
                        </div>
                    </div>
                </div>
                
                <div class="stat-card profit">
                    <div class="stat-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-value" id="totalProfit">{{ number_format($quickStats['totalProfit'], 2) }} ر.س</div>
                        <div class="stat-label">الأرباح اليوم</div>
                        <div class="stat-trend positive">
                            <i class="fas fa-arrow-up"></i>
                            <span>8% عن الأمس</span>
                        </div>
                    </div>
                </div>
                
                <div class="stat-card debt">
                    <div class="stat-icon">
                        <i class="fas fa-money-bill-wave"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-value" id="totalDebt">{{ number_format($quickStats['totalDebt'], 2) }} ر.س</div>
                        <div class="stat-label">إجمالي الديون</div>
                        <div class="stat-trend negative">
                            <i class="fas fa-arrow-down"></i>
                            <span>5% عن الشهر الماضي</span>
                        </div>
                    </div>
                </div>
                
                <div class="stat-card inventory">
                    <div class="stat-icon">
                        <i class="fas fa-warehouse"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-value" id="lowStock">{{ $quickStats['lowStock'] }}</div>
                        <div class="stat-label">منتجات منخفضة المخزون</div>
                        <div class="stat-trend warning">
                            <i class="fas fa-exclamation-triangle"></i>
                            <span>تحتاج للتزويد</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- تحكم التقارير -->
            <div class="report-controls">
                <div class="report-tabs">
                    <button class="report-tab active" onclick="switchReport('sales')">
                        <i class="fas fa-shopping-cart"></i>
                        تقرير المبيعات
                    </button>
                    <button class="report-tab" onclick="switchReport('profit')">
                        <i class="fas fa-chart-line"></i>
                        تقرير الأرباح
                    </button>
                    <button class="report-tab" onclick="switchReport('inventory')">
                        <i class="fas fa-warehouse"></i>
                        تقرير المخزون
                    </button>
                    <button class="report-tab" onclick="switchReport('debt')">
                        <i class="fas fa-users"></i>
                        تقرير الديون
                    </button>
                    <button class="report-tab" onclick="switchReport('expiry')">
                        <i class="fas fa-calendar-times"></i>
                        تقرير الصلاحية
                    </button>
                </div>
                
                <div class="date-filter">
                    <input type="date" id="startDate" value="{{ date('Y-m-d', strtotime('-30 days')) }}">
                    <span>إلى</span>
                    <input type="date" id="endDate" value="{{ date('Y-m-d') }}">
                    <button onclick="applyDateFilter()">
                        <i class="fas fa-filter"></i>
                        تطبيق
                    </button>
                </div>
            </div>
            
            <!-- محتوى التقارير -->
            <div class="reports-content">
                <!-- تقرير المبيعات -->
                <div id="sales-report" class="report-section active">
                    <div class="section-header">
                        <h2><i class="fas fa-shopping-cart"></i> تقرير المبيعات</h2>
                        <div class="section-actions">
                            <button class="btn-secondary" onclick="printReport('sales')">
                                <i class="fas fa-print"></i>
                                طباعة التقرير
                            </button>
                        </div>
                    </div>
                    
                    <div class="charts-container">
                        <div class="chart-card">
                            <h3><i class="fas fa-chart-bar"></i> المبيعات الشهرية</h3>
                            <div class="chart-wrapper">
                                <canvas id="monthlySalesChart"></canvas>
                            </div>
                        </div>
                        
                        <div class="chart-card">
                            <h3><i class="fas fa-chart-pie"></i> توزيع المبيعات حسب النوع</h3>
                            <div class="chart-wrapper">
                                <canvas id="salesByTypeChart"></canvas>
                            </div>
                        </div>
                    </div>
                    
                    <div class="tables-container">
                        <div class="table-card">
                            <h3><i class="fas fa-receipt"></i> ملخص المبيعات</h3>
                            <div class="table-scroll">
                                <table class="report-table">
                                    <thead>
                                        <tr>
                                            <th>التاريخ</th>
                                            <th>عدد الفواتير</th>
                                            <th>المبيعات النقدية</th>
                                            <th>المبيعات الآجلة</th>
                                            <th>الإجمالي</th>
                                        </tr>
                                    </thead>
                                    <tbody id="salesSummaryTable">
                                        <!-- سيتم تعبئة البيانات عن طريق JavaScript -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        
                        <div class="table-card">
                            <h3><i class="fas fa-star"></i> المنتجات الأكثر مبيعاً</h3>
                            <div class="table-scroll">
                                <table class="report-table">
                                    <thead>
                                        <tr>
                                            <th>المنتج</th>
                                            <th>الكمية المباعة</th>
                                            <th>إجمالي المبيعات</th>
                                            <th>النسبة</th>
                                        </tr>
                                    </thead>
                                    <tbody id="topProductsTable">
                                        <!-- سيتم تعبئة البيانات عن طريق JavaScript -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- تقرير الأرباح -->
                <div id="profit-report" class="report-section">
                    <div class="section-header">
                        <h2><i class="fas fa-chart-line"></i> تقرير الأرباح</h2>
                        <div class="section-actions">
                            <button class="btn-secondary" onclick="printReport('profit')">
                                <i class="fas fa-print"></i>
                                طباعة التقرير
                            </button>
                        </div>
                    </div>
                    
                    <div class="charts-container">
                        <div class="chart-card">
                            <h3><i class="fas fa-chart-line"></i> تطور الأرباح الشهرية</h3>
                            <div class="chart-wrapper">
                                <canvas id="monthlyProfitChart"></canvas>
                            </div>
                        </div>
                        
                        <div class="chart-card">
                            <h3><i class="fas fa-chart-pie"></i> توزيع الأرباح حسب الفئة</h3>
                            <div class="chart-wrapper">
                                <canvas id="profitByCategoryChart"></canvas>
                            </div>
                        </div>
                    </div>
                    
                    <div class="tables-container">
                        <div class="table-card">
                            <h3><i class="fas fa-calculator"></i> ملخص الأرباح</h3>
                            <div class="table-scroll">
                                <table class="report-table">
                                    <thead>
                                        <tr>
                                            <th>الشهر</th>
                                            <th>المبيعات</th>
                                            <th>تكلفة المشتريات</th>
                                            <th>الأرباح</th>
                                            <th>هامش الربح</th>
                                        </tr>
                                    </thead>
                                    <tbody id="profitSummaryTable">
                                        <!-- سيتم تعبئة البيانات عن طريق JavaScript -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        
                        <div class="table-card">
                            <h3><i class="fas fa-trophy"></i> المنتجات الأعلى ربحية</h3>
                            <div class="table-scroll">
                                <table class="report-table">
                                    <thead>
                                        <tr>
                                            <th>المنتج</th>
                                            <th>سعر البيع</th>
                                            <th>سعر الشراء</th>
                                            <th>هامش الربح</th>
                                            <th>إجمالي الربح</th>
                                        </tr>
                                    </thead>
                                    <tbody id="topProfitableProductsTable">
                                        <!-- سيتم تعبئة البيانات عن طريق JavaScript -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- تقرير المخزون -->
                <div id="inventory-report" class="report-section">
                    <div class="section-header">
                        <h2><i class="fas fa-warehouse"></i> تقرير المخزون</h2>
                        <div class="section-actions">
                            <button class="btn-secondary" onclick="printReport('inventory')">
                                <i class="fas fa-print"></i>
                                طباعة التقرير
                            </button>
                        </div>
                    </div>
                    
                    <div class="charts-container">
                        <div class="chart-card">
                            <h3><i class="fas fa-chart-pie"></i> توزيع المخزون حسب الفئة</h3>
                            <div class="chart-wrapper">
                                <canvas id="inventoryByCategoryChart"></canvas>
                            </div>
                        </div>
                        
                        <div class="chart-card">
                            <h3><i class="fas fa-chart-bar"></i> قيمة المخزون حسب المنتج</h3>
                            <div class="chart-wrapper">
                                <canvas id="inventoryValueChart"></canvas>
                            </div>
                        </div>
                    </div>
                    
                    <div class="tables-container">
                        <div class="table-card">
                            <h3><i class="fas fa-exclamation-triangle"></i> المنتجات المنخفضة المخزون</h3>
                            <div class="table-scroll">
                                <table class="report-table">
                                    <thead>
                                        <tr>
                                            <th>المنتج</th>
                                            <th>الفئة</th>
                                            <th>المخزون الحالي</th>
                                            <th>الحد الأدنى</th>
                                            <th>الحالة</th>
                                            <th>آخر تزويد</th>
                                        </tr>
                                    </thead>
                                    <tbody id="lowStockTable">
                                        <!-- سيتم تعبئة البيانات عن طريق JavaScript -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        
                        <div class="table-card">
                            <h3><i class="fas fa-boxes"></i> ملخص المخزون</h3>
                            <div class="table-scroll">
                                <table class="report-table">
                                    <thead>
                                        <tr>
                                            <th>الفئة</th>
                                            <th>عدد المنتجات</th>
                                            <th>إجمالي الكمية</th>
                                            <th>قيمة المخزون</th>
                                            <th>حالة المخزون</th>
                                        </tr>
                                    </thead>
                                    <tbody id="inventorySummaryTable">
                                        <!-- سيتم تعبئة البيانات عن طريق JavaScript -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- تقرير الديون -->
                <div id="debt-report" class="report-section">
                    <div class="section-header">
                        <h2><i class="fas fa-users"></i> تقرير الديون</h2>
                        <div class="section-actions">
                            <button class="btn-secondary" onclick="printReport('debt')">
                                <i class="fas fa-print"></i>
                                طباعة التقرير
                            </button>
                        </div>
                    </div>
                    
                    <div class="charts-container">
                        <div class="chart-card">
                            <h3><i class="fas fa-chart-bar"></i> توزيع الديون على العملاء</h3>
                            <div class="chart-wrapper">
                                <canvas id="debtDistributionChart"></canvas>
                            </div>
                        </div>
                        
                        <div class="chart-card">
                            <h3><i class="fas fa-chart-line"></i> تطور الديون الشهرية</h3>
                            <div class="chart-wrapper">
                                <canvas id="monthlyDebtChart"></canvas>
                            </div>
                        </div>
                    </div>
                    
                    <div class="tables-container">
                        <div class="table-card">
                            <h3><i class="fas fa-money-bill-wave"></i> الديون المستحقة</h3>
                            <div class="table-scroll">
                                <table class="report-table">
                                    <thead>
                                        <tr>
                                            <th>العميل</th>
                                            <th>الهاتف</th>
                                            <th>إجمالي الدين</th>
                                            <th>المسدد</th>
                                            <th>المتبقي</th>
                                            <th>آخر عملية</th>
                                            <th>الحالة</th>
                                        </tr>
                                    </thead>
                                    <tbody id="debtDetailsTable">
                                        <!-- سيتم تعبئة البيانات عن طريق JavaScript -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        
                        <div class="table-card">
                            <h3><i class="fas fa-calendar-check"></i> جدول السداد</h3>
                            <div class="table-scroll">
                                <table class="report-table">
                                    <thead>
                                        <tr>
                                            <th>العميل</th>
                                            <th>آخر سداد</th>
                                            <th>قيمة السداد</th>
                                            <th>المبلغ المتبقي</th>
                                            <th>تاريخ السداد القادم</th>
                                            <th>الحالة</th>
                                        </tr>
                                    </thead>
                                    <tbody id="paymentScheduleTable">
                                        <!-- سيتم تعبئة البيانات عن طريق JavaScript -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- تقرير الصلاحية -->
                <div id="expiry-report" class="report-section">
                    <div class="section-header">
                        <h2><i class="fas fa-calendar-times"></i> تقرير الصلاحية</h2>
                        <div class="section-actions">
                            <button class="btn-secondary" onclick="printReport('expiry')">
                                <i class="fas fa-print"></i>
                                طباعة التقرير
                            </button>
                        </div>
                    </div>
                    
                    <div class="charts-container">
                        <div class="chart-card">
                            <h3><i class="fas fa-chart-pie"></i> توزيع المنتجات حسب الصلاحية</h3>
                            <div class="chart-wrapper">
                                <canvas id="expiryDistributionChart"></canvas>
                            </div>
                        </div>
                        
                        <div class="chart-card">
                            <h3><i class="fas fa-chart-bar"></i> المنتجات المنتهية القيمة</h3>
                            <div class="chart-wrapper">
                                <canvas id="expiredValueChart"></canvas>
                            </div>
                        </div>
                    </div>
                    
                    <div class="tables-container">
                        <div class="table-card">
                            <h3><i class="fas fa-times-circle"></i> المنتجات المنتهية الصلاحية</h3>
                            <div class="table-scroll">
                                <table class="report-table">
                                    <thead>
                                        <tr>
                                            <th>المنتج</th>
                                            <th>الفئة</th>
                                            <th>الكمية</th>
                                            <th>سعر الشراء</th>
                                            <th>القيمة الإجمالية</th>
                                            <th>تاريخ الانتهاء</th>
                                            <th>حالة التصرف</th>
                                        </tr>
                                    </thead>
                                    <tbody id="expiredProductsTable">
                                        <!-- سيتم تعبئة البيانات عن طريق JavaScript -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        
                        <div class="table-card">
                            <h3><i class="fas fa-exclamation-triangle"></i> المنتجات القريبة من الانتهاء</h3>
                            <div class="table-scroll">
                                <table class="report-table">
                                    <thead>
                                        <tr>
                                            <th>المنتج</th>
                                            <th>الفئة</th>
                                            <th>الكمية</th>
                                            <th>تاريخ الانتهاء</th>
                                            <th>الأيام المتبقية</th>
                                            <th>القيمة الإجمالية</th>
                                            <th>الإجراء</th>
                                        </tr>
                                    </thead>
                                    <tbody id="nearExpiryTable">
                                        <!-- سيتم تعبئة البيانات عن طريق JavaScript -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- نافذة التصدير -->
    <div class="modal" id="exportModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3><i class="fas fa-download"></i> تصدير التقرير</h3>
                <button class="btn-close" onclick="closeExportModal()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <div class="modal-body">
                <div class="export-options">
                    <div class="export-option" onclick="selectExportFormat('pdf')">
                        <i class="fas fa-file-pdf"></i>
                        <div class="export-option-content">
                            <h4>PDF</h4>
                            <p>تقرير بتنسيق PDF قابل للطباعة</p>
                        </div>
                    </div>
                    
                    <div class="export-option" onclick="selectExportFormat('excel')">
                        <i class="fas fa-file-excel"></i>
                        <div class="export-option-content">
                            <h4>Excel</h4>
                            <p>ملف إكسل للتحليل والعمليات الحسابية</p>
                        </div>
                    </div>
                    
                    <div class="export-option" onclick="selectExportFormat('csv')">
                        <i class="fas fa-file-csv"></i>
                        <div class="export-option-content">
                            <h4>CSV</h4>
                            <p>ملف نصي يمكن استيراده لأي نظام</p>
                        </div>
                    </div>
                    
                    <div class="export-option" onclick="selectExportFormat('print')">
                        <i class="fas fa-print"></i>
                        <div class="export-option-content">
                            <h4>طباعة مباشرة</h4>
                            <p>طباعة التقرير مباشرة على الطابعة</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="modal-footer">
                <button class="btn-secondary" onclick="closeExportModal()">
                    <i class="fas fa-times"></i> إلغاء
                </button>
                <button class="btn-primary" onclick="exportReport()">
                    <i class="fas fa-download"></i> تصدير
                </button>
            </div>
        </div>
    </div>
    
    <!-- رسالة تنبيه -->
    <div id="alertMessage" class="alert-message">
        <i class="fas fa-check-circle"></i>
        <span id="alertText">تمت العملية بنجاح</span>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // المتغيرات العامة
        let currentReport = 'sales';
        let selectedExportFormat = 'pdf';
        let charts = {};
        const csrfToken = '{{ csrf_token() }}';

        // عرض رسالة تنبيه
        function showAlert(message, type = 'success') {
            const alert = document.getElementById('alertMessage');
            const alertText = document.getElementById('alertText');
            
            alertText.textContent = message;
            alert.className = `alert-message ${type} show`;
            
            setTimeout(() => {
                alert.classList.remove('show');
            }, 3000);
            alert.style.display = 'flex';
        }

        // تحديث الإحصائيات السريعة
        function updateQuickStats() {
            fetch('/reports/data', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({
                    report_type: 'quick_stats'
                })
            })
            .then(response => response.json())
            .then(data => {
                // تحديث القيم
            })
            .catch(error => console.error('Error:', error));
        }

        // تبديل بين التقارير
        function switchReport(reportName) {
            // تحديث علامات التبويب
            document.querySelectorAll('.report-tab').forEach(tab => {
                tab.classList.remove('active');
            });
            event.currentTarget.classList.add('active');
            
            // إخفاء جميع التقارير
            document.querySelectorAll('.report-section').forEach(section => {
                section.classList.remove('active');
            });
            
            // إظهار التقرير المختار
            document.getElementById(`${reportName}-report`).classList.add('active');
            
            // حفظ التقرير الحالي
            currentReport = reportName;
            
            // تحديث بيانات التقرير
            updateReportData(reportName);
        }

        // تطبيق فلتر التاريخ
        function applyDateFilter() {
            const startDate = document.getElementById('startDate').value;
            const endDate = document.getElementById('endDate').value;
            
            if (startDate && endDate && startDate <= endDate) {
                showAlert(`تم تطبيق الفلتر من ${startDate} إلى ${endDate}`);
                updateReportData(currentReport);
            } else {
                showAlert('الرجاء اختيار فترة زمنية صحيحة', 'error');
            }
        }

        // تحديث بيانات التقرير
        function updateReportData(reportName) {
            const startDate = document.getElementById('startDate').value;
            const endDate = document.getElementById('endDate').value;
            
            fetch('/reports/data', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({
                    report_type: reportName,
                    start_date: startDate,
                    end_date: endDate
                })
            })
            .then(response => response.json())
            .then(data => {
                switch(reportName) {
                    case 'sales':
                        updateSalesReport(data);
                        break;
                    case 'profit':
                        updateProfitReport(data);
                        break;
                    case 'inventory':
                        updateInventoryReport(data);
                        break;
                    case 'debt':
                        updateDebtReport(data);
                        break;
                    case 'expiry':
                        updateExpiryReport(data);
                        break;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showAlert('حدث خطأ في تحميل البيانات', 'error');
            });
        }

        // تحديث تقرير المبيعات
        function updateSalesReport(data) {
            // تدمير الرسوم البيانية القديمة إن وجدت
            destroyCharts(['monthlySalesChart', 'salesByTypeChart']);
            
            // رسم مخطط المبيعات الشهرية
            if (data.monthly && data.monthly.length > 0) {
                const monthlySalesCtx = document.getElementById('monthlySalesChart').getContext('2d');
                const labels = data.monthly.map(item => `${item.year}-${item.month}`);
                const salesData = data.monthly.map(item => parseFloat(item.total));
                
                charts.monthlySalesChart = new Chart(monthlySalesCtx, {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'المبيعات (ر.س)',
                            data: salesData,
                            borderColor: '#0066ff',
                            backgroundColor: 'rgba(0, 102, 255, 0.1)',
                            borderWidth: 2,
                            fill: true,
                            tension: 0.4
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                rtl: true,
                                labels: {
                                    font: {
                                        family: "'Tajawal', sans-serif"
                                    }
                                }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    callback: function(value) {
                                        return value.toLocaleString('ar-SA') + ' ر.س';
                                    }
                                }
                            }
                        }
                    }
                });
            }
            
            // رسم مخطط توزيع المبيعات حسب النوع
            if (data.byType && data.byType.length > 0) {
                const salesByTypeCtx = document.getElementById('salesByTypeChart').getContext('2d');
                const labels = data.byType.map(item => item.sale_type === 'cash' ? 'نقداً' : 'آجل');
                const typeData = data.byType.map(item => parseFloat(item.total));
                
                charts.salesByTypeChart = new Chart(salesByTypeCtx, {
                    type: 'doughnut',
                    data: {
                        labels: labels,
                        datasets: [{
                            data: typeData,
                            backgroundColor: ['#34c759', '#ff9500'],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'bottom',
                                rtl: true,
                                labels: {
                                    font: {
                                        family: "'Tajawal', sans-serif"
                                    }
                                }
                            }
                        }
                    }
                });
            }
            
            // تحديث جداول المبيعات
            updateSalesTables(data);
        }

        // تحديث جداول تقرير المبيعات
        function updateSalesTables(data) {
            const salesSummaryTable = document.getElementById('salesSummaryTable');
            const topProductsTable = document.getElementById('topProductsTable');
            
            // ملخص المبيعات
            if (data.summary && data.summary.length > 0) {
                salesSummaryTable.innerHTML = data.summary.map(row => `
                    <tr>
                        <td>${row.date}</td>
                        <td>${row.invoices}</td>
                        <td>${parseFloat(row.cash).toLocaleString('ar-SA', {minimumFractionDigits: 2})} ر.س</td>
                        <td>${parseFloat(row.credit).toLocaleString('ar-SA', {minimumFractionDigits: 2})} ر.س</td>
                        <td><strong>${parseFloat(row.total).toLocaleString('ar-SA', {minimumFractionDigits: 2})} ر.س</strong></td>
                    </tr>
                `).join('');
            } else {
                salesSummaryTable.innerHTML = `
                    <tr>
                        <td colspan="5" class="empty-state">
                            <i class="fas fa-chart-bar"></i>
                            <p>لا توجد بيانات للعرض</p>
                        </td>
                    </tr>
                `;
            }
            
            // المنتجات الأكثر مبيعاً
            if (data.topProducts && data.topProducts.length > 0) {
                const totalRevenue = data.topProducts.reduce((sum, product) => sum + parseFloat(product.revenue), 0);
                
                topProductsTable.innerHTML = data.topProducts.map((product, index) => {
                    const percentage = totalRevenue > 0 ? ((parseFloat(product.revenue) / totalRevenue) * 100).toFixed(1) : 0;
                    return `
                        <tr>
                            <td>
                                <span style="display: inline-block; width: 24px; height: 24px; background: #0066ff; color: white; border-radius: 50%; text-align: center; line-height: 24px; margin-left: 8px;">
                                    ${index + 1}
                                </span>
                                ${product.name}
                            </td>
                            <td>${parseInt(product.quantity).toLocaleString('ar-SA')}</td>
                            <td>${parseFloat(product.revenue).toLocaleString('ar-SA', {minimumFractionDigits: 2})} ر.س</td>
                            <td>
                                <div style="background: #f2f2f7; border-radius: 10px; height: 20px; overflow: hidden;">
                                    <div style="background: #0066ff; width: ${percentage}%; height: 100%;"></div>
                                </div>
                                <small style="color: #8e8e93;">${percentage}%</small>
                            </td>
                        </tr>
                    `;
                }).join('');
            } else {
                topProductsTable.innerHTML = `
                    <tr>
                        <td colspan="4" class="empty-state">
                            <i class="fas fa-box"></i>
                            <p>لا توجد بيانات للعرض</p>
                        </td>
                    </tr>
                `;
            }
        }

        // تحديث تقرير الأرباح (باقي الدوال)
        // ... (يتم إضافة باقي دوال تحديث التقارير بنفس الطريقة)

        // تدمير الرسوم البيانية
        function destroyCharts(chartIds) {
            chartIds.forEach(id => {
                if (charts[id]) {
                    charts[id].destroy();
                    delete charts[id];
                }
            });
        }

        // فتح نافذة التصدير
        function openExportModal() {
            document.querySelectorAll('.export-option').forEach(option => {
                option.classList.remove('selected');
                if (option.querySelector('i').classList.contains('fa-file-pdf') && selectedExportFormat === 'pdf') {
                    option.classList.add('selected');
                } else if (option.querySelector('i').classList.contains('fa-file-excel') && selectedExportFormat === 'excel') {
                    option.classList.add('selected');
                } else if (option.querySelector('i').classList.contains('fa-file-csv') && selectedExportFormat === 'csv') {
                    option.classList.add('selected');
                } else if (option.querySelector('i').classList.contains('fa-print') && selectedExportFormat === 'print') {
                    option.classList.add('selected');
                }
            });
            document.getElementById('exportModal').classList.add('active');
        }

        // إغلاق نافذة التصدير
        function closeExportModal() {
            document.getElementById('exportModal').classList.remove('active');
        }

        // اختيار تنسيق التصدير
        function selectExportFormat(format) {
            selectedExportFormat = format;
            
            document.querySelectorAll('.export-option').forEach(option => {
                option.classList.remove('selected');
            });
            event.currentTarget.classList.add('selected');
        }

        // تصدير التقرير
        function exportReport() {
            const startDate = document.getElementById('startDate').value;
            const endDate = document.getElementById('endDate').value;
            
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '/reports/export';
            form.style.display = 'none';
            
            // CSRF Token
            const csrfInput = document.createElement('input');
            csrfInput.type = 'hidden';
            csrfInput.name = '_token';
            csrfInput.value = csrfToken;
            form.appendChild(csrfInput);
            
            // Report Type
            const reportInput = document.createElement('input');
            reportInput.type = 'hidden';
            reportInput.name = 'report_type';
            reportInput.value = currentReport;
            form.appendChild(reportInput);
            
            // Format
            const formatInput = document.createElement('input');
            formatInput.type = 'hidden';
            formatInput.name = 'format';
            formatInput.value = selectedExportFormat;
            form.appendChild(formatInput);
            
            // Dates
            const startDateInput = document.createElement('input');
            startDateInput.type = 'hidden';
            startDateInput.name = 'start_date';
            startDateInput.value = startDate;
            form.appendChild(startDateInput);
            
            const endDateInput = document.createElement('input');
            endDateInput.type = 'hidden';
            endDateInput.name = 'end_date';
            endDateInput.value = endDate;
            form.appendChild(endDateInput);
            
            document.body.appendChild(form);
            form.submit();
            document.body.removeChild(form);
            
            closeExportModal();
        }
        

        // طباعة التقرير
        function printReport(reportType) {
            const reportName = getReportName(reportType);
            showAlert(`جاري إعداد تقرير ${reportName} للطباعة...`);
            
            setTimeout(() => {
                window.print();
            }, 1000);
        }

        // الحصول على اسم التقرير
        function getReportName(reportType) {
            const reportNames = {
                'sales': 'المبيعات',
                'profit': 'الأرباح',
                'inventory': 'المخزون',
                'debt': 'الديون',
                'expiry': 'الصلاحية'
            };
            return reportNames[reportType] || '';
        }

        // تفعيل/تعطيل الشريط الجانبي على الجوال
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('active');
        }

        // تحميل البيانات عند فتح الصفحة
        document.addEventListener('DOMContentLoaded', function() {
            updateReportData(currentReport);
            
            // إغلاق الشريط الجانبي عند النقر خارجها
            document.addEventListener('click', function(event) {
                const sidebar = document.getElementById('sidebar');
                const mobileMenuBtn = document.querySelector('.mobile-menu-btn');
                
                if (window.innerWidth <= 768 && 
                    !sidebar.contains(event.target) && 
                    (!mobileMenuBtn || !mobileMenuBtn.contains(event.target)) && 
                    sidebar.classList.contains('active')) {
                    sidebar.classList.remove('active');
                }
            });
        });
    </script>
</body>
</html>