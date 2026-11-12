<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>العملاء والديون | نظام إدارة البقالة</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/sidebar.css') }}">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=SF+Pro+Display:wght@300;400;500;600;700&display=swap');

        :root {
            --primary-color: #0066ff;
            --secondary-color: #5ac8fa;
            --success-color: #34c759;
            --warning-color: #ff9500;
            --danger-color: #ff3b30;
            --dark-color: #1c1c1e;
            --light-color: #f2f2f7;
            --transition-speed: 0.3s;
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

        .main-content {
            flex: 1;
            padding: 20px;
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .top-bar {
            background: white;
            border-radius: var(--border-radius);
            padding: 15px 25px;
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

        .btn-add {
            background: linear-gradient(135deg, var(--success-color), #4cd964);
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
            box-shadow: 0 8px 20px rgba(52, 199, 89, 0.3);
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
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

        .stat-card.high-debt {
            border-top-color: var(--danger-color);
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

        .stat-card.high-debt .stat-icon {
            background: linear-gradient(135deg, var(--danger-color), #ff6961);
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

        .controls {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            gap: 15px;
            flex-wrap: wrap;
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

        .customers-table-container {
            background: white;
            border-radius: var(--border-radius);
            padding: 0;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            overflow: hidden;
            flex: 1;
            display: flex;
            flex-direction: column;
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

        .customers-table {
            width: 100%;
            border-collapse: collapse;
        }

        .customers-table th {
            text-align: right;
            padding: 20px;
            color: #8e8e93;
            font-weight: 500;
            border-bottom: 1px solid #e5e5ea;
            background: #fafafa;
        }

        .customers-table td {
            padding: 20px;
            border-bottom: 1px solid #f2f2f7;
        }

        .customers-table tbody tr {
            transition: background var(--transition-speed) ease;
        }

        .customers-table tbody tr:hover {
            background: #fafafa;
        }

        .customer-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .customer-avatar {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 16px;
        }

        .customer-details h4 {
            font-weight: 500;
            margin-bottom: 4px;
        }

        .customer-details p {
            font-size: 13px;
            color: #8e8e93;
        }

        .balance-cell {
            text-align: center;
        }

        .balance-badge {
            display: inline-block;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 600;
        }

        .balance-badge.zero {
            background: rgba(52, 199, 89, 0.1);
            color: var(--success-color);
        }

        .balance-badge.low {
            background: rgba(255, 149, 0, 0.1);
            color: var(--warning-color);
        }

        .balance-badge.high {
            background: rgba(255, 59, 48, 0.1);
            color: var(--danger-color);
        }

        .invoices-count {
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
        }

        .btn-edit {
            background: rgba(255, 149, 0, 0.1);
            color: var(--warning-color);
        }

        .btn-edit:hover {
            background: var(--warning-color);
            color: white;
        }

        .btn-pay {
            background: rgba(52, 199, 89, 0.1);
            color: var(--success-color);
        }

        .btn-pay:hover {
            background: var(--success-color);
            color: white;
        }

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
        }

        .modal-body {
            padding: 25px;
        }

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

        .customer-profile {
            display: flex;
            gap: 25px;
            margin-bottom: 30px;
        }

        .profile-avatar {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
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
        }

        .detail-value {
            font-weight: 500;
            font-size: 16px;
        }

        .total-balance {
            background: #fafafa;
            border-radius: 12px;
            padding: 20px;
            margin-top: 20px;
        }

        .balance-amount {
            font-size: 32px;
            font-weight: 700;
            text-align: center;
            margin-bottom: 10px;
        }

        .balance-amount.positive {
            color: var(--success-color);
        }

        .balance-amount.negative {
            color: var(--danger-color);
        }

        .balance-label {
            text-align: center;
            color: #8e8e93;
            font-size: 14px;
        }

        .invoices-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .invoices-table th {
            text-align: right;
            padding: 15px;
            color: #8e8e93;
            font-weight: 500;
            border-bottom: 1px solid #e5e5ea;
            background: #fafafa;
        }

        .invoices-table td {
            padding: 15px;
            border-bottom: 1px solid #f2f2f7;
        }

        .status-badge {
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

        .status-partial {
            background: rgba(255, 149, 0, 0.1);
            color: var(--warning-color);
        }

        .status-unpaid {
            background: rgba(255, 59, 48, 0.1);
            color: var(--danger-color);
        }

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

        .customer-form {
            max-width: 500px;
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

        .payment-form {
            max-width: 400px;
            margin: 0 auto;
        }

        .payment-amount {
            font-size: 32px;
            font-weight: 700;
            text-align: center;
            margin: 20px 0;
            color: var(--primary-color);
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
            transition: all var(--transition-speed) ease;
        }

        .btn-secondary:hover {
            background: #f2f2f7;
        }

        .btn-primary {
            padding: 12px 24px;
            border: none;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border-radius: 12px;
            color: white;
            font-weight: 500;
            cursor: pointer;
            transition: all var(--transition-speed) ease;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 102, 255, 0.3);
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
            transform: translateX(0);
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

        .mobile-menu-btn {
            display: none;
            background: none;
            border: none;
            font-size: 24px;
            color: var(--dark-color);
            cursor: pointer;
            padding: 10px;
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
            
            .customer-profile {
                flex-direction: column;
                align-items: center;
                text-align: center;
            }
            
            .customers-table {
                display: block;
                overflow-x: auto;
            }
            
            .form-row {
                grid-template-columns: 1fr;
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
                    <h1>العملاء والديون</h1>
                    <p>إدارة عملاء المتجر ومتابعة الديون المستحقة</p>
                </div>
                
                <div class="top-bar-actions">
                    <button class="btn-add" onclick="openAddCustomerModal()">
                        <i class="fas fa-user-plus"></i>
                        إضافة عميل جديد
                    </button>
                </div>
            </div>
            
            <!-- إحصائيات العملاء -->
            <div class="stats-grid">
                <div class="stat-card total">
                    <div class="stat-header">
                        <div>
                            <div class="stat-value">{{ $stats['total_customers'] }}</div>
                            <div class="stat-label">إجمالي العملاء</div>
                        </div>
                        <div class="stat-icon">
                            <i class="fas fa-users"></i>
                        </div>
                    </div>
                </div>
                
                <div class="stat-card debt">
                    <div class="stat-header">
                        <div>
                            <div class="stat-value">{{ number_format($stats['total_debt'], 2) }} ر.س</div>
                            <div class="stat-label">إجمالي الديون</div>
                        </div>
                        <div class="stat-icon">
                            <i class="fas fa-money-bill-wave"></i>
                        </div>
                    </div>
                </div>
                
                <div class="stat-card high-debt">
                    <div class="stat-header">
                        <div>
                            <div class="stat-value">{{ $stats['debtors_count'] }}</div>
                            <div class="stat-label">عملاء مدينون</div>
                        </div>
                        <div class="stat-icon">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- البحث والتحكم -->
            <div class="controls">
                <div class="search-box">
                    <i class="fas fa-search"></i>
                    <input type="text" id="searchInput" placeholder="ابحث عن عميل بالاسم أو الهاتف...">
                </div>
                
                <div class="filter-controls">
                    <select class="filter-select" id="balanceFilter">
                        <option value="">جميع الحالات</option>
                        <option value="zero">بدون ديون</option>
                        <option value="low">ديون قليلة</option>
                        <option value="high">ديون كبيرة</option>
                    </select>
                </div>
            </div>
            
            <!-- جدول العملاء -->
            <div class="customers-table-container">
                <div class="table-header">
                    <h3>قائمة العملاء</h3>
                    <div class="table-info">
                        <span id="customersCount">{{ count($customers) }} عميل</span>
                    </div>
                </div>
                
                <table class="customers-table">
                    <thead>
                        <tr>
                            <th>العميل</th>
                            <th>رقم الهاتف</th>
                            <th>الرصيد</th>
                            <th>عدد الفواتير</th>
                            <th>الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody id="customersTableBody">
                        @forelse($customers as $customer)
                        <tr data-customer-id="{{ $customer->id }}">
                            <td>
                                <div class="customer-info">
                                    <div class="customer-avatar">
                                        @php
                                            $names = explode(' ', $customer->name);
                                            if (count($names) >= 2) {
                                                echo mb_substr($names[0], 0, 1) . mb_substr($names[1], 0, 1);
                                            } else {
                                                echo mb_substr($customer->name, 0, 2);
                                            }
                                        @endphp
                                    </div>
                                    <div class="customer-details">
                                        <h4>{{ $customer->name }}</h4>
                                        <p>{{ $customer->phone }}</p>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $customer->phone }}</td>
                            <td class="balance-cell">
                                @php
                                    $balance = $customer->balance;
                                    if ($balance == 0) {
                                        $balanceClass = 'zero';
                                        $balanceText = 'بدون ديون';
                                    } elseif ($balance > 0 && $balance <= 500) {
                                        $balanceClass = 'low';
                                        $balanceText = number_format($balance, 2) . ' ر.س';
                                    } elseif ($balance > 500) {
                                        $balanceClass = 'high';
                                        $balanceText = number_format($balance, 2) . ' ر.س';
                                    } else {
                                        $balanceClass = 'positive';
                                        $balanceText = number_format($balance, 2) . ' ر.س';
                                    }
                                @endphp
                                
                                <span class="balance-badge {{ $balanceClass }}">
                                    {{ $balanceText }}
                                </span>
                            </td>
                            <td>
                             
                               <span class="invoices-count">{{ $customer->credit_sales_count }} فاتورة</span>

                            </td>
                            <td class="actions-cell">
                                <div class="action-buttons">
                                    <button class="btn-action btn-view" onclick="openCustomerDetailsModal({{ $customer->id }})" title="عرض التفاصيل">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="btn-action btn-edit" onclick="openEditCustomerModal({{ $customer->id }})" title="تعديل">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn-action btn-pay" onclick="openPayDebtModal({{ $customer->id }})" title="تسديد دين" {{ $customer->balance <= 0 ? 'disabled style="opacity:0.5;cursor:not-allowed;"' : '' }}>
                                        <i class="fas fa-money-bill-wave"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" style="text-align: center; padding: 40px; color: #8e8e93;">
                                <i class="fas fa-users" style="font-size: 48px; margin-bottom: 15px; opacity: 0.3;"></i>
                                <p>لا توجد عملاء</p>
                                <small>ابدأ بإضافة عميل جديد</small>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <!-- نافذة إضافة/تعديل عميل -->
    <div class="modal" id="customerModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 id="customerModalTitle">إضافة عميل جديد</h3>
                <button class="btn-close" onclick="closeCustomerModal()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <div class="modal-body">
                <form id="customerForm" class="customer-form">
                    @csrf
                    <input type="hidden" id="customerId" name="id">
                    
                    <div class="form-group">
                        <label for="customerName">
                            <i class="fas fa-user"></i> اسم العميل
                        </label>
                        <input type="text" 
                               id="customerName" 
                               name="name"
                               class="form-control" 
                               placeholder="أدخل اسم العميل"
                               required>
                    </div>
                    
                    <div class="form-group">
                        <label for="customerPhone">
                            <i class="fas fa-phone"></i> رقم الهاتف
                        </label>
                        <input type="tel" 
                               id="customerPhone" 
                               name="phone"
                               class="form-control" 
                               placeholder="أدخل رقم الهاتف"
                               required>
                    </div>
                    
                    <div class="form-group">
                        <label for="customerEmail">
                            <i class="fas fa-envelope"></i> البريد الإلكتروني (اختياري)
                        </label>
                        <input type="email" 
                               id="customerEmail" 
                               name="email"
                               class="form-control" 
                               placeholder="أدخل البريد الإلكتروني">
                    </div>
                    
                    <div class="form-group">
                        <label for="customerAddress">
                            <i class="fas fa-map-marker-alt"></i> العنوان (اختياري)
                        </label>
                        <textarea id="customerAddress" 
                                  name="address"
                                  class="form-control" 
                                  rows="3"
                                  placeholder="أدخل العنوان"></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label for="customerNotes">
                            <i class="fas fa-sticky-note"></i> ملاحظات (اختياري)
                        </label>
                        <textarea id="customerNotes" 
                                  name="notes"
                                  class="form-control" 
                                  rows="3"
                                  placeholder="أدخل أي ملاحظات"></textarea>
                    </div>
                </form>
            </div>
            
            <div class="modal-footer">
                <button type="button" class="btn-secondary" onclick="closeCustomerModal()">
                    إلغاء
                </button>
                <button type="button" class="btn-primary" id="saveCustomerButton" onclick="saveCustomer()">
                    حفظ
                </button>
            </div>
        </div>
    </div>
    
    <!-- نافذة تفاصيل العميل -->
    <div class="modal" id="customerDetailsModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 id="customerDetailsTitle">تفاصيل العميل</h3>
                <button class="btn-close" onclick="closeCustomerDetailsModal()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <div class="modal-body">
                <!-- علامات التبويب -->
                <div class="modal-tabs">
                    <button class="modal-tab active" onclick="switchCustomerTab('info')">
                        <i class="fas fa-info-circle"></i> المعلومات
                    </button>
                    <button class="modal-tab" onclick="switchCustomerTab('invoices')">
                        <i class="fas fa-file-invoice"></i> الفواتير
                    </button>
                    <button class="modal-tab" onclick="switchCustomerTab('payments')">
                        <i class="fas fa-money-bill-wave"></i> المدفوعات
                    </button>
                </div>
                
                <!-- معلومات العميل -->
                <div id="customer-info-tab" class="modal-content-section active">
                    <div class="customer-profile" id="customerProfile">
                        <!-- سيتم تعبئة البيانات عن طريق JavaScript -->
                    </div>
                    
                    <div class="total-balance">
                        <div class="balance-amount" id="customerBalanceAmount">0.00 ر.س</div>
                        <div class="balance-label">الرصيد الحالي</div>
                    </div>
                </div>
                
                <!-- فواتير العميل -->
                <div id="customer-invoices-tab" class="modal-content-section">
                    <h4 style="margin-bottom: 20px;">فواتير البيع بالدين</h4>
                    <table class="invoices-table">
                        <thead>
                            <tr>
                                <th>رقم الفاتورة</th>
                                <th>التاريخ</th>
                                <th>قيمة الفاتورة</th>
                                <th>المدفوع</th>
                                <th>المتبقي</th>
                                <th>الحالة</th>
                            </tr>
                        </thead>
                        <tbody id="customerInvoicesTable">
                            <!-- سيتم تعبئة البيانات عن طريق JavaScript -->
                        </tbody>
                    </table>
                </div>
                
                <!-- مدفوعات العميل -->
                <div id="customer-payments-tab" class="modal-content-section">
                    <h4 style="margin-bottom: 20px;">سجل المدفوعات</h4>
                    <table class="payments-table">
                        <thead>
                            <tr>
                                <th>التاريخ</th>
                                <th>رقم الفاتورة</th>
                                <th>المبلغ</th>
                                <th>طريقة الدفع</th>
                                <th>ملاحظات</th>
                            </tr>
                        </thead>
                        <tbody id="customerPaymentsTable">
                            <!-- سيتم تعبئة البيانات عن طريق JavaScript -->
                        </tbody>
                    </table>
                </div>
            </div>
            
            <div class="modal-footer">
                <button type="button" class="btn-secondary" onclick="openPayDebtModalFromDetails()">
                    <i class="fas fa-money-bill-wave"></i> تسديد دين
                </button>
                <button type="button" class="btn-primary" onclick="openEditCustomerModal(currentCustomerId)">
                    <i class="fas fa-edit"></i> تعديل بيانات العميل
                </button>
            </div>
        </div>
    </div>
    
    <!-- نافذة سداد الدين -->
    <div class="modal" id="payDebtModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>تسديد دين</h3>
                <button class="btn-close" onclick="closePayDebtModal()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <div class="modal-body">
                <div class="payment-form">
                    <form id="paymentForm">
                        @csrf
                        <input type="hidden" id="paymentCustomerId" name="customer_id">
                        
                        <div class="form-group">
                            <label>اسم العميل</label>
                            <div class="form-control" id="debtCustomerName" style="background: #fafafa;"></div>
                        </div>
                        
                        <div class="form-group">
                            <label>الرصيد الحالي</label>
                            <div class="payment-amount" id="currentBalance">0.00 ر.س</div>
                        </div>
                        
                        <div class="form-group">
                            <label for="paymentAmount">
                                <i class="fas fa-money-bill-wave"></i> مبلغ السداد
                            </label>
                            <input type="number" 
                                   id="paymentAmount" 
                                   name="amount"
                                   class="form-control" 
                                   placeholder="أدخل مبلغ السداد"
                                   step="0.01"
                                   min="0.01"
                                   required>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="paymentDate">
                                    <i class="fas fa-calendar"></i> تاريخ السداد
                                </label>
                                <input type="date" 
                                       id="paymentDate" 
                                       name="payment_date"
                                       class="form-control" 
                                       required>
                            </div>
                            
                            <div class="form-group">
                                <label for="paymentMethod">
                                    <i class="fas fa-credit-card"></i> طريقة الدفع
                                </label>
                                <select id="paymentMethod" name="payment_method" class="form-control">
                                    <option value="cash">نقداً</option>
                                    <option value="transfer">تحويل بنكي</option>
                                    <option value="check">شيك</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="paymentNotes">
                                <i class="fas fa-sticky-note"></i> ملاحظات (اختياري)
                            </label>
                            <textarea id="paymentNotes" 
                                      name="notes"
                                      class="form-control" 
                                      rows="3"
                                      placeholder="أدخل أي ملاحظات عن السداد"></textarea>
                        </div>
                    </form>
                </div>
            </div>
            
            <div class="modal-footer">
                <button type="button" class="btn-secondary" onclick="closePayDebtModal()">
                    إلغاء
                </button>
                <button type="button" class="btn-primary" id="savePaymentButton" onclick="savePayment()">
                    <i class="fas fa-check"></i> تسديد
                </button>
            </div>
        </div>
    </div>
    
    <!-- رسالة تنبيه -->
    <div id="alertMessage" class="alert-message">
        <i class="fas fa-check-circle"></i>
        <span id="alertText">تمت العملية بنجاح</span>
    </div>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script>
        let currentCustomerId = null;
        let isEditingCustomer = false;

        // Helper functions
        function getCustomerInitials(name) {
            const names = name.split(' ');
            if (names.length >= 2) {
                return names[0][0] + names[1][0];
            }
            return name.substring(0, 2).toUpperCase();
        }

        function getBalanceStatus(balance) {
            if (balance === 0) {
                return { class: 'zero', text: 'بدون ديون' };
            } else if (balance > 0 && balance <= 500) {
                return { class: 'low', text: balance.toFixed(2) + ' ر.س' };
            } else if (balance > 500) {
                return { class: 'high', text: balance.toFixed(2) + ' ر.س' };
            } else {
                return { class: 'positive', text: balance.toFixed(2) + ' ر.س' };
            }
        }

        // عرض رسالة تنبيه
        function showAlert(message, type = 'success') {
            const alert = document.getElementById('alertMessage');
            const alertText = document.getElementById('alertText');
            
            alertText.textContent = message;
            alert.className = `alert-message ${type} show`;
            
            setTimeout(() => {
                alert.classList.remove('show');
            }, 3000);
        }

        // فتح نافذة إضافة عميل
        function openAddCustomerModal() {
            document.getElementById('customerModalTitle').textContent = 'إضافة عميل جديد';
            document.getElementById('customerForm').reset();
            document.getElementById('customerId').value = '';
            isEditingCustomer = false;
            currentCustomerId = null;
            
            // تفعيل زر الحفظ
            const saveButton = document.getElementById('saveCustomerButton');
            saveButton.disabled = false;
            saveButton.innerHTML = 'حفظ';
            
            document.getElementById('customerModal').classList.add('active');
        }

        // فتح نافذة تعديل عميل
        async function openEditCustomerModal(customerId) {
            try {
                // إظهار مؤشر التحميل
                const saveButton = document.getElementById('saveCustomerButton');
                saveButton.disabled = true;
                saveButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> جاري التحميل...';
                
                document.getElementById('customerModalTitle').textContent = 'تعديل بيانات العميل';
                document.getElementById('customerModal').classList.add('active');
                
                const response = await fetch(`/customers/${customerId}/edit`);
                const result = await response.json();
                
                if (result.success) {
                    const customer = result.data;
                    
                    document.getElementById('customerId').value = customer.id;
                    document.getElementById('customerName').value = customer.name;
                    document.getElementById('customerPhone').value = customer.phone;
                    document.getElementById('customerEmail').value = customer.email || '';
                    document.getElementById('customerAddress').value = customer.address || '';
                    document.getElementById('customerNotes').value = customer.notes || '';
                    
                    isEditingCustomer = true;
                    currentCustomerId = customerId;
                    
                    // إعادة تفعيل زر الحفظ
                    saveButton.disabled = false;
                    saveButton.innerHTML = 'حفظ';
                } else {
                    showAlert(result.message || 'حدث خطأ', 'error');
                    closeCustomerModal();
                }
            } catch (error) {
                console.error('Error:', error);
                showAlert('حدث خطأ في جلب بيانات العميل', 'error');
                closeCustomerModal();
            }
        }

        // إغلاق نافذة العميل
        function closeCustomerModal() {
            document.getElementById('customerModal').classList.remove('active');
        }

        // حفظ العميل
        async function saveCustomer() {
            const nameInput = document.getElementById('customerName');
            const phoneInput = document.getElementById('customerPhone');
            
            // التحقق من الصحة
            if (!nameInput.value.trim()) {
                showAlert('يرجى إدخال اسم العميل', 'error');
                nameInput.focus();
                return;
            }
            
            if (!phoneInput.value.trim()) {
                showAlert('يرجى إدخال رقم الهاتف', 'error');
                phoneInput.focus();
                return;
            }
            
            // تعطيل زر الحفظ أثناء المعالجة
            const saveButton = document.getElementById('saveCustomerButton');
            saveButton.disabled = true;
            saveButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> جاري الحفظ...';
            
            const data = {
                name: nameInput.value.trim(),
                phone: phoneInput.value.trim(),
                email: document.getElementById('customerEmail').value.trim(),
                address: document.getElementById('customerAddress').value.trim(),
                notes: document.getElementById('customerNotes').value.trim(),
                _token: document.querySelector('meta[name="csrf-token"]').content
            };
            
            const url = isEditingCustomer ? `/customers/${currentCustomerId}` : '/customers';
            const method = isEditingCustomer ? 'PUT' : 'POST';
            
            if (isEditingCustomer) {
                data._method = 'PUT';
            }
            
            try {
                const response = await fetch(url, {
                    method: method,
                    headers: {
                        'X-CSRF-TOKEN': data._token,
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(data)
                });
                
                const result = await response.json();
                
                if (result.success) {
                    showAlert(result.message);
                    closeCustomerModal();
                    
                    setTimeout(() => {
                        location.reload();
                    }, 1500);
                } else {
                    let errorMessage = result.message || 'حدث خطأ';
                    if (result.errors) {
                        errorMessage = Object.values(result.errors).flat().join(', ');
                    }
                    showAlert(errorMessage, 'error');
                    
                    // إعادة تفعيل زر الحفظ
                    saveButton.disabled = false;
                    saveButton.innerHTML = 'حفظ';
                }
            } catch (error) {
                console.error('Error:', error);
                showAlert('حدث خطأ في حفظ العميل', 'error');
                
                // إعادة تفعيل زر الحفظ
                saveButton.disabled = false;
                saveButton.innerHTML = 'حفظ';
            }
        }

        // فتح نافذة تفاصيل العميل
        async function openCustomerDetailsModal(customerId) {
            try {
                const response = await fetch(`/customers/${customerId}`);
                const result = await response.json();
                
                if (result.success) {
                    currentCustomerId = customerId;
                    const customer = result.data.customer;
                    
                    document.getElementById('customerDetailsTitle').textContent = `تفاصيل العميل: ${customer.name}`;
                    
                    // تحديث علامات التبويب
                    switchCustomerTab('info');
                    
                    // تحديث معلومات العميل
                    updateCustomerProfile(customer);
                    
                    // تحديث فواتير العميل
                    updateCustomerInvoices(result.data.invoices || []);
                    
                    // تحديث مدفوعات العميل
                    updateCustomerPayments(result.data.payments || []);
                    
                    document.getElementById('customerDetailsModal').classList.add('active');
                } else {
                    showAlert(result.message, 'error');
                }
            } catch (error) {
                console.error('Error:', error);
                showAlert('حدث خطأ في جلب بيانات العميل', 'error');
            }
        }

        // إغلاق نافذة تفاصيل العميل
        function closeCustomerDetailsModal() {
            document.getElementById('customerDetailsModal').classList.remove('active');
        }

        // تبديل علامات التبويب
        function switchCustomerTab(tabName) {
            // تحديث علامات التبويب
            document.querySelectorAll('.modal-tab').forEach(tab => {
                tab.classList.remove('active');
            });
            event.target.classList.add('active');
            
            // تحديث المحتوى
            document.querySelectorAll('.modal-content-section').forEach(section => {
                section.classList.remove('active');
            });
            document.getElementById(`customer-${tabName}-tab`).classList.add('active');
        }

        // تحديث معلومات العميل
        function updateCustomerProfile(customer) {
            const profileDiv = document.getElementById('customerProfile');
            const balanceAmount = document.getElementById('customerBalanceAmount');
            
            // تحديث الصورة والمعلومات
            profileDiv.innerHTML = `
                <div class="profile-avatar">
                    ${getCustomerInitials(customer.name)}
                </div>
                <div class="profile-info">
                    <h3>${customer.name}</h3>
                    <div class="profile-details">
                        <div class="detail-item">
                            <span class="detail-label">رقم الهاتف</span>
                            <span class="detail-value">${customer.phone}</span>
                        </div>
                        ${customer.email ? `
                        <div class="detail-item">
                            <span class="detail-label">البريد الإلكتروني</span>
                            <span class="detail-value">${customer.email}</span>
                        </div>
                        ` : ''}
                        ${customer.address ? `
                        <div class="detail-item">
                            <span class="detail-label">العنوان</span>
                            <span class="detail-value">${customer.address}</span>
                        </div>
                        ` : ''}
                        ${customer.notes ? `
                        <div class="detail-item">
                            <span class="detail-label">ملاحظات</span>
                            <span class="detail-value">${customer.notes}</span>
                        </div>
                        ` : ''}
                        <div class="detail-item">
                            <span class="detail-label">تاريخ الإضافة</span>
                            <span class="detail-value">${new Date(customer.created_at).toLocaleDateString('ar-SA')}</span>
                        </div>
                    </div>
                </div>
            `;
            
            // تحديث الرصيد
            const balance = customer.balance || 0;
            balanceAmount.textContent = Math.abs(balance).toFixed(2) + ' ر.س';
            balanceAmount.className = `balance-amount ${balance >= 0 ? 'negative' : 'positive'}`;
            
            // تحديث نص الرصيد
            const balanceLabel = document.querySelector('.balance-label');
            if (balance > 0) {
                balanceLabel.textContent = 'مدين';
            } else if (balance < 0) {
                balanceLabel.textContent = 'لديه رصيد';
            } else {
                balanceLabel.textContent = 'بدون ديون';
            }
        }

        // تحديث فواتير العميل
        function updateCustomerInvoices(invoices) {
            const tbody = document.getElementById('customerInvoicesTable');
            tbody.innerHTML = '';
            
            if (invoices.length === 0) {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td colspan="6" style="text-align: center; padding: 40px; color: #8e8e93;">
                        <i class="fas fa-file-invoice" style="font-size: 48px; margin-bottom: 15px; opacity: 0.3;"></i>
                        <p>لا توجد فواتير</p>
                        <small>لم يتم تسجيل أي فواتير دين لهذا العميل</small>
                    </td>
                `;
                tbody.appendChild(row);
            } else {
                invoices.forEach(invoice => {
                    const row = document.createElement('tr');
                    
                    let statusClass = '';
                    let statusText = '';
                    
                    if (invoice.remaining <= 0) {
                        statusClass = 'status-paid';
                        statusText = 'مدفوعة';
                    } else if (invoice.paid > 0) {
                        statusClass = 'status-partial';
                        statusText = 'جزئية';
                    } else {
                        statusClass = 'status-unpaid';
                        statusText = 'غير مدفوعة';
                    }
                    
                    row.innerHTML = `
                        <td>#${invoice.invoice_number || invoice.id}</td>
                        <td>${new Date(invoice.created_at).toLocaleDateString('ar-SA')}</td>
                        <td>${(invoice.total || 0).toFixed(2)} ر.س</td>
                        <td>${(invoice.paid_amount || 0).toFixed(2)} ر.س</td>
                        <td>${(invoice.remaining_amount || invoice.total || 0).toFixed(2)} ر.س</td>
                        <td><span class="status-badge ${statusClass}">${statusText}</span></td>
                    `;
                    tbody.appendChild(row);
                });
            }
        }

        // تحديث مدفوعات العميل
        function updateCustomerPayments(payments) {
            const tbody = document.getElementById('customerPaymentsTable');
            tbody.innerHTML = '';
            
            if (payments.length === 0) {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td colspan="5" style="text-align: center; padding: 40px; color: #8e8e93;">
                        <i class="fas fa-money-bill-wave" style="font-size: 48px; margin-bottom: 15px; opacity: 0.3;"></i>
                        <p>لا توجد مدفوعات</p>
                        <small>لم يتم تسجيل أي مدفوعات لهذا العميل</small>
                    </td>
                `;
                tbody.appendChild(row);
            } else {
                payments.forEach(payment => {
                    const row = document.createElement('tr');
                    
                    let methodText = '';
                    switch(payment.payment_method) {
                        case 'cash': methodText = 'نقداً'; break;
                        case 'transfer': methodText = 'تحويل بنكي'; break;
                        case 'check': methodText = 'شيك'; break;
                        default: methodText = payment.payment_method;
                    }
                    
                    row.innerHTML = `
                        <td>${new Date(payment.created_at).toLocaleDateString('ar-SA')}</td>
                        <td>#${payment.sale_id || payment.id}</td>
                        <td>${(payment.amount || 0).toFixed(2)} ر.س</td>
                        <td>${methodText}</td>
                        <td>${payment.notes || '-'}</td>
                    `;
                    tbody.appendChild(row);
                });
            }
        }

        // فتح نافذة سداد الدين من التفاصيل
        function openPayDebtModalFromDetails() {
            if (currentCustomerId) {
                openPayDebtModal(currentCustomerId);
            }
        }

        // فتح نافذة سداد الدين
        async function openPayDebtModal(customerId = null) {
            const customerIdToUse = customerId || currentCustomerId;
            
            try {
                const response = await fetch(`/customers/${customerIdToUse}`);
                const result = await response.json();
                
                if (result.success) {
                    const customer = result.data.customer;
                    const balance = customer.balance || 0;
                    
                    if (balance <= 0) {
                        showAlert('هذا العميل ليس لديه ديون للسداد', 'warning');
                        return;
                    }
                    
                    document.getElementById('debtCustomerName').textContent = customer.name;
                    document.getElementById('currentBalance').textContent = balance.toFixed(2) + ' ر.س';
                    document.getElementById('paymentAmount').value = '';
                    document.getElementById('paymentDate').value = new Date().toISOString().split('T')[0];
                    document.getElementById('paymentNotes').value = '';
                    document.getElementById('paymentCustomerId').value = customerIdToUse;
                    
                    if (currentCustomerId) {
                        closeCustomerDetailsModal();
                    }
                    
                    currentCustomerId = customerIdToUse;
                    document.getElementById('payDebtModal').classList.add('active');
                } else {
                    showAlert(result.message, 'error');
                }
            } catch (error) {
                console.error('Error:', error);
                showAlert('حدث خطأ في جلب بيانات العميل', 'error');
            }
        }

        // إغلاق نافذة سداد الدين
        function closePayDebtModal() {
            document.getElementById('payDebtModal').classList.remove('active');
            if (currentCustomerId) {
                openCustomerDetailsModal(currentCustomerId);
            }
        }

        // حفظ السداد
        async function savePayment() {
            const paymentAmount = document.getElementById('paymentAmount');
            const paymentDate = document.getElementById('paymentDate');
            
            // التحقق من الصحة
            if (!paymentAmount.value || parseFloat(paymentAmount.value) <= 0) {
                showAlert('يرجى إدخال مبلغ صحيح للسداد', 'error');
                paymentAmount.focus();
                return;
            }
            
            if (!paymentDate.value) {
                showAlert('يرجى تحديد تاريخ السداد', 'error');
                paymentDate.focus();
                return;
            }
            
            // تعطيل زر الحفظ أثناء المعالجة
            const saveButton = document.getElementById('savePaymentButton');
            saveButton.disabled = true;
            saveButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> جاري التسديد...';
            
            const data = {
                customer_id: document.getElementById('paymentCustomerId').value,
                amount: parseFloat(paymentAmount.value),
                payment_date: paymentDate.value,
                payment_method: document.getElementById('paymentMethod').value,
                notes: document.getElementById('paymentNotes').value.trim(),
                _token: document.querySelector('meta[name="csrf-token"]').content
            };
            
            try {
                const response = await fetch('/customer-payments', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': data._token,
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(data)
                });
                
                const result = await response.json();
                
                if (result.success) {
                    showAlert(result.message);
                    closePayDebtModal();
                    setTimeout(() => {
                        location.reload();
                    }, 1500);
                } else {
                    let errorMessage = result.message || 'حدث خطأ';
                    if (result.errors) {
                        errorMessage += ': ' + Object.values(result.errors).join(', ');
                    }
                    showAlert(errorMessage, 'error');
                    
                    // إعادة تفعيل زر الحفظ
                    saveButton.disabled = false;
                    saveButton.innerHTML = '<i class="fas fa-check"></i> تسديد';
                }
            } catch (error) {
                console.error('Error:', error);
                showAlert('حدث خطأ في حفظ السداد: ' + error.message, 'error');
                
                // إعادة تفعيل زر الحفظ
                saveButton.disabled = false;
                saveButton.innerHTML = '<i class="fas fa-check"></i> تسديد';
            }
        }

        // تفعيل/تعطيل الشريط الجانبي على الجوال
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            if (sidebar) {
                sidebar.classList.toggle('active');
            }
        }

        // البحث الفوري
        function filterCustomers() {
            const searchTerm = document.getElementById('searchInput').value.toLowerCase();
            const balanceFilter = document.getElementById('balanceFilter').value;
            const rows = document.querySelectorAll('#customersTableBody tr[data-customer-id]');
            
            let visibleCount = 0;
            
            rows.forEach(row => {
                const name = row.querySelector('.customer-details h4').textContent.toLowerCase();
                const phone = row.cells[1].textContent;
                const balanceBadge = row.querySelector('.balance-badge');
                const balanceClass = balanceBadge ? balanceBadge.className.split(' ').find(cls => ['zero', 'low', 'high', 'positive'].includes(cls)) : '';
                
                let matchesSearch = name.includes(searchTerm) || phone.includes(searchTerm);
                let matchesFilter = true;
                
                if (balanceFilter && balanceClass !== balanceFilter) {
                    matchesFilter = false;
                }
                
                if (matchesSearch && matchesFilter) {
                    row.style.display = '';
                    visibleCount++;
                } else {
                    row.style.display = 'none';
                }
            });
            
            document.getElementById('customersCount').textContent = `${visibleCount} عميل`;
        }

        // إغلاق النوافذ عند النقر خارجها
        document.addEventListener('click', function(event) {
            const modals = ['customerModal', 'customerDetailsModal', 'payDebtModal'];
            
            modals.forEach(modalId => {
                const modal = document.getElementById(modalId);
                if (modal && modal.classList.contains('active') && event.target === modal) {
                    modal.classList.remove('active');
                }
            });
            
            // إغلاق الشريط الجانبي
            const sidebar = document.getElementById('sidebar');
            const mobileMenuBtn = document.querySelector('.mobile-menu-btn');
            
            if (window.innerWidth <= 768 && 
                sidebar && 
                mobileMenuBtn &&
                !sidebar.contains(event.target) && 
                !mobileMenuBtn.contains(event.target) && 
                sidebar.classList.contains('active')) {
                sidebar.classList.remove('active');
            }
        });

        // إغلاق النوافذ عند الضغط على ESC
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                const modals = ['customerModal', 'customerDetailsModal', 'payDebtModal'];
                modals.forEach(modalId => {
                    const modal = document.getElementById(modalId);
                    if (modal && modal.classList.contains('active')) {
                        modal.classList.remove('active');
                    }
                });
            }
        });

        // التهيئة
        document.addEventListener('DOMContentLoaded', function() {
            // إضافة أحداث البحث والتصفية
            const searchInput = document.getElementById('searchInput');
            const balanceFilter = document.getElementById('balanceFilter');
            
            if (searchInput) {
                searchInput.addEventListener('input', filterCustomers);
            }
            
            if (balanceFilter) {
                balanceFilter.addEventListener('change', filterCustomers);
            }
            
            // تعيين تاريخ اليوم في حقل تاريخ السداد
            const paymentDate = document.getElementById('paymentDate');
            if (paymentDate && !paymentDate.value) {
                paymentDate.value = new Date().toISOString().split('T')[0];
            }
        });

        // دالة debug لفحص الـ API
async function testApi(customerId) {
    console.log('🔍 اختبار API للعميل ID:', customerId);
    
    try {
        // اختبار المسار /customers/{id}
        const response = await fetch(`/customers/${customerId}`);
        console.log('📡 استجابة API:', response.status);
        
        const result = await response.json();
        console.log('📊 بيانات الرد:', result);
        
        if (result.success) {
            console.log('✅ العميل:', result.data.customer);
            console.log('📄 الفواتير:', result.data.invoices);
            console.log('💳 المدفوعات:', result.data.payments);
            
            // اختبار المسار /customers/{id}/edit
            const editResponse = await fetch(`/customers/${customerId}/edit`);
            const editResult = await editResponse.json();
            console.log('✏️ بيانات التعديل:', editResult);
        } else {
            console.error('❌ خطأ:', result.message);
        }
    } catch (error) {
        console.error('🔥 خطأ في الاتصال:', error);
    }
}

// استبدال الدوال الأصلية لإضافة debug
const originalOpenCustomerDetailsModal = window.openCustomerDetailsModal;
window.openCustomerDetailsModal = function(customerId) {
    console.log('👉 فتح تفاصيل العميل ID:', customerId);
    testApi(customerId);
    originalOpenCustomerDetailsModal(customerId);
};

const originalOpenPayDebtModal = window.openPayDebtModal;
window.openPayDebtModal = function(customerId) {
    console.log('💰 فتح سداد دين العميل ID:', customerId);
    testApi(customerId);
    originalOpenPayDebtModal(customerId);
};

// دالة debug مبسطة
function debugAPI(customerId) {
    console.log('🔄 جلب بيانات العميل ID:', customerId);
    
    fetch(`/customers/${customerId}`)
        .then(response => {
            console.log('📡 حالة الاستجابة:', response.status);
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            console.log('✅ بيانات الرد:', data);
            if (data.success) {
                console.log('👤 العميل:', data.data.customer);
                console.log('🧾 عدد الفواتير:', data.data.invoices?.length || 0);
                console.log('💰 عدد المدفوعات:', data.data.payments?.length || 0);
            } else {
                console.error('❌ خطأ:', data.message);
            }
        })
        .catch(error => {
            console.error('🔥 خطأ في الاتصال:', error);
            console.log('🔗 URL المحاولة:', `/customers/${customerId}`);
        });
}

// دالة استبدال للأزرار
function openCustomerDetailsModal(customerId) {
    debugAPI(customerId);
    
    const originalOpen = window._originalOpenCustomerDetailsModal || function(id) {
        console.log('فتح تفاصيل العميل ID:', id);
        // هنا الكود الأصلي
    };
    originalOpen(customerId);
}

function openPayDebtModal(customerId) {
    debugAPI(customerId);
    
    const originalOpen = window._originalOpenPayDebtModal || function(id) {
        console.log('فتح سداد دين العميل ID:', id);
        // هنا الكود الأصلي
    };
    originalOpen(customerId);
}

// حفظ الدوال الأصلية
window._originalOpenCustomerDetailsModal = openCustomerDetailsModal;
window._originalOpenPayDebtModal = openPayDebtModal;
    </script>
</body>
</html>