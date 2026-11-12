<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة التحكم | نظام إدارة البقالة</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="{{ asset('assets/css/sidebar.css') }}">

    <style>
       

        :root {
            
            
            --success-color: #34c759;
            --warning-color: #ff9500;
            --danger-color: #ff3b30;
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
/* زر تسجيل الخروج داخل السايدبار */
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

        .notification-btn {
            position: relative;
            background: none;
            border: none;
            font-size: 20px;
            color: #8e8e93;
            cursor: pointer;
            padding: 10px;
            border-radius: 50%;
            transition: background var(--transition-speed) ease;
        }

        .notification-btn:hover {
            background: var(--light-color);
        }

        .notification-badge {
            position: absolute;
            top: 5px;
            left: 5px;
            background: var(--danger-color);
            color: white;
            font-size: 11px;
            width: 18px;
            height: 18px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .date-display {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 10px 20px;
            border-radius: 12px;
            font-weight: 500;
        }

        /* البطاقات الإحصائية */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            border-radius: var(--border-radius);
            padding: 25px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            transition: transform var(--transition-speed) ease;
            border-top: 4px solid transparent;
            cursor: pointer;
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        .stat-card.sales {
            border-top-color: var(--primary-color);
        }

        .stat-card.products {
            border-top-color: var(--success-color);
        }

        .stat-card.debts {
            border-top-color: var(--danger-color);
        }

        .stat-card.profit {
            border-top-color: var(--warning-color);
        }

        .stat-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .stat-icon {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            color: white;
        }

        .stat-card.sales .stat-icon {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        }

        .stat-card.products .stat-icon {
            background: linear-gradient(135deg, var(--success-color), #4cd964);
        }

        .stat-card.debts .stat-icon {
            background: linear-gradient(135deg, var(--danger-color), #ff6961);
        }

        .stat-card.profit .stat-icon {
            background: linear-gradient(135deg, var(--warning-color), #ffcc00);
        }

        .stat-value {
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .stat-label {
            color: #8e8e93;
            font-size: 14px;
            margin-bottom: 10px;
        }

        .stat-change {
            font-size: 14px;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .stat-change.positive {
            color: var(--success-color);
        }

        .stat-change.negative {
            color: var(--danger-color);
        }

        /* الرسوم البيانية والتنبيهات */
        .charts-alerts-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 20px;
            margin-bottom: 30px;
        }

        @media (max-width: 1200px) {
            .charts-alerts-grid {
                grid-template-columns: 1fr;
            }
        }

        .chart-container, .alerts-container {
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
            transition: color var(--transition-speed) ease;
        }

        .view-all:hover {
            color: var(--secondary-color);
        }

        .chart-wrapper {
            height: 300px;
            position: relative;
        }

        /* قائمة التنبيهات */
        .alerts-list {
            max-height: 300px;
            overflow-y: auto;
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
            cursor: pointer;
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
            border-right: 4px solid var(--primary-color);
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
            background: var(--primary-color);
        }

        .alert-content h4 {
            font-size: 15px;
            margin-bottom: 4px;
        }

        .alert-content p {
            font-size: 13px;
            color: #8e8e93;
        }

        .alert-time {
            font-size: 12px;
            color: #8e8e93;
            margin-top: 5px;
        }

        /* أحدث المنتجات */
        .recent-products {
            background: white;
            border-radius: var(--border-radius);
            padding: 25px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        }

        .products-table {
            width: 100%;
            border-collapse: collapse;
        }

        .products-table th {
            text-align: right;
            padding: 15px;
            color: #8e8e93;
            font-weight: 500;
            border-bottom: 1px solid rgba(0,0,0,0.1);
        }

        .products-table td {
            padding: 15px;
            border-bottom: 1px solid rgba(0,0,0,0.05);
        }

        .products-table tr:hover {
            background: var(--light-color);
        }

        .product-badge {
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
        }

        .product-badge.low {
            background: rgba(255, 59, 48, 0.1);
            color: var(--danger-color);
        }

        .product-badge.normal {
            background: rgba(52, 199, 89, 0.1);
            color: var(--success-color);
        }

        .product-badge.expiring {
            background: rgba(255, 149, 0, 0.1);
            color: var(--warning-color);
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

        /* تخصيص شريط التمرير */
        .alerts-list::-webkit-scrollbar {
            width: 6px;
        }

        .alerts-list::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        .alerts-list::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 10px;
        }

        .alerts-list::-webkit-scrollbar-thumb:hover {
            background: #a1a1a1;
        }

        /* تصميم للجوّال */
        @media (max-width: 768px) {
           
            .mobile-menu-btn {
                display: block;
            }
            
            .stats-grid {
                grid-template-columns: 1fr;
            }
            
            .top-bar {
                flex-direction: column;
                gap: 15px;
                align-items: flex-start;
            }
            
            .top-bar-actions {
                width: 100%;
                justify-content: space-between;
            }
        }

        /* تحميل */
        .loading {
            opacity: 0.7;
            pointer-events: none;
        }

        /* تحميل البيانات */
        .stats-loading {
            display: flex;
            align-items: center;
            gap: 10px;
            color: #8e8e93;
        }

        .stats-loading i {
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
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
                        <h1>لوحة التحكم</h1>
                        <p>مرحباً بعودتك، {{ Auth::user()->name }}. إليك ملخص أداء متجرك.</p>
                    </div>
                </div>
                
                <div class="top-bar-actions">
                    <div class="date-display" id="currentDate"></div>
                    
                    <button class="notification-btn" onclick="showNotifications()">
                        <i class="fas fa-bell"></i>
                        <span class="notification-badge">{{ count($alerts) }}</span>
                    </button>
                </div>
            </div>
            
            <!-- البطاقات الإحصائية -->
            <div class="stats-grid">
                <div class="stat-card sales" onclick="navigateTo('{{ route('sales.index') }}')">
                    <div class="stat-header">
                        <div>
                            <div class="stat-value">{{ number_format($stats['total_sales']['value'], 2) }} ر.س</div>
                            <div class="stat-label">إجمالي المبيعات اليوم</div>
                        </div>
                        <div class="stat-icon">
                            <i class="fas fa-chart-line"></i>
                        </div>
                    </div>
                    <div class="stat-change {{ $stats['total_sales']['change'] >= 0 ? 'positive' : 'negative' }}">
                        <i class="fas fa-arrow-{{ $stats['total_sales']['change'] >= 0 ? 'up' : 'down' }}"></i>
                        {{ number_format(abs($stats['total_sales']['change']), 1) }}% 
                        {{ $stats['total_sales']['change'] >= 0 ? 'زيادة' : 'انخفاض' }}
                    </div>
                </div>
                
                <div class="stat-card products" onclick="navigateTo('{{ route('products.index') }}')">
                    <div class="stat-header">
                        <div>
                            <div class="stat-value">{{ number_format($stats['total_products']['value']) }}</div>
                            <div class="stat-label">إجمالي المنتجات</div>
                        </div>
                        <div class="stat-icon">
                            <i class="fas fa-box"></i>
                        </div>
                    </div>
                    <div class="stat-change {{ $stats['total_products']['change'] >= 0 ? 'positive' : 'negative' }}">
                        <i class="fas fa-arrow-{{ $stats['total_products']['change'] >= 0 ? 'up' : 'down' }}"></i>
                        {{ number_format(abs($stats['total_products']['change']), 1) }}% 
                        {{ $stats['total_products']['change'] >= 0 ? 'زيادة' : 'انخفاض' }}
                    </div>
                </div>
                
                <div class="stat-card debts" onclick="navigateTo('{{ route('customers.index') }}')">
                    <div class="stat-header">
                        <div>
                            <div class="stat-value">{{ number_format($stats['total_debts']['value'], 2) }} ر.س</div>
                            <div class="stat-label">إجمالي الديون</div>
                        </div>
                        <div class="stat-icon">
                            <i class="fas fa-money-bill-wave"></i>
                        </div>
                    </div>
                    <div class="stat-change {{ $stats['total_debts']['change'] >= 0 ? 'positive' : 'negative' }}">
                        @if($stats['total_debts']['change'] != 0)
                        <i class="fas fa-arrow-{{ $stats['total_debts']['change'] >= 0 ? 'up' : 'down' }}"></i>
                        {{ number_format(abs($stats['total_debts']['change']), 1) }}%
                        @else
                        لا يوجد تغيير
                        @endif
                    </div>
                </div>
                
                <div class="stat-card profit" onclick="navigateTo('{{ route('reports.index') }}')">
                    <div class="stat-header">
                        <div>
                            <div class="stat-value">{{ number_format($stats['total_profit']['value'], 2) }} ر.س</div>
                            <div class="stat-label">صافي الربح اليوم</div>
                        </div>
                        <div class="stat-icon">
                            <i class="fas fa-coins"></i>
                        </div>
                    </div>
                    <div class="stat-change {{ $stats['total_profit']['change'] >= 0 ? 'positive' : 'negative' }}">
                        @if($stats['total_profit']['change'] != 0)
                        <i class="fas fa-arrow-{{ $stats['total_profit']['change'] >= 0 ? 'up' : 'down' }}"></i>
                        {{ number_format(abs($stats['total_profit']['change']), 1) }}%
                        @else
                        لا يوجد تغيير
                        @endif
                    </div>
                </div>
            </div>
            
            <!-- الرسوم البيانية والتنبيهات -->
            <div class="charts-alerts-grid">
                <div class="chart-container">
                    <div class="section-header">
                        <h2>مبيعات آخر 7 أيام</h2>
                        <a href="{{ route('reports.index') }}" class="view-all">عرض التفاصيل</a>
                    </div>
                    <div class="chart-wrapper">
                        <canvas id="salesChart"></canvas>
                    </div>
                </div>
                
                <div class="alerts-container">
                    <div class="section-header">
                        <h2>التنبيهات</h2>
                        <span class="notification-badge">{{ count($alerts) }}</span>
                    </div>
                    <div class="alerts-list">
                        @forelse($alerts as $alert)
                        <div class="alert-item {{ $alert['type'] }}" onclick="handleAlertClick('{{ $alert['type'] }}', '{{ $alert['title'] }}')">
                            <div class="alert-icon">
                                <i class="{{ $alert['icon'] }}"></i>
                            </div>
                            <div class="alert-content">
                                <h4>{{ $alert['title'] }}</h4>
                                <p>{{ $alert['message'] }}</p>
                                <div class="alert-time">{{ $alert['time'] }}</div>
                            </div>
                        </div>
                        @empty
                        <div class="alert-item info">
                            <div class="alert-icon">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <div class="alert-content">
                                <h4>لا توجد تنبيهات</h4>
                                <p>كل شيء يعمل بشكل طبيعي</p>
                            </div>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
            
            <!-- أحدث المنتجات -->
            <div class="recent-products">
                <div class="section-header">
                    <h2>أحدث المنتجات</h2>
                    <a href="{{ route('products.index') }}" class="view-all">عرض جميع المنتجات</a>
                </div>
                <table class="products-table">
                    <thead>
                        <tr>
                            <th>اسم المنتج</th>
                            <th>التصنيف</th>
                            <th>الكمية</th>
                            <th>سعر البيع</th>
                            <th>الحالة</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentProducts as $product)
                        <tr onclick="navigateTo('{{ route('products.index') }}')" style="cursor: pointer;">
                            <td>{{ $product['name'] }}</td>
                            <td>{{ $product['category'] }}</td>
                            <td>{{ $product['quantity'] }}</td>
                            <td>{{ number_format($product['price'], 2) }} ر.س</td>
                            <td>
                                <span class="product-badge {{ $product['status'] }}">
                                    @if($product['status'] == 'low')
                                    منخفض
                                    @elseif($product['status'] == 'expiring')
                                    قريب الانتهاء
                                    @else
                                    طبيعي
                                    @endif
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" style="text-align: center; padding: 30px; color: #8e8e93;">
                                <i class="fas fa-box" style="font-size: 48px; margin-bottom: 15px; opacity: 0.3; display: block;"></i>
                                لا توجد منتجات مضافة بعد
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        // رمز CSRF
        const csrfToken = '{{ csrf_token() }}';
        
        // عرض التاريخ الحالي
        function updateCurrentDate() {
            const now = new Date();
            const options = { 
                weekday: 'long', 
                year: 'numeric', 
                month: 'long', 
                day: 'numeric' 
            };
            const dateString = now.toLocaleDateString('ar-SA', options);
            document.getElementById('currentDate').textContent = dateString;
        }
        
        // تفعيل/تعطيل الشريط الجانبي على الجوال
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('active');
        }
        
        // التنقل للصفحات
        function navigateTo(url) {
            window.location.href = url;
        }
        
        // التعامل مع تنبيهات النقر
        function handleAlertClick(type, title) {
            let message = '';
            switch(type) {
                case 'critical':
                    message = 'تنبيه حرج: ' + title;
                    break;
                case 'warning':
                    message = 'تنبيه تحذير: ' + title;
                    break;
                case 'info':
                    message = 'تنبيه معلومات: ' + title;
                    break;
            }
            console.log(message);
            // يمكنك هنا فتح صفحة أو عرض تفاصيل التنبيه
        }
        
        // عرض التنبيهات
        function showNotifications() {
            // يمكنك هنا فتح نافذة التنبيهات
            alert('لديك {{ count($alerts) }} تنبيهات. يمكنك عرضها من قسم التنبيهات.');
        }
        
        // الرسم البياني للمبيعات
        function initSalesChart() {
            const ctx = document.getElementById('salesChart').getContext('2d');
            
            // البيانات من الـ Controller
            const labels = @json($charts['sales']['labels']);
            const data = @json($charts['sales']['data']);
            
            const chart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'المبيعات (ر.س)',
                        data: data,
                        borderColor: 'rgba(0, 102, 255, 1)',
                        backgroundColor: 'rgba(0, 102, 255, 0.1)',
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return 'المبيعات: ' + context.parsed.y.toLocaleString('ar-SA') + ' ر.س';
                                }
                            }
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
                                    return value.toLocaleString('ar-SA') + ' ر.س';
                                }
                            }
                        }
                    }
                }
            });
            
            return chart;
        }
        
        // تحديث البيانات الحية
        async function updateLiveData() {
            try {
                const response = await fetch('/dashboard/stats', {
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    }
                });
                
                const data = await response.json();
                
                // تحديث البطاقات الإحصائية
                document.querySelector('.stat-card.sales .stat-value').textContent = 
                    data.sales.toLocaleString('ar-SA', {minimumFractionDigits: 2}) + ' ر.س';
                
                document.querySelector('.stat-card.products .stat-value').textContent = 
                    data.products.toLocaleString('ar-SA');
                
                document.querySelector('.stat-card.profit .stat-value').textContent = 
                    data.profit.toLocaleString('ar-SA', {minimumFractionDigits: 2}) + ' ر.س';
                
            } catch (error) {
                console.error('Error updating data:', error);
            }
        }
        
        // تهيئة النظام عند تحميل الصفحة
        document.addEventListener('DOMContentLoaded', function() {
            updateCurrentDate();
            const salesChart = initSalesChart();
            
            // إضافة تأثيرات للبطاقات
            const statCards = document.querySelectorAll('.stat-card');
            statCards.forEach(card => {
                card.addEventListener('click', function() {
                    this.style.transform = 'translateY(-5px) scale(1.02)';
                    setTimeout(() => {
                        this.style.transform = 'translateY(-5px)';
                    }, 150);
                });
            });
            
            // إضافة تأثيرات للتنبيهات
            const alertItems = document.querySelectorAll('.alert-item');
            alertItems.forEach(item => {
                item.addEventListener('click', function() {
                    this.style.background = '#f2f2f7';
                    setTimeout(() => {
                        this.style.background = '';
                    }, 300);
                });
            });
            
            // إضافة تأثيرات لصفوف المنتجات
            const productRows = document.querySelectorAll('.products-table tbody tr');
            productRows.forEach(row => {
                row.addEventListener('mouseenter', function() {
                    this.style.background = '#fafafa';
                });
                row.addEventListener('mouseleave', function() {
                    this.style.background = '';
                });
            });
            
            // تحديث البيانات كل دقيقة
            setInterval(updateLiveData, 60000);
        });
        
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
        
        // تحديث التاريخ كل ساعة
        setInterval(updateCurrentDate, 3600000);
        
        // تحديث البيانات عند تركيز النافذة
        window.addEventListener('focus', updateLiveData);
    </script>
</body>
</html>