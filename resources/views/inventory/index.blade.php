<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>إدارة المخزون | نظام إدارة البقالة</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="{{ asset('assets/css/sidebar.css') }}">
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=SF+Pro+Display:wght@300;400;500;600;700&display=swap');

        :root {
           
            --success-color: #34c759;
            --warning-color: #ff9500;
            --danger-color: #ff3b30;
            --info-color: #5ac8fa;
            --dark-color: #1c1c1e;
            --light-color: #f2f2f7;
            
            --header-height: 70px;
           
            --border-radius: 16px;
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

        /* الشريط الجانبي */
       

        /* المحتوى الرئيسي */
        .main-content {
            flex: 1;
            
            padding: 20px;
        }

        /* شريط العنوان العلوي */
        .top-bar {
            background: white;
            border-radius: var(--border-radius);
            padding: 15px 25px;
            margin-bottom: 25px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
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

        /* بطاقات نظرة عامة */
        .overview-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .overview-card {
            background: white;
            border-radius: var(--border-radius);
            padding: 25px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            border-top: 4px solid transparent;
        }

        .overview-card.total {
            border-top-color: var(--primary-color);
        }

        .overview-card.low {
            border-top-color: var(--danger-color);
        }

        .overview-card.expiring {
            border-top-color: var(--warning-color);
        }

        .overview-card.value {
            border-top-color: var(--success-color);
        }

        .overview-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .overview-icon {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            color: white;
        }

        .overview-card.total .overview-icon {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        }

        .overview-card.low .overview-icon {
            background: linear-gradient(135deg, var(--danger-color), #ff6961);
        }

        .overview-card.expiring .overview-icon {
            background: linear-gradient(135deg, var(--warning-color), #ffcc00);
        }

        .overview-card.value .overview-icon {
            background: linear-gradient(135deg, var(--success-color), #4cd964);
        }

        .overview-value {
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .overview-label {
            color: #8e8e93;
            font-size: 14px;
            margin-bottom: 10px;
        }

        .overview-change {
            font-size: 14px;
            font-weight: 500;
        }

        .overview-change.positive {
            color: var(--success-color);
        }

        .overview-change.negative {
            color: var(--danger-color);
        }

        /* الرسوم البيانية */
        .charts-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 30px;
        }

        @media (max-width: 1200px) {
            .charts-grid {
                grid-template-columns: 1fr;
            }
        }

        .chart-container {
            background: white;
            border-radius: var(--border-radius);
            padding: 25px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .section-header h2 {
            font-size: 20px;
            font-weight: 600;
        }

        .view-all {
            color: var(--primary-color);
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
        }

        .chart-wrapper {
            height: 250px;
            position: relative;
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
        /* تنبيهات المخزون */
        .alerts-section {
            background: white;
            border-radius: var(--border-radius);
            padding: 25px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            margin-bottom: 30px;
        }

        .alerts-tabs {
            display: flex;
            margin-bottom: 20px;
            border-bottom: 2px solid #f2f2f7;
        }

        .alert-tab {
            padding: 10px 20px;
            background: none;
            border: none;
            font-size: 16px;
            font-weight: 500;
            color: #8e8e93;
            cursor: pointer;
            position: relative;
        }

        .alert-tab.active {
            color: var(--primary-color);
        }

        .alert-tab.active::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            right: 0;
            height: 3px;
            background: var(--primary-color);
        }

        .alert-tab .badge {
            background: var(--danger-color);
            color: white;
            font-size: 12px;
            padding: 2px 8px;
            border-radius: 10px;
            margin-right: 5px;
        }

        .alerts-content {
            display: none;
        }

        .alerts-content.active {
            display: block;
        }

        .alert-item {
            padding: 15px;
            border-radius: 12px;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 15px;
            border: 1px solid rgba(0,0,0,0.05);
            transition: background var(--transition-speed) ease;
        }

        .alert-item:hover {
            background: var(--light-color);
        }

        .alert-item.critical {
            border-right: 4px solid var(--danger-color);
        }

        .alert-item.warning {
            border-right: 4px solid var(--warning-color);
        }

        .alert-item.info {
            border-right: 4px solid var(--info-color);
        }

        .alert-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            color: white;
        }

        .alert-item.critical .alert-icon {
            background: var(--danger-color);
        }

        .alert-item.warning .alert-icon {
            background: var(--warning-color);
        }

        .alert-item.info .alert-icon {
            background: var(--info-color);
        }

        .alert-content {
            flex: 1;
        }

        .alert-content h4 {
            font-size: 15px;
            margin-bottom: 4px;
        }

        .alert-content p {
            font-size: 13px;
            color: #8e8e93;
        }

        .alert-actions {
            display: flex;
            gap: 10px;
        }

        .btn-action {
            padding: 8px 16px;
            border-radius: 8px;
            border: none;
            font-size: 13px;
            font-weight: 500;
            cursor: pointer;
            transition: all var(--transition-speed) ease;
        }

        .btn-order {
            background: rgba(0, 102, 255, 0.1);
            color: var(--primary-color);
        }

        .btn-order:hover {
            background: var(--primary-color);
            color: white;
        }

        .btn-view {
            background: rgba(52, 199, 89, 0.1);
            color: var(--success-color);
        }

        .btn-view:hover {
            background: var(--success-color);
            color: white;
        }

        /* جدول المخزون */
        .inventory-table-container {
            background: white;
            border-radius: var(--border-radius);
            padding: 0;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            overflow: hidden;
        }

        .table-header {
            padding: 25px;
            border-bottom: 1px solid #e5e5ea;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .table-header h3 {
            font-size: 18px;
            font-weight: 600;
        }

        .table-controls {
            display: flex;
            gap: 10px;
            align-items: center;
        }

        .filter-select {
            padding: 8px 16px;
            border: 1px solid #e5e5ea;
            border-radius: 8px;
            background: white;
            color: #1c1c1e;
            font-size: 14px;
            cursor: pointer;
        }

        .inventory-table {
            width: 100%;
            border-collapse: collapse;
        }

        .inventory-table th {
            text-align: right;
            padding: 20px;
            color: #8e8e93;
            font-weight: 500;
            border-bottom: 1px solid #e5e5ea;
            background: #fafafa;
        }

        .inventory-table td {
            padding: 20px;
            border-bottom: 1px solid #f2f2f7;
        }

        .inventory-table tbody tr {
            transition: background var(--transition-speed) ease;
        }

        .inventory-table tbody tr:hover {
            background: #fafafa;
        }

        .product-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .product-icon {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 18px;
        }

        .product-name {
            font-weight: 500;
            margin-bottom: 4px;
        }

        .product-category {
            font-size: 13px;
            color: #8e8e93;
        }

        .quantity-cell {
            text-align: center;
        }

        .quantity-indicator {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .quantity-bar {
            flex: 1;
            height: 8px;
            background: #f2f2f7;
            border-radius: 4px;
            overflow: hidden;
        }

        .quantity-fill {
            height: 100%;
            border-radius: 4px;
        }

        .quantity-fill.high {
            background: var(--success-color);
            width: 80%;
        }

        .quantity-fill.medium {
            background: var(--warning-color);
            width: 50%;
        }

        .quantity-fill.low {
            background: var(--danger-color);
            width: 20%;
        }

        .quantity-text {
            font-weight: 600;
            min-width: 40px;
        }

        .quantity-text.high {
            color: var(--success-color);
        }

        .quantity-text.medium {
            color: var(--warning-color);
        }

        .quantity-text.low {
            color: var(--danger-color);
        }

        .expiry-cell {
            text-align: center;
        }

        .expiry-badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 500;
        }

        .expiry-badge.safe {
            background: rgba(52, 199, 89, 0.1);
            color: var(--success-color);
        }

        .expiry-badge.warning {
            background: rgba(255, 149, 0, 0.1);
            color: var(--warning-color);
        }

        .expiry-badge.danger {
            background: rgba(255, 59, 48, 0.1);
            color: var(--danger-color);
        }

        .expiry-badge.expired {
            background: rgba(255, 59, 48, 0.2);
            color: var(--danger-color);
            font-weight: 600;
        }

        .value-cell {
            font-weight: 600;
            color: var(--dark-color);
        }

        .actions-cell {
            text-align: center;
        }

        .table-actions {
            display: flex;
            gap: 10px;
            justify-content: center;
        }

        .btn-icon {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all var(--transition-speed) ease;
        }

        .btn-edit {
            background: rgba(0, 102, 255, 0.1);
            color: var(--primary-color);
        }

        .btn-edit:hover {
            background: var(--primary-color);
            color: white;
        }

        .btn-order {
            background: rgba(255, 149, 0, 0.1);
            color: var(--warning-color);
        }

        .btn-order:hover {
            background: var(--warning-color);
            color: white;
        }

        /* التذييل */
        .table-footer {
            padding: 20px 25px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-top: 1px solid #e5e5ea;
            background: #fafafa;
        }

        .pagination {
            display: flex;
            gap: 8px;
        }

        .page-btn {
            width: 36px;
            height: 36px;
            border: 1px solid #e5e5ea;
            background: white;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all var(--transition-speed) ease;
        }

        .page-btn:hover {
            border-color: var(--primary-color);
            color: var(--primary-color);
        }

        .page-btn.active {
            background: var(--primary-color);
            color: white;
            border-color: var(--primary-color);
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
        }

        /* تصميم للجوّال */
        @media (max-width: 768px) {
          
            
            .mobile-menu-btn {
                display: block;
            }
            
            .top-bar {
                flex-direction: column;
                gap: 15px;
                align-items: flex-start;
            }
            
            .overview-grid {
                grid-template-columns: 1fr;
            }
            
            .charts-grid {
                grid-template-columns: 1fr;
            }
            
            .alert-actions {
                flex-direction: column;
            }
            
            .table-controls {
                flex-direction: column;
                align-items: stretch;
            }
            
            .inventory-table {
                display: block;
                overflow-x: auto;
            }
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
                    <h1>إدارة المخزون</h1>
                    <p>مراقبة وتتبع مخزون متجرك في الوقت الحقيقي</p>
                </div>
                
                <div class="top-bar-actions">
                    <div class="date-display" id="currentDate"></div>
                </div>
            </div>
            
            <!-- نظرة عامة (سيتم تعبئتها من قاعدة البيانات) -->
            <div class="overview-grid">
                <div class="overview-card total">
                    <div class="overview-header">
                        <div>
                            <div class="overview-value" id="totalProducts">{{ $stats['total_products'] ?? 0 }}</div>
                            <div class="overview-label">إجمالي المنتجات</div>
                        </div>
                        <div class="overview-icon">
                            <i class="fas fa-boxes"></i>
                        </div>
                    </div>
                    <div class="overview-change positive">
                        <i class="fas fa-arrow-up"></i> {{ $stats['new_this_month'] ?? 0 }} منتجات جديدة هذا الشهر
                    </div>
                </div>
                
                <div class="overview-card low">
                    <div class="overview-header">
                        <div>
                            <div class="overview-value" id="lowStockCount">{{ $stats['low_stock_count'] ?? 0 }}</div>
                            <div class="overview-label">منتجات منخفضة المخزون</div>
                        </div>
                        <div class="overview-icon">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                    </div>
                    <div class="overview-change negative">
                        <i class="fas fa-arrow-up"></i> {{ $stats['critical_count'] ?? 0 }} منتجات وصلت للحد الأدنى
                    </div>
                </div>
                
                <div class="overview-card expiring">
                    <div class="overview-header">
                        <div>
                            <div class="overview-value" id="expiringCount">{{ $stats['expiring_count'] ?? 0 }}</div>
                            <div class="overview-label">منتجات قريبة الانتهاء</div>
                        </div>
                        <div class="overview-icon">
                            <i class="fas fa-clock"></i>
                        </div>
                    </div>
                    <div class="overview-change negative">
                        <i class="fas fa-arrow-up"></i> {{ $stats['expiring_soon_count'] ?? 0 }} منتجات خلال أسبوع
                    </div>
                </div>
                
                <div class="overview-card value">
                    <div class="overview-header">
                        <div>
                            <div class="overview-value" id="totalValue">{{ number_format($stats['total_value'] ?? 0) }} ر.س</div>
                            <div class="overview-label">القيمة الإجمالية للمخزون</div>
                        </div>
                        <div class="overview-icon">
                            <i class="fas fa-coins"></i>
                        </div>
                    </div>
                    <div class="overview-change {{ $stats['value_change'] >= 0 ? 'positive' : 'negative' }}">
                        <i class="fas fa-arrow-{{ $stats['value_change'] >= 0 ? 'up' : 'down' }}"></i> 
                        {{ abs($stats['value_change'] ?? 0) }}% عن الشهر الماضي
                    </div>
                </div>
            </div>
            
            <!-- الرسوم البيانية (سيتم تعبئتها من قاعدة البيانات) -->
            <div class="charts-grid">
                <div class="chart-container">
                    <div class="section-header">
                        <h2>توزيع المخزون حسب الحالة</h2>
                    </div>
                    <div class="chart-wrapper">
                        <canvas id="inventoryChart"></canvas>
                    </div>
                </div>
                
                <div class="chart-container">
                    <div class="section-header">
                        <h2>حركة المخزون الأخيرة</h2>
                        <a href="{{ route('reports.index') }}" class="view-all">عرض التفاصيل</a>
                    </div>
                    <div class="chart-wrapper">
                        <canvas id="movementChart"></canvas>
                    </div>
                </div>
            </div>
            
            <!-- تنبيهات المخزون (سيتم تعبئتها من قاعدة البيانات) -->
            <div class="alerts-section">
                <div class="section-header">
                    <h2>التنبيهات</h2>
                </div>
                
                <div class="alerts-tabs">
                    <button class="alert-tab active" onclick="switchAlertTab('stock')">
                        نقص المخزون <span class="badge" id="stockAlertsCount">{{ count($lowStockAlerts) }}</span>
                    </button>
                    <button class="alert-tab" onclick="switchAlertTab('expiry')">
                        قرب الانتهاء <span class="badge" id="expiryAlertsCount">{{ count($expiryAlerts) }}</span>
                    </button>
                    <button class="alert-tab" onclick="switchAlertTab('all')">
                        جميع التنبيهات
                    </button>
                </div>
                
                <!-- تنبيهات نقص المخزون -->
                <div id="stock-alerts" class="alerts-content active">
                    @forelse($lowStockAlerts as $alert)
                    <div class="alert-item {{ $alert['is_critical'] ? 'critical' : 'warning' }}">
                        <div class="alert-icon">
                            <i class="fas {{ $alert['is_critical'] ? 'fa-exclamation-triangle' : 'fa-box' }}"></i>
                        </div>
                        <div class="alert-content">
                            <h4>{{ $alert['type'] == 'critical' ? 'نقص حاد في المخزون' : 'نقص في المخزون' }}</h4>
                            <p>{{ $alert['message'] }}</p>
                        </div>
                        <div class="alert-actions">
                            <button class="btn-action btn-order" onclick="orderProduct({{ $alert['product_id'] }})">
                                <i class="fas fa-shopping-cart"></i> طلب شراء
                            </button>
                            <button class="btn-action btn-view" onclick="viewProduct({{ $alert['product_id'] }})">
                                <i class="fas fa-eye"></i> عرض
                            </button>
                        </div>
                    </div>
                    @empty
                    <div class="alert-item info">
                        <div class="alert-icon">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="alert-content">
                            <h4>لا توجد تنبيهات</h4>
                            <p>جميع المنتجات مخزونها جيد</p>
                        </div>
                    </div>
                    @endforelse
                </div>
                
                <!-- تنبيهات قرب الانتهاء -->
                <div id="expiry-alerts" class="alerts-content">
                    @forelse($expiryAlerts as $alert)
                    <div class="alert-item {{ $alert['is_expired'] ? 'critical' : 'warning' }}">
                        <div class="alert-icon">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="alert-content">
                            <h4>{{ $alert['is_expired'] ? 'منتهي الصلاحية' : 'قريب من الانتهاء' }}</h4>
                            <p>{{ $alert['message'] }}</p>
                        </div>
                        <div class="alert-actions">
                            <button class="btn-action btn-view" onclick="viewProduct({{ $alert['product_id'] }})">
                                <i class="fas fa-eye"></i> عرض
                            </button>
                        </div>
                    </div>
                    @empty
                    <div class="alert-item info">
                        <div class="alert-icon">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="alert-content">
                            <h4>لا توجد تنبيهات</h4>
                            <p>لا توجد منتجات قريبة من الانتهاء</p>
                        </div>
                    </div>
                    @endforelse
                </div>
                
                <!-- جميع التنبيهات -->
                <div id="all-alerts" class="alerts-content">
                    <!-- سيتم تعبئتها عن طريق JavaScript -->
                </div>
            </div>
            
            <!-- جدول المخزون (سيتم تعبئته من قاعدة البيانات) -->
            <div class="inventory-table-container">
                <div class="table-header">
                    <h3>المخزون الحالي</h3>
                    <div class="table-controls">
                        <select class="filter-select" id="statusFilter" onchange="filterInventory()">
                            <option value="">جميع الحالات</option>
                            <option value="low">منخفض المخزون</option>
                            <option value="normal">مخزون طبيعي</option>
                            <option value="expiring">قريب الانتهاء</option>
                            <option value="expired">منتهي الصلاحية</option>
                        </select>
                        
                        <select class="filter-select" id="categoryFilter" onchange="filterInventory()">
                            <option value="">جميع التصنيفات</option>
                            @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                
                <table class="inventory-table">
                    <thead>
                        <tr>
                            <th>المنتج</th>
                            <th>الكمية</th>
                            <th>تاريخ الانتهاء</th>
                            <th>قيمة المخزون</th>
                            <th>الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody id="inventoryTableBody">
                        @foreach($products as $product)
                        <tr data-status="{{ $product['status'] }}" data-category="{{ $product['category_id'] }}">
                            <td>
                                <div class="product-info">
                                    <div class="product-icon">
                                        <i class="fas fa-box"></i>
                                    </div>
                                    <div>
                                        <div class="product-name">{{ $product->name }}</div>
                                        <div class="product-category">{{ $product->category->name ?? 'غير مصنف' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="quantity-cell">
                                <div class="quantity-indicator">
                                    <div class="quantity-text {{ $product['quantity_status'] }}">{{ $product->quantity }}</div>
                                    <div class="quantity-bar">
                                        <div class="quantity-fill {{ $product['quantity_status'] }}" 
                                             style="width: {{ $product['quantity_percentage'] }}%"></div>
                                    </div>
                                </div>
                                <div style="font-size: 12px; color: #8e8e93; margin-top: 5px;">
                                    الحد الأدنى: {{ $product->minimum_quantity }}
                                </div>
                            </td>
                            <td class="expiry-cell">
                                <span class="expiry-badge {{ $product['expiry_status'] }}">
                                    {{ $product['expiry_text'] }}
                                </span>
                                <div style="font-size: 12px; color: #8e8e93; margin-top: 5px;">
                                    {{ $product->expiry_date ? \Carbon\Carbon::parse($product->expiry_date)->format('Y-m-d') : 'غير محدد' }}
                                </div>
                            </td>
                            <td class="value-cell">
                                {{ number_format($product['inventory_value']) }} ر.س
                                <div style="font-size: 12px; color: #8e8e93; margin-top: 5px;">
                                    {{ $product->quantity }} × {{ number_format($product->purchase_price) }} ر.س
                                </div>
                            </td>
                            <td class="actions-cell">
                                <div class="table-actions">
                                 <button class="btn-action btn-edit" onclick="openEditModal({{ $product->id }})" title="تعديل">
    <i class="fas fa-edit"></i>
</button>
                                    <button class="btn-icon btn-order" onclick="orderProduct({{ $product->id }})" title="طلب شراء">
                                        <i class="fas fa-shopping-cart"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                
                <div class="table-footer">
                    <div class="total-items">
                        إجمالي المنتجات: <strong id="tableTotal">{{ $products->total() }}</strong>
                    </div>
                    
                    <div class="pagination">
                        {{ $products->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // التاريخ الحالي
        function updateCurrentDate() {
            const today = new Date();
            const options = { 
                weekday: 'long', 
                year: 'numeric', 
                month: 'long', 
                day: 'numeric' 
            };
            const dateString = today.toLocaleDateString('ar-SA', options);
            document.getElementById('currentDate').textContent = dateString;
        }
        
        // إنشاء رسم بياني لتوزيع المخزون
        function createInventoryChart() {
            const ctx = document.getElementById('inventoryChart').getContext('2d');
            
            // بيانات من PHP
            const goodStock = @json($stats['good_stock'] ?? 0);
            const lowStock = @json($stats['low_stock_count'] ?? 0);
            const expiringStock = @json($stats['expiring_count'] ?? 0);
            
            const chart = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['مخزون جيد', 'منخفض المخزون', 'قريب الانتهاء'],
                    datasets: [{
                        data: [goodStock, lowStock, expiringStock],
                        backgroundColor: [
                            'rgba(52, 199, 89, 0.8)',
                            'rgba(255, 59, 48, 0.8)',
                            'rgba(255, 149, 0, 0.8)'
                        ],
                        borderColor: [
                            'rgba(52, 199, 89, 1)',
                            'rgba(255, 59, 48, 1)',
                            'rgba(255, 149, 0, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            rtl: true
                        }
                    }
                }
            });
        }

        // إنشاء رسم بياني لحركة المخزون
        function createMovementChart() {
            const ctx = document.getElementById('movementChart').getContext('2d');
            
            // بيانات من PHP
            const movementData = @json($movementData);
            
            const chart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: movementData.labels,
                    datasets: [
                        {
                            label: 'مبيعات',
                            data: movementData.sales,
                            borderColor: 'rgba(0, 102, 255, 1)',
                            backgroundColor: 'rgba(0, 102, 255, 0.1)',
                            borderWidth: 2,
                            tension: 0.4
                        },
                        {
                            label: 'مشتريات',
                            data: movementData.purchases,
                            borderColor: 'rgba(52, 199, 89, 1)',
                            backgroundColor: 'rgba(52, 199, 89, 0.1)',
                            borderWidth: 2,
                            tension: 0.4
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'top',
                            rtl: true
                        }
                    },
                    scales: {
                        x: {
                            grid: {
                                display: false
                            }
                        },
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return value + ' وحدة';
                                }
                            }
                        }
                    }
                }
            });
        }

        // تبديل بين علامات تبويب التنبيهات
        function switchAlertTab(tabName) {
            // تحديث علامات التبويب
            document.querySelectorAll('.alert-tab').forEach(tab => {
                tab.classList.remove('active');
            });
            event.target.classList.add('active');
            
            // تحديث المحتوى
            document.querySelectorAll('.alerts-content').forEach(content => {
                content.classList.remove('active');
            });
            
            if (tabName === 'all') {
                showAllAlerts();
                document.getElementById('all-alerts').classList.add('active');
            } else {
                document.getElementById(`${tabName}-alerts`).classList.add('active');
            }
        }

        // عرض جميع التنبيهات
        function showAllAlerts() {
            const allAlertsDiv = document.getElementById('all-alerts');
            allAlertsDiv.innerHTML = '';
            
            // استخدام البيانات من PHP
            const alerts = [
                ...@json($lowStockAlerts),
                ...@json($expiryAlerts)
            ];
            
            if (alerts.length === 0) {
                allAlertsDiv.innerHTML = `
                    <div class="alert-item info">
                        <div class="alert-icon">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="alert-content">
                            <h4>لا توجد تنبيهات</h4>
                            <p>جميع المنتجات في حالة جيدة</p>
                        </div>
                    </div>
                `;
                return;
            }
            
            alerts.forEach(alert => {
                const alertDiv = document.createElement('div');
                let icon = 'fa-info-circle';
                let type = 'info';
                
                if (alert.type === 'critical' || alert.is_expired) {
                    icon = alert.is_expired ? 'fa-clock' : 'fa-exclamation-triangle';
                    type = 'critical';
                } else if (alert.type === 'warning') {
                    icon = 'fa-box';
                    type = 'warning';
                }
                
                alertDiv.className = `alert-item ${type}`;
                alertDiv.innerHTML = `
                    <div class="alert-icon">
                        <i class="fas ${icon}"></i>
                    </div>
                    <div class="alert-content">
                        <h4>${alert.title}</h4>
                        <p>${alert.message}</p>
                    </div>
                    <div class="alert-actions">
                        ${alert.product_id ? `
                        <button class="btn-action btn-view" onclick="viewProduct(${alert.product_id})">
                            <i class="fas fa-eye"></i> عرض
                        </button>
                        ` : ''}
                    </div>
                `;
                allAlertsDiv.appendChild(alertDiv);
            });
        }

        // تصفية المخزون
        function filterInventory() {
            const statusFilter = document.getElementById('statusFilter').value;
            const categoryFilter = document.getElementById('categoryFilter').value;
            
            document.querySelectorAll('#inventoryTableBody tr').forEach(row => {
                const status = row.getAttribute('data-status');
                const category = row.getAttribute('data-category');
                
                let showRow = true;
                
                if (statusFilter && status !== statusFilter) {
                    showRow = false;
                }
                
                if (categoryFilter && category !== categoryFilter) {
                    showRow = false;
                }
                
                row.style.display = showRow ? '' : 'none';
            });
        }

        // وظائف الإجراءات
        function viewProduct(productId) {
            window.location.href = `/products/${productId}`;
        }

        function editProduct(productId) {
            window.location.href = `/products/${productId}/edit`;
        }

        function orderProduct(productId) {
            window.location.href = `/purchases/create?product_id=${productId}`;
        }

        // تفعيل/تعطيل الشريط الجانبي على الجوال
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('active');
        }

        // إغلاق الشريط الجانبي عند النقر خارجها
        document.addEventListener('click', function(event) {
            const sidebar = document.getElementById('sidebar');
            const mobileMenuBtn = document.querySelector('.mobile-menu-btn');
            
            if (window.innerWidth <= 768 && 
                !sidebar.contains(event.target) && 
                !mobileMenuBtn.contains(event.target) && 
                sidebar.classList.contains('active')) {
                sidebar.classList.remove('active');
            }
        });

        // تهيئة النظام عند تحميل الصفحة
        document.addEventListener('DOMContentLoaded', function() {
            updateCurrentDate();
            createInventoryChart();
            createMovementChart();
            showAllAlerts();
        });
function loadInventoryTable() {
    axios.get('/inventory/table', {
        params: {
            status: document.getElementById('statusFilter').value,
            category: document.getElementById('categoryFilter').value
        }
    }).then(res => {
        document.getElementById('inventoryTableBody').innerHTML = res.data.html;
        document.getElementById('tableTotal').innerText = res.data.total;
    });
}

function filterInventory() {
    loadInventoryTable();
}

// فتح modal التعديل
// فتح modal التعديل
function openEditModal(productId) {
    // جلب بيانات المنتج من السيرفر
    axios.get(`/products/${productId}/edit`)

        .then(response => {
            if (response.data.success) {
                const product = response.data.product;
                
                // تعبئة البيانات في الفورم
                document.getElementById('editProductId').value = product.id;
                document.getElementById('editProductName').value = product.name;
                document.getElementById('editProductQuantity').value = product.quantity;
                document.getElementById('editProductMinQuantity').value = product.minimum_quantity;
                document.getElementById('editProductPrice').value = product.purchase_price;
                
                if (product.expiry_date) {
                    // تحويل التاريخ من MySQL format إلى input date format
                    const expiryDate = new Date(product.expiry_date);
                    const formattedDate = expiryDate.toISOString().split('T')[0];
                    document.getElementById('editProductExpiry').value = formattedDate;
                } else {
                    document.getElementById('editProductExpiry').value = '';
                }
                
                // إظهار الـ modal
                document.getElementById('editModal').style.display = 'block';
            } else {
                alert(response.data.message || 'حدث خطأ في جلب بيانات المنتج');
            }
        })
        .catch(error => {
            console.error('Error fetching product data:', error);
            alert('حدث خطأ في جلب بيانات المنتج');
        });
}

// تحديث المنتج


// إغلاق modal التعديل
function closeEditModal() {
    document.getElementById('editModal').style.display = 'none';
}

// تحديث المنتج
function updateProduct(event) {
    event.preventDefault();
    
    const productId = document.getElementById('editProductId').value;
    const formData = {
        name: document.getElementById('editProductName').value,
        quantity: document.getElementById('editProductQuantity').value,
        minimum_quantity: document.getElementById('editProductMinQuantity').value,
        purchase_price: document.getElementById('editProductPrice').value,
        expiry_date: document.getElementById('editProductExpiry').value
    };
    
    axios.put(`/products/${productId}`, formData)
        .then(response => {
            if (response.data.success) {
                alert('تم تحديث المنتج بنجاح');
                closeEditModal();
                // إعادة تحميل الجدول لتحديث البيانات
                loadInventoryTable();
            } else {
                alert('حدث خطأ أثناء التحديث');
            }
        })
        .catch(error => {
            console.error('Error updating product:', error);
            alert('حدث خطأ في تحديث المنتج');
        });
}

// إغلاق الـ modal عند النقر خارج المحتوى
window.onclick = function(event) {
    const modal = document.getElementById('editModal');
    if (event.target == modal) {
        closeEditModal();
    }
}

    </script>
    <!-- Modal لتعديل المنتج -->
<!-- Modal لتعديل المنتج -->
<div id="editModal" class="modal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000; padding: 20px; overflow-y: auto;">
    <div class="modal-content" style="background: white; margin: 50px auto; padding: 30px; border-radius: 16px; max-width: 500px; width: 90%; position: relative;">
        <span class="close" onclick="closeEditModal()" style="position: absolute; left: 20px; top: 20px; font-size: 24px; cursor: pointer; color: #8e8e93;">&times;</span>
        
        <h3 style="margin-bottom: 25px; text-align: center;">تعديل المنتج</h3>
        
        <div id="editErrors" style="display: none; background: rgba(255, 59, 48, 0.1); color: var(--danger-color); padding: 10px; border-radius: 8px; margin-bottom: 15px;"></div>
        
        <form id="editProductForm" onsubmit="updateProduct(event)">
            @csrf
            <input type="hidden" id="editProductId">
            
            <div style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 500;">اسم المنتج</label>
                <input type="text" id="editProductName" class="form-input" required>
            </div>
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 20px;">
                <div>
                    <label style="display: block; margin-bottom: 8px; font-weight: 500;">الكمية الحالية</label>
                    <input type="number" id="editProductQuantity" class="form-input" required min="0">
                </div>
                
                <div>
                    <label style="display: block; margin-bottom: 8px; font-weight: 500;">الحد الأدنى للكمية</label>
                    <input type="number" id="editProductMinQuantity" class="form-input" required min="1" value="10">
                </div>
            </div>
            
            <div style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 500;">سعر الشراء (ر.س)</label>
                <input type="number" step="0.01" id="editProductPrice" class="form-input" required min="0">
            </div>
            
            <div style="margin-bottom: 25px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 500;">تاريخ الانتهاء</label>
                <input type="date" id="editProductExpiry" class="form-input">
            </div>
            
            <div style="display: flex; gap: 10px; justify-content: flex-end;">
                <button type="button" onclick="closeEditModal()" class="btn-cancel">إلغاء</button>
                <button type="submit" class="btn-save">حفظ التعديلات</button>
            </div>
        </form>
    </div>
</div>

<style>
.form-input {
    width: 100%;
    padding: 12px;
    border: 1px solid #e5e5ea;
    border-radius: 8px;
    font-family: inherit;
    font-size: 14px;
}

.form-input:focus {
    outline: none;
    border-color: var(--primary-color);
    box-shadow: 0 0 0 2px rgba(0, 102, 255, 0.2);
}
</style>
</body>
</html>