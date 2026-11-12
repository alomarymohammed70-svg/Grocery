<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') | نظام إدارة البقالة</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/sidebar.css') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* CSS styles from original file */
       

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

        /* الشريط الجانبي */
        

        

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

        /* زر إضافة مورد */
        .btn-add {
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

        .btn-add:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 102, 255, 0.3);
        }

        /* إحصائيات الموردين */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 20px;
            margin-bottom: 20px;
            flex-shrink: 0;
        }

        .stat-card {
            background: white;
            border-radius: var(--border-radius);
            padding: 25px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            border-top: 4px solid transparent;
        }

        .stat-card.total {
            border-top-color: var(--primary-color);
        }

        .stat-card.debt {
            border-top-color: var(--warning-color);
        }

        .stat-card.inactive {
            border-top-color: var(--danger-color);
        }

        .stat-card.active {
            border-top-color: var(--success-color);
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

        .stat-card.total .stat-icon {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        }

        .stat-card.debt .stat-icon {
            background: linear-gradient(135deg, var(--warning-color), #ffcc00);
        }

        .stat-card.inactive .stat-icon {
            background: linear-gradient(135deg, var(--danger-color), #ff6961);
        }

        .stat-card.active .stat-icon {
            background: linear-gradient(135deg, var(--success-color), #4cd964);
        }

        .stat-value {
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .stat-label {
            color: #8e8e93;
            font-size: 14px;
        }

        /* البحث والتحكم */
        .controls {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            gap: 15px;
            flex-wrap: wrap;
            flex-shrink: 0;
        }

        .search-box {
            flex: 1;
            min-width: 300px;
            position: relative;
        }

        .search-box input {
            width: 100%;
            padding: 15px 20px 15px 50px;
            border: 1px solid #e5e5ea;
            border-radius: 12px;
            font-size: 16px;
            transition: all var(--transition-speed) ease;
            background: white;
        }

        .search-box input:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(0, 102, 255, 0.1);
        }

        .search-box i {
            position: absolute;
            right: 20px;
            top: 50%;
            transform: translateY(-50%);
            color: #8e8e93;
        }

        .filter-controls {
            display: flex;
            gap: 10px;
        }

        .filter-select {
            padding: 12px 20px;
            border: 1px solid #e5e5ea;
            border-radius: 12px;
            background: white;
            color: #1c1c1e;
            font-size: 14px;
            cursor: pointer;
            min-width: 150px;
        }

        /* جدول الموردين */
        .suppliers-table-container {
            background: white;
            border-radius: var(--border-radius);
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            flex: 1;
            display: flex;
            flex-direction: column;
            min-height: 0;
        }

        .table-header {
            padding: 25px;
            border-bottom: 1px solid #e5e5ea;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-shrink: 0;
        }

        .table-header h3 {
            font-size: 18px;
            font-weight: 600;
        }

        .suppliers-table {
            width: 100%;
            border-collapse: collapse;
            flex: 1;
        }

        .suppliers-table th {
            text-align: right;
            padding: 20px;
            color: #8e8e93;
            font-weight: 500;
            border-bottom: 1px solid #e5e5ea;
            background: #fafafa;
            position: sticky;
            top: 0;
            z-index: 10;
        }

        .suppliers-table td {
            padding: 20px;
            border-bottom: 1px solid #f2f2f7;
        }

        .suppliers-table tbody tr {
            transition: background var(--transition-speed) ease;
        }

        .suppliers-table tbody tr:hover {
            background: #fafafa;
        }

        .supplier-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .supplier-avatar {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #8a2be2, #9370db);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 16px;
            flex-shrink: 0;
        }

        .supplier-details h4 {
            font-weight: 500;
            margin-bottom: 4px;
        }

        .supplier-details p {
            font-size: 13px;
            color: #8e8e93;
        }

        .status-cell, .balance-cell {
            text-align: center;
        }

        .status-badge {
            display: inline-block;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 600;
            min-width: 80px;
            text-align: center;
        }

        .status-badge.active {
            background: rgba(52, 199, 89, 0.1);
            color: var(--success-color);
        }

        .status-badge.inactive {
            background: rgba(255, 59, 48, 0.1);
            color: var(--danger-color);
        }

        .balance-badge {
            display: inline-block;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 600;
            min-width: 120px;
            text-align: center;
        }

        .balance-badge.positive {
            background: rgba(52, 199, 89, 0.1);
            color: var(--success-color);
        }

        .balance-badge.negative {
            background: rgba(255, 59, 48, 0.1);
            color: var(--danger-color);
        }

        .balance-badge.zero {
            background: rgba(0, 0, 0, 0.05);
            color: #8e8e93;
        }

        .purchases-count {
            display: inline-block;
            padding: 4px 12px;
            background: rgba(0, 102, 255, 0.1);
            color: var(--primary-color);
            border-radius: 20px;
            font-size: 13px;
            font-weight: 500;
        }

        .actions-cell {
            text-align: center;
            width: 200px;
        }

        .action-buttons {
            display: flex;
            gap: 10px;
            justify-content: center;
        }

        .btn-action {
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

        .btn-view {
            background: rgba(0, 102, 255, 0.1);
            color: var(--primary-color);
        }

        .btn-view:hover {
            background: var(--primary-color);
            color: white;
            transform: translateY(-2px);
        }

        .btn-edit {
            background: rgba(255, 149, 0, 0.1);
            color: var(--warning-color);
        }

        .btn-edit:hover {
            background: var(--warning-color);
            color: white;
            transform: translateY(-2px);
        }

        .btn-delete {
            background: rgba(255, 59, 48, 0.1);
            color: var(--danger-color);
        }

        .btn-delete:hover {
            background: var(--danger-color);
            color: white;
            transform: translateY(-2px);
        }

        .btn-details {
            background: rgba(138, 43, 226, 0.1);
            color: #8a2be2;
        }

        .btn-details:hover {
            background: #8a2be2;
            color: white;
            transform: translateY(-2px);
        }

        /* نافذة تفاصيل المورد */
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
            max-width: 900px;
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

        /* علامات التبويب */
        .modal-tabs {
            display: flex;
            margin-bottom: 25px;
            border-bottom: 2px solid #f2f2f7;
        }

        .modal-tab {
            padding: 12px 24px;
            background: none;
            border: none;
            font-size: 16px;
            font-weight: 500;
            color: #8e8e93;
            cursor: pointer;
            position: relative;
            transition: color var(--transition-speed) ease;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .modal-tab:hover {
            color: var(--primary-color);
        }

        .modal-tab.active {
            color: var(--primary-color);
        }

        .modal-tab.active::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            right: 0;
            height: 3px;
            background: var(--primary-color);
        }

        .modal-content-section {
            display: none;
        }

        .modal-content-section.active {
            display: block;
        }

        /* معلومات المورد */
        .supplier-profile {
            display: flex;
            gap: 25px;
            margin-bottom: 30px;
        }

        .profile-avatar {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #8a2be2, #9370db);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 32px;
            font-weight: 600;
            flex-shrink: 0;
        }

        .profile-info h3 {
            font-size: 24px;
            margin-bottom: 10px;
        }

        .profile-details {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
        }

        .detail-item {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .detail-label {
            color: #8e8e93;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .detail-value {
            font-weight: 500;
            font-size: 16px;
        }

        .financial-summary {
            background: #fafafa;
            border-radius: 12px;
            padding: 20px;
            margin-top: 20px;
        }

        .financial-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 20px;
            margin-top: 15px;
        }

        .financial-item {
            text-align: center;
        }

        .financial-value {
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .financial-label {
            color: #8e8e93;
            font-size: 14px;
        }

        .financial-value.positive {
            color: var(--success-color);
        }

        .financial-value.negative {
            color: var(--danger-color);
        }

        /* جدول المشتريات */
        .purchases-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .purchases-table th {
            text-align: right;
            padding: 15px;
            color: #8e8e93;
            font-weight: 500;
            border-bottom: 1px solid #e5e5ea;
            background: #fafafa;
        }

        .purchases-table td {
            padding: 15px;
            border-bottom: 1px solid #f2f2f7;
        }

        .payment-status-badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 500;
        }

        .status-paid {
            background: rgba(52, 199, 89, 0.1);
            color: var(--success-color);
        }

        .status-pending {
            background: rgba(255, 149, 0, 0.1);
            color: var(--warning-color);
        }

        .status-overdue {
            background: rgba(255, 59, 48, 0.1);
            color: var(--danger-color);
        }

        /* جدول المدفوعات للمورد */
        .payments-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .payments-table th {
            text-align: right;
            padding: 15px;
            color: #8e8e93;
            font-weight: 500;
            border-bottom: 1px solid #e5e5ea;
            background: #fafafa;
        }

        .payments-table td {
            padding: 15px;
            border-bottom: 1px solid #f2f2f7;
        }

        /* نافذة إضافة/تعديل مورد */
        .supplier-form {
            max-width: 600px;
            margin: 0 auto;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #1c1c1e;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .form-control {
            width: 100%;
            padding: 12px 16px;
            border: 1px solid #e5e5ea;
            border-radius: 12px;
            font-size: 16px;
            transition: all var(--transition-speed) ease;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(0, 102, 255, 0.1);
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }

        .modal-footer {
            padding: 25px;
            border-top: 1px solid #e5e5ea;
            display: flex;
            justify-content: flex-end;
            gap: 15px;
        }

        .btn-secondary {
            padding: 12px 24px;
            border: 1px solid #e5e5ea;
            background: white;
            border-radius: 12px;
            color: #1c1c1e;
            font-weight: 500;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all var(--transition-speed) ease;
        }

        .btn-secondary:hover {
            background: #f2f2f7;
            transform: translateY(-2px);
        }

        .btn-primary {
            padding: 12px 24px;
            border: none;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border-radius: 12px;
            color: white;
            font-weight: 500;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all var(--transition-speed) ease;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 102, 255, 0.3);
        }

        /* رسالة تنبيه */
        .alert-message {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 15px 20px;
            border-radius: 12px;
            background: white;
            box-shadow: 0 4px 20px rgba(0,0,0,0.15);
            display: none;
            align-items: center;
            gap: 12px;
            z-index: 3000;
            transform: translateX(100%);
            transition: transform 0.3s ease;
        }

        .alert-message.show {
            display: flex;
        }

        .alert-message.success {
            border-right: 4px solid var(--success-color);
        }

        .alert-message.warning {
            border-right: 4px solid var(--warning-color);
        }

        .alert-message.error {
            border-right: 4px solid var(--danger-color);
        }

        .alert-message i {
            font-size: 20px;
        }

        .alert-message.success i {
            color: var(--success-color);
        }

        .alert-message.warning i {
            color: var(--warning-color);
        }

        .alert-message.error i {
            color: var(--danger-color);
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
            
            .stats-grid {
                grid-template-columns: 1fr;
            }
            
            .controls {
                flex-direction: column;
                align-items: stretch;
            }
            
            .search-box {
                min-width: 100%;
            }
            
            .supplier-profile {
                flex-direction: column;
                align-items: center;
                text-align: center;
            }
            
            .suppliers-table {
                display: block;
                overflow-x: auto;
            }
            
            .form-row {
                grid-template-columns: 1fr;
            }
            
            .action-buttons {
                flex-wrap: wrap;
            }
            
            .actions-cell {
                width: auto;
            }
        }

        @media (max-width: 480px) {
            .filter-controls {
                flex-direction: column;
                width: 100%;
            }
            
            .filter-select {
                width: 100%;
            }
            
            .modal-footer {
                flex-direction: column;
            }
            
            .btn-secondary, .btn-primary {
                width: 100%;
                justify-content: center;
            }
        }

        /* تحسينات للجدول */
        .table-scroll {
            overflow-y: auto;
            flex: 1;
            min-height: 0;
        }

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

        /* تحسين الأزرار في الجدول */
        .table-actions {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }
    </style>
    @stack('styles')
</head>
<body>
    <div class="dashboard-container">
        @include('partials.sidebar')
        
        <div class="main-content">
            @yield('content')
        </div>
    </div>
    
    <!-- رسالة تنبيه -->
    <div id="alertMessage" class="alert-message">
        <i class="fas fa-check-circle"></i>
        <span id="alertText">تمت العملية بنجاح</span>
    </div>

    <script>
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
                sidebar && 
                !sidebar.contains(event.target) && 
                mobileMenuBtn && 
                !mobileMenuBtn.contains(event.target) && 
                sidebar.classList.contains('active')) {
                sidebar.classList.remove('active');
            }
        });

        // عرض رسالة تنبيه
        function showAlert(message, type = 'success') {
            const alert = document.getElementById('alertMessage');
            const alertText = document.getElementById('alertText');
            
            if (alert && alertText) {
                alertText.textContent = message;
                alert.className = `alert-message ${type} show`;
                
                setTimeout(() => {
                    alert.classList.remove('show');
                }, 3000);
            }
            alert.style.display = 'flex';
        }

        // دالة للمساعدة في الحصول على الأحرف الأولى
        function getInitials(name) {
            if (!name) return '';
            const names = name.split(' ');
            if (names.length >= 2) {
                return names[0][0] + names[1][0];
            }
            return name.substring(0, 2).toUpperCase();
        }

        // عرض أو إخفاء النافذة المنبثقة
        function toggleModal(modalId, show = true) {
            const modal = document.getElementById(modalId);
            if (modal) {
                if (show) {
                    modal.classList.add('active');
                } else {
                    modal.classList.remove('active');
                }
            }
        }

        // تبديل علامات التبويب في النوافذ المنبثقة
        function switchTab(containerId, tabName) {
            const container = document.getElementById(containerId);
            if (!container) return;
            
            // تحديث علامات التبويب
            container.querySelectorAll('.modal-tab').forEach(tab => {
                tab.classList.remove('active');
            });
            event.target.classList.add('active');
            
            // تحديث المحتوى
            container.querySelectorAll('.modal-content-section').forEach(section => {
                section.classList.remove('active');
            });
            const tabContent = container.querySelector(`#${tabName}-tab`);
            if (tabContent) {
                tabContent.classList.add('active');
            }
        }

        // دالة تنفيذ حذف مع تأكيد
        function confirmDelete(url, message = 'هل أنت متأكد من الحذف؟') {
            if (confirm(message)) {
                window.location.href = url;
            }
        }

        // التعامل مع النموذج
        function handleFormSubmit(formId, url, method = 'POST') {
            const form = document.getElementById(formId);
            if (!form) return;
            
            form.addEventListener('submit', async function(e) {
                e.preventDefault();
                
                const formData = new FormData(this);
                const response = await fetch(url, {
                    method: method,
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    }
                });
                
                const data = await response.json();
                
                if (data.success) {
                    showAlert(data.message, 'success');
                    setTimeout(() => {
                        window.location.href = data.redirect || window.location.href;
                    }, 1500);
                } else {
                    showAlert(data.message, 'error');
                }
            });
        }

        @if(session('success'))
            showAlert('{{ session('success') }}', 'success');
        @endif

        @if(session('error'))
            showAlert('{{ session('error') }}', 'error');
        @endif

        @if(session('warning'))
            showAlert('{{ session('warning') }}', 'warning');
        @endif

        @stack('scripts')
    </script>
</body>
</html>