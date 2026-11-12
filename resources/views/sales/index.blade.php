<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>نقطة البيع المتقدمة | نظام إدارة البقالة</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
    gap: 20px;
}


        /* شريط العنوان العلوي */
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

        .sale-info {
            display: flex;
            gap: 20px;
            align-items: center;
        }

        .sale-number {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 10px 20px;
            border-radius: 12px;
            font-weight: 600;
        }

        .current-date {
            color: #8e8e93;
            font-weight: 500;
        }

        /* واجهة البيع الرئيسية */
        .sales-container {
            display: grid;
            grid-template-columns: 1.5fr 1fr;
            gap: 20px;
            flex: 1;
            height: calc(100vh - 180px);
        }

        @media (max-width: 1200px) {
            .sales-container {
                grid-template-columns: 1fr;
                height: auto;
            }
        }

        /* الجزء الأيسر: المنتجات والبحث */
        .products-section {
            background: white;
            border-radius: var(--border-radius);
            padding: 25px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        /* البحث المتقدم */
        .advanced-search {
            margin-bottom: 25px;
        }

        .search-header {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 15px;
        }

        .search-header h3 {
            font-size: 18px;
            color: var(--dark-color);
        }

        .search-tag {
            background: rgba(0, 102, 255, 0.1);
            color: var(--primary-color);
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
        }

        .search-container {
            position: relative;
        }

        .search-input {
            width: 100%;
            padding: 16px 20px 16px 50px;
            border: 2px solid #e5e5ea;
            border-radius: 12px;
            font-size: 16px;
            transition: all var(--transition-speed) ease;
            background: white;
        }

        .search-input:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(0, 102, 255, 0.1);
        }

        .search-input::placeholder {
            color: #8e8e93;
        }

        .search-icon {
            position: absolute;
            right: 20px;
            top: 50%;
            transform: translateY(-50%);
            color: #8e8e93;
            font-size: 18px;
        }

        .search-info {
            font-size: 12px;
            color: #8e8e93;
            margin-top: 8px;
            text-align: center;
        }

        /* نتائج البحث */
        .search-results {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: white;
            border-radius: 12px;
            border: 1px solid #e5e5ea;
            box-shadow: 0 8px 24px rgba(0,0,0,0.15);
            max-height: 300px;
            overflow-y: auto;
            z-index: 100;
            display: none;
        }

        .search-results.active {
            display: block;
        }

        .result-item {
            padding: 15px;
            border-bottom: 1px solid #f2f2f7;
            cursor: pointer;
            transition: background var(--transition-speed) ease;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .result-item:hover {
            background: #fafafa;
        }

        .result-item:last-child {
            border-bottom: none;
        }

        .result-icon {
            width: 36px;
            height: 36px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            color: white;
            flex-shrink: 0;
        }

        .result-icon.product {
            background: linear-gradient(135deg, var(--warning-color), #ffcc00);
        }

        .result-icon.barcode {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        }

        .result-icon.quick-add {
            background: linear-gradient(135deg, var(--success-color), #4cd964);
        }

        .result-details {
            flex: 1;
        }

        .result-details h4 {
            font-weight: 500;
            margin-bottom: 4px;
        }

        .result-details p {
            font-size: 13px;
            color: #8e8e93;
        }

        .result-price {
            font-weight: 600;
            color: var(--dark-color);
            margin-left: 10px;
        }

        /* المنتجات السريعة */
        .quick-products {
            flex: 1;
            display: flex;
            flex-direction: column;
            overflow: hidden;
            margin-top: 20px;
        }

        .quick-header {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 2px solid #f2f2f7;
        }

        .quick-header h3 {
            font-size: 18px;
            color: var(--dark-color);
        }

        .quick-tag {
            background: rgba(255, 149, 0, 0.1);
            color: var(--warning-color);
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
        }

        .categories-tabs {
            display: flex;
            gap: 10px;
            margin-bottom: 15px;
            overflow-x: auto;
            padding-bottom: 5px;
        }

        .category-tab {
            padding: 8px 16px;
            border: 1px solid #e5e5ea;
            background: white;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 500;
            color: #8e8e93;
            cursor: pointer;
            white-space: nowrap;
            transition: all var(--transition-speed) ease;
        }

        .category-tab:hover {
            border-color: var(--primary-color);
            color: var(--primary-color);
        }

        .category-tab.active {
            background: var(--primary-color);
            color: white;
            border-color: var(--primary-color);
        }

        .products-grid {
            flex: 1;
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            gap: 12px;
            overflow-y: auto;
            padding-right: 5px;
        }

        .product-card {
            background: #fafafa;
            border-radius: 12px;
            padding: 15px;
            border: 2px solid transparent;
            transition: all var(--transition-speed) ease;
            cursor: pointer;
            position: relative;
        }

        .product-card:hover {
            border-color: var(--primary-color);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

        .product-card.out-of-stock {
            opacity: 0.6;
            cursor: not-allowed;
        }

        .product-card.out-of-stock:hover {
            border-color: transparent;
            transform: none;
            box-shadow: none;
        }

        .product-name {
            font-weight: 500;
            margin-bottom: 8px;
            text-align: center;
        }

        .product-price {
            font-weight: 600;
            color: var(--primary-color);
            text-align: center;
            margin-bottom: 10px;
        }

        .add-btn {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: var(--success-color);
            color: white;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            position: absolute;
            bottom: -8px;
            left: 50%;
            transform: translateX(-50%);
            transition: all var(--transition-speed) ease;
        }

        .add-btn:hover {
            transform: translateX(-50%) scale(1.1);
            box-shadow: 0 4px 8px rgba(52, 199, 89, 0.3);
        }

        .product-card.out-of-stock .add-btn {
            background: #8e8e93;
            cursor: not-allowed;
        }

        /* الجزء الأيمن: الفاتورة */
        .invoice-section {
            background: white;
            border-radius: var(--border-radius);
            padding: 25px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            display: flex;
            flex-direction: column;
        }

        .invoice-header {
            margin-bottom: 25px;
        }

        .invoice-header h3 {
            font-size: 20px;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .invoice-header p {
            color: #8e8e93;
            font-size: 14px;
        }

        /* جدول الفاتورة */
        .invoice-table-container {
            flex: 1;
            overflow-y: auto;
            margin-bottom: 20px;
            border-radius: 12px;
            border: 1px solid #e5e5ea;
        }

        .invoice-table {
            width: 100%;
            border-collapse: collapse;
        }

        .invoice-table th {
            text-align: right;
            padding: 15px;
            color: #8e8e93;
            font-weight: 500;
            border-bottom: 1px solid #e5e5ea;
            background: #fafafa;
            position: sticky;
            top: 0;
        }

        .invoice-table td {
            padding: 15px;
            border-bottom: 1px solid #f2f2f7;
        }

        .invoice-table tbody tr {
            transition: background var(--transition-speed) ease;
        }

        .invoice-table tbody tr:hover {
            background: #fafafa;
        }

        .item-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .item-icon {
            width: 36px;
            height: 36px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            color: white;
            flex-shrink: 0;
        }

        .item-icon.regular {
            background: linear-gradient(135deg, var(--warning-color), #ffcc00);
        }

        .item-icon.quick {
            background: linear-gradient(135deg, var(--success-color), #4cd964);
        }

        .item-details h4 {
            font-weight: 500;
            margin-bottom: 4px;
        }

        .item-details p {
            font-size: 12px;
            color: #8e8e93;
        }

        .quantity-controls {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .btn-quantity {
            width: 28px;
            height: 28px;
            border-radius: 6px;
            border: 1px solid #e5e5ea;
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all var(--transition-speed) ease;
        }

        .btn-quantity:hover {
            border-color: var(--primary-color);
            color: var(--primary-color);
        }

        .quantity-input {
            width: 40px;
            padding: 5px;
            text-align: center;
            border: 1px solid #e5e5ea;
            border-radius: 6px;
            font-size: 14px;
        }

        .quantity-input:focus {
            outline: none;
            border-color: var(--primary-color);
        }

        .price-cell {
            font-weight: 600;
            color: var(--dark-color);
        }

        .total-cell {
            font-weight: 700;
            color: var(--primary-color);
        }

        .btn-remove {
            background: none;
            border: none;
            color: var(--danger-color);
            cursor: pointer;
            padding: 6px;
            border-radius: 6px;
            transition: background var(--transition-speed) ease;
        }

        .btn-remove:hover {
            background: rgba(255, 59, 48, 0.1);
        }

        /* ملخص الفاتورة */
        .invoice-summary {
            background: #fafafa;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 25px;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #e5e5ea;
        }

        .summary-row:last-child {
            border-bottom: none;
            font-weight: 700;
            color: var(--primary-color);
            font-size: 18px;
            padding-top: 15px;
        }

        .summary-label {
            color: #8e8e93;
        }

        .summary-value {
            font-weight: 500;
        }

        /* نوع الدفع */
        .payment-type {
            margin-bottom: 25px;
        }

        .payment-type h4 {
            font-size: 16px;
            margin-bottom: 15px;
            color: var(--dark-color);
        }

        .payment-options {
            display: flex;
            gap: 10px;
            margin-bottom: 15px;
        }

        .payment-btn {
            flex: 1;
            padding: 12px;
            border: 2px solid #e5e5ea;
            border-radius: 10px;
            background: white;
            color: #1c1c1e;
            font-weight: 500;
            cursor: pointer;
            transition: all var(--transition-speed) ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .payment-btn.active {
            border-color: var(--primary-color);
            background: rgba(0, 102, 255, 0.1);
            color: var(--primary-color);
        }

        .customer-selection {
            margin-top: 15px;
            display: none;
        }

        .customer-selection.active {
            display: block;
        }

        .customer-select {
            width: 100%;
            padding: 12px 16px;
            border: 1px solid #e5e5ea;
            border-radius: 10px;
            font-size: 14px;
            color: #1c1c1e;
            background: white;
        }

        .customer-select:focus {
            outline: none;
            border-color: var(--primary-color);
        }

        /* المبلغ المدفوع */
        .paid-amount {
            margin-bottom: 25px;
        }

        .paid-amount h4 {
            font-size: 16px;
            margin-bottom: 10px;
            color: var(--dark-color);
        }

        .amount-input {
            width: 100%;
            padding: 15px;
            border: 2px solid #e5e5ea;
            border-radius: 12px;
            font-size: 16px;
            text-align: center;
            font-weight: 600;
            transition: all var(--transition-speed) ease;
        }

        .amount-input:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(0, 102, 255, 0.1);
        }

        .amount-info {
            display: flex;
            justify-content: space-between;
            margin-top: 10px;
            font-size: 14px;
        }

        .amount-info .remaining {
            color: var(--danger-color);
            font-weight: 500;
        }

        .amount-info .change {
            color: var(--success-color);
            font-weight: 500;
        }

        /* أزرار التحكم */
        .invoice-actions {
            display: flex;
            gap: 15px;
            margin-top: auto;
        }

        .btn-cancel {
            flex: 1;
            padding: 16px;
            border: 2px solid #e5e5ea;
            border-radius: 12px;
            background: white;
            color: #1c1c1e;
            font-weight: 600;
            cursor: pointer;
            transition: all var(--transition-speed) ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-cancel:hover {
            background: #f2f2f7;
        }

        .btn-save {
            flex: 2;
            padding: 16px;
            border: none;
            border-radius: 12px;
            background: linear-gradient(135deg, var(--success-color), #4cd964);
            color: white;
            font-weight: 600;
            cursor: pointer;
            transition: all var(--transition-speed) ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-save:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(52, 199, 89, 0.3);
        }

        /* نافذة المنتج السريع */
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
            max-width: 400px;
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
        }

        /* تصميم للجوّال */
        @media (max-width: 768px) {
           .main-content {
        margin-left: 0;
    }
            
            .mobile-menu-btn {
                display: block;
            }
            
            .top-bar {
                flex-direction: column;
                gap: 15px;
                align-items: flex-start;
            }
            
            .sales-container {
                grid-template-columns: 1fr;
                height: auto;
            }
            
            .products-grid {
                grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
            }
            
            .categories-tabs {
                flex-wrap: nowrap;
                overflow-x: auto;
            }
            
            .invoice-actions {
                flex-direction: column;
            }
        }

        /* تخصيص شريط التمرير */
        .invoice-table-container::-webkit-scrollbar,
        .search-results::-webkit-scrollbar,
        .products-grid::-webkit-scrollbar {
            width: 6px;
        }

        .invoice-table-container::-webkit-scrollbar-track,
        .search-results::-webkit-scrollbar-track,
        .products-grid::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        .invoice-table-container::-webkit-scrollbar-thumb,
        .search-results::-webkit-scrollbar-thumb,
        .products-grid::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 10px;
        }

        .invoice-table-container::-webkit-scrollbar-thumb:hover,
        .search-results::-webkit-scrollbar-thumb:hover,
        .products-grid::-webkit-scrollbar-thumb:hover {
            background: #a1a1a1;
        }

        /* تنبيهات المخزون */
        .stock-badge {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 4px;
            font-size: 11px;
            margin-right: 5px;
        }

        .stock-low {
            background: rgba(255, 149, 0, 0.1);
            color: var(--warning-color);
        }

        .stock-out {
            background: rgba(255, 59, 48, 0.1);
            color: var(--danger-color);
        }

        .expiry-near {
            background: rgba(255, 59, 48, 0.1);
            color: var(--danger-color);
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
                    <h1>نقطة البيع المتقدمة</h1>
                    <p>البيع السريع - البحث المتقدم - المنتجات السريعة</p>
                </div>
                
                <div class="sale-info">
                    <div class="sale-number">فاتورة #<span id="saleNumber">{{ $nextSaleNumber }}</span></div>
                    <div class="current-date" id="currentDate"></div>
                </div>
            </div>
            
            <!-- واجهة البيع الرئيسية -->
            <div class="sales-container">
                <!-- الجزء الأيسر: المنتجات والبحث -->
                <div class="products-section">
                    <!-- البحث المتقدم -->
                    <div class="advanced-search">
                        <div class="search-header">
                            <h3>البحث المتقدم</h3>
                            <span class="search-tag">الاسم أو الباركود</span>
                        </div>
                        
                        <div class="search-container">
                            <i class="fas fa-search search-icon"></i>
                            <input type="text" 
                                   class="search-input" 
                                   id="searchInput" 
                                   placeholder="ابحث بالاسم أو امسح الباركود هنا..."
                                   autofocus>
                            
                            <!-- نتائج البحث -->
                            <div class="search-results" id="searchResults">
                                <!-- سيتم تعبئة النتائج عن طريق JavaScript -->
                            </div>
                        </div>
                        
                        <div class="search-info">
                            أدخل نصًا للبحث بالاسم | أدخل أرقامًا للبحث بالباركود
                        </div>
                    </div>
                    
                    <!-- المنتجات السريعة -->
                    <div class="quick-products">
                        <div class="quick-header">
                            <h3>المنتجات السريعة</h3>
                            <span class="quick-tag">سرعة في البيع</span>
                        </div>
                        
                        <!-- تصنيفات المنتجات -->
                        <div class="categories-tabs" id="categoriesTabs">
                            <!-- سيتم تعبئة التصنيفات عن طريق JavaScript -->
                        </div>
                        
                        <!-- شبكة المنتجات -->
                        <div class="products-grid" id="productsGrid">
                            <!-- سيتم تعبئة المنتجات عن طريق JavaScript -->
                        </div>
                    </div>
                </div>
                
                <!-- الجزء الأيمن: الفاتورة -->
                <div class="invoice-section">
                    <div class="invoice-header">
                        <h3>فاتورة البيع</h3>
                        <p>المنتجات المضافة والإجمالي</p>
                    </div>
                    
                    <!-- جدول الفاتورة -->
                    <div class="invoice-table-container">
                        <table class="invoice-table">
                            <thead>
                                <tr>
                                    <th style="width: 35%;">المنتج</th>
                                    <th>الكمية</th>
                                    <th>السعر</th>
                                    <th>الإجمالي</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody id="invoiceItems">
                                <!-- سيتم تعبئة البيانات عن طريق JavaScript -->
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- ملخص الفاتورة -->
                    <div class="invoice-summary">
                        <div class="summary-row">
                            <span class="summary-label">المجموع الفرعي</span>
                            <span class="summary-value" id="subtotal">0.00 ر.س</span>
                        </div>
                        <div class="summary-row">
                            <span class="summary-label">الضريبة ({{ $taxRate * 100 }}%)</span>
                            <span class="summary-value" id="tax">0.00 ر.س</span>
                        </div>
                        <div class="summary-row">
                            <span class="summary-label">الإجمالي</span>
                            <span class="summary-value" id="total">0.00 ر.س</span>
                        </div>
                    </div>
                    
                    <!-- نوع الدفع -->
                    <div class="payment-type">
                        <h4>نوع الدفع</h4>
                        <div class="payment-options">
                            <button class="payment-btn active" data-type="cash">
                                <i class="fas fa-money-bill-wave"></i>
                                نقدي
                            </button>
                            <button class="payment-btn" data-type="credit">
                                <i class="fas fa-credit-card"></i>
                                دين
                            </button>
                        </div>
                        
                        <!-- اختيار العميل (في حالة البيع بالدين) -->
                        <div class="customer-selection" id="customerSelection">
                            <select class="customer-select" id="customerSelect">
                                <option value="">اختر العميل</option>
                                @foreach($customers as $customer)
                                    <option value="{{ $customer->id }}">{{ $customer->name }} (رصيد: {{ $customer->balance }} ر.س)</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    
                    <!-- المبلغ المدفوع -->
                    <div class="paid-amount">
                        <h4>المبلغ المدفوع</h4>
                        <input type="number" 
                               class="amount-input" 
                               id="paidAmount" 
                               placeholder="0.00"
                               value="0"
                               min="0"
                               step="0.01">
                        <div class="amount-info">
                            <span class="remaining" id="remainingAmount">المتبقي: 0.00 ر.س</span>
                            <span class="change" id="changeAmount">الباقي: 0.00 ر.س</span>
                        </div>
                    </div>
                    
                    <!-- أزرار التحكم -->
                    <div class="invoice-actions">
                        <button class="btn-cancel" id="btnCancel">
                            <i class="fas fa-times"></i>
                            إلغاء
                        </button>
                        <button class="btn-save" id="btnSave">
                            <i class="fas fa-check"></i>
                            حفظ وإصدار الفاتورة
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- نافذة المنتج السريع -->
    <div class="modal" id="quickProductModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>إضافة منتج سريع</h3>
                <button class="btn-close" id="btnCloseModal">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <div class="modal-body">
                <form id="quickProductForm">
                    <div class="form-group">
                        <label for="quickProductName">
                            <i class="fas fa-box"></i> اسم المنتج
                        </label>
                        <input type="text" 
                               id="quickProductName" 
                               class="form-control" 
                               placeholder="أدخل اسم المنتج (مؤقت)"
                               required>
                    </div>
                    
                    <div class="form-group">
                        <label for="quickProductCategory">
                            <i class="fas fa-tag"></i> التصنيف (اختياري)
                        </label>
                        <select id="quickProductCategory" class="form-control">
                            <option value="">بدون تصنيف</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="quickProductPrice">
                                <i class="fas fa-money-bill-wave"></i> سعر البيع (ر.س)
                            </label>
                            <input type="number" 
                                   id="quickProductPrice" 
                                   class="form-control" 
                                   placeholder="0.00"
                                   step="0.01"
                                   min="0"
                                   required>
                        </div>
                        
                        <div class="form-group">
                            <label for="quickProductQuantity">
                                <i class="fas fa-cubes"></i> الكمية
                            </label>
                            <input type="number" 
                                   id="quickProductQuantity" 
                                   class="form-control" 
                                   placeholder="1"
                                   min="1"
                                   value="1"
                                   required>
                        </div>
                    </div>
                </form>
            </div>
            
            <div class="modal-footer">
                <button type="button" class="btn-secondary" id="btnCancelModal">
                    إلغاء
                </button>
                <button type="button" class="btn-primary" id="btnAddQuickProduct">
                    <i class="fas fa-plus"></i> إضافة للفاتورة
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
        (function () {
            'use strict';
            
            // بيانات المنتجات من قاعدة البيانات
            const products = @json($products);
            
            // بيانات العملاء من قاعدة البيانات
            const customers = @json($customers);
            
            // بيانات الفاتورة الحالية
            let invoiceItems = [];
            let currentPaymentType = 'cash';
            let currentCustomerId = null;
            let saleNumber = {{ $nextSaleNumber }};
            const taxRate = {{ $taxRate }};
            const today = new Date();
            let currentCategory = 'all';

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

            // تحديث التاريخ الحالي
            function updateCurrentDate() {
                const options = { 
                    weekday: 'long', 
                    year: 'numeric', 
                    month: 'long', 
                    day: 'numeric',
                    hour: '2-digit',
                    minute: '2-digit'
                };
                const dateString = today.toLocaleDateString('ar-SA', options);
                document.getElementById('currentDate').textContent = dateString;
            }

            // البحث المتقدم
            function performSearch(query) {
                const resultsDiv = document.getElementById('searchResults');
                resultsDiv.innerHTML = '';
                
                if (!query.trim()) {
                    resultsDiv.classList.remove('active');
                    return;
                }
                
                const isBarcode = /^\d+$/.test(query);
                let results = [];
                
                if (isBarcode) {
                    // البحث بالباركود
                    results = products.filter(product => 
                        product.barcode.includes(query)
                    );
                    
                    if (results.length > 0) {
                        results.forEach(product => {
                            addSearchResult(product, 'barcode');
                        });
                    } else {
                        // عرض خيار إضافة منتج سريع
                        addQuickAddOption(query);
                    }
                } else {
                    // البحث بالاسم
                    results = products.filter(product => 
                        product.name.includes(query) || 
                        (product.category && product.category.name.includes(query))
                    );
                    
                    if (results.length > 0) {
                        results.forEach(product => {
                            addSearchResult(product, 'product');
                        });
                    }
                }
                
                // إضافة خيار "إضافة منتج سريع" في جميع الحالات
                if (results.length === 0 || !isBarcode) {
                    addQuickAddOption(query);
                }
                
                resultsDiv.classList.add('active');
            }

            // إضافة نتيجة بحث
            function addSearchResult(product, type) {
                const resultsDiv = document.getElementById('searchResults');
                
                const item = document.createElement('div');
                item.className = 'result-item';
                item.dataset.id = product.id;
                
                // التحقق من حالة المخزون والصلاحية
                const stockWarning = getStockWarning(product);
                const expiryWarning = getExpiryWarning(product);
                
                item.innerHTML = `
                    <div class="result-icon ${type}">
                        <i class="fas fa-${type === 'barcode' ? 'barcode' : 'box'}"></i>
                    </div>
                    <div class="result-details">
                        <h4>${product.name}</h4>
                        <p>
                            ${product.category ? product.category.name : 'بدون تصنيف'}
                            ${stockWarning ? `<span class="stock-badge ${stockWarning.class}">${stockWarning.text}</span>` : ''}
                            ${expiryWarning ? `<span class="stock-badge expiry-near">${expiryWarning}</span>` : ''}
                        </p>
                    </div>
                    <div class="result-price">${Number(product.sale_price).toFixed(2)} ر.س</div>
                `;
                
                resultsDiv.appendChild(item);
            }

            // إضافة خيار المنتج السريع
            function addQuickAddOption(query = '') {
                const resultsDiv = document.getElementById('searchResults');
                
                const item = document.createElement('div');
                item.className = 'result-item';
                item.dataset.quick = 'true';
                
                item.innerHTML = `
                    <div class="result-icon quick-add">
                        <i class="fas fa-plus"></i>
                    </div>
                    <div class="result-details">
                        <h4>إضافة منتج سريع</h4>
                        <p>المنتج غير مسجل - أضفه للفاتورة مباشرة</p>
                    </div>
                `;
                
                resultsDiv.appendChild(item);
            }

            // التحقق من المخزون
            function getStockWarning(product) {
                if (product.quantity <= 0) {
                    return { class: 'stock-out', text: 'نفذ' };
                } else if (product.quantity <= product.minimum_quantity) {
                    return { class: 'stock-low', text: 'منخفض' };
                }
                return null;
            }

            // التحقق من الصلاحية
            function getExpiryWarning(product) {
                if (!product.expiry_date) return null;
                
                const expiry = new Date(product.expiry_date);
                const diffTime = expiry - today;
                const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
                
                if (diffDays < 0) {
                    return 'منتهي';
                } else if (diffDays <= 7) {
                    return `${diffDays} يوم`;
                }
                return null;
            }

            // فتح نافذة المنتج السريع
            function openQuickProductModal(productName = '') {
                document.getElementById('quickProductName').value = productName;
                document.getElementById('quickProductPrice').value = '';
                document.getElementById('quickProductQuantity').value = '1';
                document.getElementById('quickProductModal').classList.add('active');
            }

            // إغلاق نافذة المنتج السريع
            function closeQuickProductModal() {
                document.getElementById('quickProductModal').classList.remove('active');
                document.getElementById('quickProductForm').reset();
            }

            // إضافة منتج سريع للفاتورة
            function addQuickProduct() {
                const name = document.getElementById('quickProductName').value.trim();
                const price = parseFloat(document.getElementById('quickProductPrice').value);
                const quantity = parseInt(document.getElementById('quickProductQuantity').value);
                const categoryId = document.getElementById('quickProductCategory').value;
                
                if (!name || !price || !quantity) {
                    showAlert('الرجاء ملء جميع الحقول المطلوبة', 'error');
                    return;
                }
                
                if (price <= 0) {
                    showAlert('السعر يجب أن يكون أكبر من صفر', 'error');
                    return;
                }
                
                if (quantity <= 0) {
                    showAlert('الكمية يجب أن تكون أكبر من صفر', 'error');
                    return;
                }
                
                // إنشاء منتج سريع
                const quickProductId = 'quick_' + Date.now();
                invoiceItems.push({
                    id: quickProductId,
                    name: name,
                    category: 'سريع',
                    price: price,
                    quantity: quantity,
                    total: price * quantity,
                    isQuickProduct: true,
                    availableQuantity: 999
                });
                
                closeQuickProductModal();
                updateInvoiceDisplay();
                showAlert('تم إضافة المنتج السريع للفاتورة', 'success');
            }

            // إعداد التصنيفات للمنتجات السريعة
            function setupCategories() {
                const categoriesDiv = document.getElementById('categoriesTabs');
                categoriesDiv.innerHTML = '';
                
                // استخراج جميع التصنيفات الفريدة
                const allCategories = [...new Set(products.map(p => p.category ? p.category.name : null).filter(c => c))];
                
                // إضافة زر "الكل"
                const allTab = document.createElement('button');
                allTab.className = 'category-tab active';
                allTab.textContent = 'الكل';
                allTab.dataset.category = 'all';
                categoriesDiv.appendChild(allTab);
                
                // إضافة التصنيفات
                allCategories.forEach(category => {
                    const tab = document.createElement('button');
                    tab.className = 'category-tab';
                    tab.textContent = category;
                    tab.dataset.category = category;
                    categoriesDiv.appendChild(tab);
                });
                
                // عرض المنتجات حسب التصنيف المحدد
                displayProductsByCategory('all');
            }

            // اختيار تصنيف
            function selectCategory(category) {
                currentCategory = category;
                
                // تحديث التبويبات النشطة
                document.querySelectorAll('.category-tab').forEach(tab => {
                    tab.classList.remove('active');
                });
                
                const activeTab = document.querySelector(`[data-category="${category}"]`);
                if (activeTab) {
                    activeTab.classList.add('active');
                }
                
                // عرض المنتجات
                displayProductsByCategory(category);
            }

            // عرض المنتجات حسب التصنيف
            function displayProductsByCategory(category) {
                const productsGrid = document.getElementById('productsGrid');
                productsGrid.innerHTML = '';
                
                let filteredProducts = products;
                if (category !== 'all') {
                    filteredProducts = products.filter(p => p.category && p.category.name === category);
                }
                
                // ترتيب المنتجات حسب الكمية (الأكثر أولاً)
                filteredProducts.sort((a, b) => b.quantity - a.quantity);
                
                filteredProducts.forEach(product => {
                    const card = document.createElement('div');
                    const isOutOfStock = product.quantity <= 0;
                    const stockWarning = getStockWarning(product);
                    const expiryWarning = getExpiryWarning(product);
                    
                    card.className = `product-card ${isOutOfStock ? 'out-of-stock' : ''}`;
                    card.dataset.id = product.id;
                    
                    card.innerHTML = `
                        <div class="product-name">${product.name}</div>
                        <div class="product-price">${Number(product.sale_price).toFixed(2)} ر.س</div>
                        ${stockWarning ? `<span class="stock-badge ${stockWarning.class}">${stockWarning.text}</span>` : ''}
                        ${expiryWarning ? `<span class="stock-badge expiry-near">${expiryWarning}</span>` : ''}
                        <button class="add-btn" ${isOutOfStock ? 'disabled' : ''}>
                            <i class="fas fa-plus"></i>
                        </button>
                    `;
                    
                    productsGrid.appendChild(card);
                });
            }

            // إضافة منتج للفاتورة
            function addProductToInvoice(productId) {
                let product;
                let isQuick = false;
                
                if (typeof productId === 'number') {
                    product = products.find(p => p.id === productId);
                    if (!product) return;
                    
                    // التحقق من المخزون
                    if (product.quantity <= 0) {
                        showAlert(`المنتج ${product.name} غير متوفر في المخزون`, 'error');
                        return;
                    }
                } else if (typeof productId === 'string' && productId.startsWith('quick_')) {
                    // منتج سريع
                    const quickItem = invoiceItems.find(item => item.id === productId);
                    if (quickItem) {
                        updateProductQuantity(quickItem.id, quickItem.quantity + 1);
                        return;
                    }
                    return;
                }
                
                if (!product) return;
                
                // التحقق من وجود المنتج بالفعل في الفاتورة
                const existingItem = invoiceItems.find(item => 
                    !item.isQuickProduct && item.id === product.id
                );
                
                if (existingItem) {
                    // زيادة كمية المنتج الموجود
                    updateProductQuantity(product.id, existingItem.quantity + 1);
                } else {
                    // إضافة منتج جديد
                    const stockWarning = getStockWarning(product);
                    const expiryWarning = getExpiryWarning(product);
                    
                    const price = parseFloat(product.sale_price);
                    
                    invoiceItems.push({
                        id: product.id,
                        name: product.name,
                        category: product.category ? product.category.name : 'بدون تصنيف',
                        price: price,
                        quantity: 1,
                        total: price,
                        availableQuantity: product.quantity,
                        isQuickProduct: false,
                        warning: stockWarning || expiryWarning ? {
                            stock: stockWarning,
                            expiry: expiryWarning
                        } : null
                    });
                    
                    updateInvoiceDisplay();
                    showAlert(`تم إضافة ${product.name} للفاتورة`, 'success');
                }
                
                // إخفاء نتائج البحث
                document.getElementById('searchResults').classList.remove('active');
                document.getElementById('searchInput').value = '';
                document.getElementById('searchInput').focus();
            }

            // تحديث كمية منتج في الفاتورة
            function updateProductQuantity(itemId, newQuantity) {
                const itemIndex = invoiceItems.findIndex(item => item.id === itemId);
                if (itemIndex === -1) return;
                
                const item = invoiceItems[itemIndex];
                
                // التحقق من الكمية للمنتجات العادية
                if (!item.isQuickProduct) {
                    const product = products.find(p => p.id === itemId);
                    if (product && newQuantity > product.quantity) {
                        showAlert(`لا يمكن بيع أكثر من ${product.quantity} وحدة من ${item.name}`, 'error');
                        newQuantity = product.quantity;
                    }
                }
                
                if (newQuantity < 1) {
                    removeProductFromInvoice(itemId);
                    return;
                }
                
                item.quantity = newQuantity;
                item.total = newQuantity * item.price;
                updateInvoiceDisplay();
            }

            // إزالة منتج من الفاتورة
            function removeProductFromInvoice(itemId) {
                invoiceItems = invoiceItems.filter(item => item.id !== itemId);
                updateInvoiceDisplay();
                showAlert('تم إزالة المنتج من الفاتورة', 'success');
            }

            // تحديث عرض الفاتورة
            function updateInvoiceDisplay() {
                const tbody = document.getElementById('invoiceItems');
                tbody.innerHTML = '';
                
                if (invoiceItems.length === 0) {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td colspan="5" style="text-align: center; padding: 40px; color: #8e8e93;">
                            <i class="fas fa-shopping-cart" style="font-size: 48px; margin-bottom: 15px; opacity: 0.3;"></i>
                            <p>لا توجد منتجات في الفاتورة</p>
                            <small>ابدأ بالبحث أو اختر من المنتجات السريعة</small>
                        </td>
                    `;
                    tbody.appendChild(row);
                } else {
                    invoiceItems.forEach(item => {
                        const row = document.createElement('tr');
                        
                        row.innerHTML = `
                            <td>
                                <div class="item-info">
                                    <div class="item-icon ${item.isQuickProduct ? 'quick' : 'regular'}">
                                        <i class="fas fa-${item.isQuickProduct ? 'bolt' : 'box'}"></i>
                                    </div>
                                    <div class="item-details">
                                        <h4>${item.name}</h4>
                                        <p>
                                            ${item.category}
                                            ${item.warning ? `
                                                ${item.warning.stock ? `<span class="stock-badge ${item.warning.stock.class}">${item.warning.stock.text}</span>` : ''}
                                                ${item.warning.expiry ? `<span class="stock-badge expiry-near">${item.warning.expiry}</span>` : ''}
                                            ` : ''}
                                            ${item.isQuickProduct ? '<span class="stock-badge" style="background: rgba(52, 199, 89, 0.1); color: var(--success-color);">سريع</span>' : ''}
                                        </p>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="quantity-controls">
                                    <button class="btn-quantity btn-minus" data-id="${item.id}">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <input type="number" 
                                           class="quantity-input" 
                                           data-id="${item.id}"
                                           value="${item.quantity}"
                                           min="1" 
                                           max="${item.availableQuantity}">
                                    <button class="btn-quantity btn-plus" data-id="${item.id}">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                            </td>
                            <td class="price-cell">${item.price.toFixed(2)} ر.س</td>
                            <td class="total-cell">${item.total.toFixed(2)} ر.س</td>
                            <td>
                                <button class="btn-remove" data-id="${item.id}">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        `;
                        
                        tbody.appendChild(row);
                    });
                }
                
                // تحديث الإحصائيات
                updateInvoiceStats();
            }

            // تحديث إحصائيات الفاتورة
            function updateInvoiceStats() {
                // حساب المجموع الفرعي
                const subtotal = invoiceItems.reduce((sum, item) => sum + item.total, 0);
                
                // حساب الضريبة
                const tax = subtotal * taxRate;
                
                // حساب الإجمالي
                const total = subtotal + tax;
                
                // تحديث القيم
                document.getElementById('subtotal').textContent = subtotal.toFixed(2) + ' ر.س';
                document.getElementById('tax').textContent = tax.toFixed(2) + ' ر.س';
                document.getElementById('total').textContent = total.toFixed(2) + ' ر.س';
                
                // تحديث المبلغ المدفوع والباقي
                updatePaymentAmounts();
            }

            // تحديث مبالغ الدفع
            function updatePaymentAmounts() {
                const paidAmount = parseFloat(document.getElementById('paidAmount').value) || 0;
                const total = parseFloat(document.getElementById('total').textContent.replace(/[^\d.]/g, '')) || 0;
                
                let remaining = 0;
                let change = 0;
                
                if (paidAmount >= total) {
                    change = paidAmount - total;
                    document.getElementById('changeAmount').textContent = `الباقي: ${change.toFixed(2)} ر.س`;
                    document.getElementById('remainingAmount').textContent = '';
                } else {
                    remaining = total - paidAmount;
                    document.getElementById('remainingAmount').textContent = `المتبقي: ${remaining.toFixed(2)} ر.س`;
                    document.getElementById('changeAmount').textContent = '';
                }
            }

            // اختيار نوع الدفع
            function selectPaymentType(type) {
                currentPaymentType = type;
                
                document.querySelectorAll('.payment-btn').forEach(btn => {
                    btn.classList.remove('active');
                });
                
                const activeBtn = document.querySelector(`[data-type="${type}"]`);
                if (activeBtn) {
                    activeBtn.classList.add('active');
                }
                
                const customerSelection = document.getElementById('customerSelection');
                if (type === 'credit') {
                    customerSelection.classList.add('active');
                } else {
                    customerSelection.classList.remove('active');
                    currentCustomerId = null;
                    document.getElementById('customerSelect').value = '';
                }
                
                updatePaymentAmounts();
            }
            
            // إلغاء الفاتورة
            function clearInvoice() {
                if (invoiceItems.length > 0) {
                    if (confirm('هل تريد إلغاء الفاتورة الحالية؟ سيتم فقدان جميع المنتجات المضافة.')) {
                        invoiceItems = [];
                        updateInvoiceDisplay();
                        document.getElementById('paidAmount').value = '0';
                        updatePaymentAmounts();
                        showAlert('تم إلغاء الفاتورة', 'success');
                    }
                } else {
                    showAlert('الفاتورة فارغة بالفعل', 'warning');
                }
            }
            
            // حفظ الفاتورة
           function saveInvoice() {
    if (invoiceItems.length === 0) {
        showAlert('الفاتورة فارغة، أضف منتجات أولاً', 'error');
        return;
    }
    
    if (currentPaymentType === 'credit' && !currentCustomerId) {
        showAlert('الرجاء اختيار عميل للبيع بالدين', 'error');
        return;
    }
    
    const total = parseFloat(document.getElementById('total').textContent.replace(/[^\d.]/g, '')) || 0;
    const paidAmount = parseFloat(document.getElementById('paidAmount').value) || 0;
    
    // التحقق من الدفع النقدي
    if (currentPaymentType === 'cash' && paidAmount < total) {
        showAlert('المبلغ المدفوع أقل من إجمالي الفاتورة', 'error');
        return;
    }
    
    // إعداد بيانات الطلب - تأكد من أن البيانات مرسلة بشكل صحيح
   const requestData = {
    items: invoiceItems.map(item => ({
        id: item.isQuickProduct ? 'quick_' + Date.now() : item.id,
        name: item.name,
        quantity: item.quantity,
        price: item.price,
        total: item.total,
        isQuickProduct: item.isQuickProduct || false
    })),
    total: total,
    payment_type: currentPaymentType,
    customer_id: currentCustomerId,
    paid_amount: paidAmount
};
    
    console.log('بيانات الإرسال:', requestData); // للتصحيح
    
    // إرسال الطلب إلى السيرفر
    fetch("{{ route('sales.store') }}", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
            "Accept": "application/json"
        },
        body: JSON.stringify(requestData)
    })
    .then(response => {
        // التحقق من حالة الاستجابة
        if (!response.ok) {
            throw new Error('خطأ في استجابة السيرفر: ' + response.status);
        }
        return response.json();
    })
    .then(data => {
        console.log('استجابة السيرفر:', data); // للتصحيح
        
        if (data.success) {
            showAlert('تم حفظ الفاتورة بنجاح', 'success');
            
            // إعادة تعيين الفاتورة
            invoiceItems = [];
            
            // تحديث رقم الفاتورة التالي من الاستجابة
            if (data.sale_number) {
                saleNumber = data.sale_number;
                document.getElementById('saleNumber').textContent = saleNumber;
            }
            
            // إعادة تعيين الحقول
            document.getElementById('paidAmount').value = '0';
            if (document.getElementById('customerSelect')) {
                document.getElementById('customerSelect').value = '';
            }
            currentCustomerId = null;
            
            // إعادة تعيين نوع الدفع إلى نقدي
            selectPaymentType('cash');
            
            // تحديث العرض
            updateInvoiceDisplay();
            
            // إخفاء نتائج البحث إن وجدت
            document.getElementById('searchResults').classList.remove('active');
            document.getElementById('searchInput').value = '';
            document.getElementById('searchInput').focus();
            
            // طباعة الفاتورة إذا كان ذلك ممكناً
            if (data.print_url) {
                setTimeout(() => {
                    window.open(data.print_url, '_blank');
                }, 500);
            }
        } else {
            showAlert(data.message || 'حدث خطأ في الحفظ', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showAlert('فشل الاتصال بالسيرفر: ' + error.message, 'error');
    });
}

            // تفعيل/تعطيل الشريط الجانبي على الجوال
            function toggleSidebar() {
                const sidebar = document.getElementById('sidebar');
                sidebar.classList.toggle('active');
            }

            // إضافة Event Delegation للتعامل مع الأحداث
            document.addEventListener("click", function(e) {
                // زيادة الكمية (+)
                if (e.target.closest(".btn-plus")) {
                    const btn = e.target.closest(".btn-plus");
                    const id = btn.dataset.id;
                    
                    // تحويل ID إلى الرقم المناسب
                    let productId;
                    if (id.startsWith('quick_')) {
                        productId = id; // ID سريع (نصي)
                    } else {
                        productId = Number(id); // ID منتج عادي (رقمي)
                    }
                    
                    const item = invoiceItems.find(i => i.id === productId);
                    if (item) {
                        updateProductQuantity(productId, item.quantity + 1);
                    }
                }

                // تقليل الكمية (-)
                if (e.target.closest(".btn-minus")) {
                    const btn = e.target.closest(".btn-minus");
                    const id = btn.dataset.id;
                    
                    let productId;
                    if (id.startsWith('quick_')) {
                        productId = id;
                    } else {
                        productId = Number(id);
                    }
                    
                    const item = invoiceItems.find(i => i.id === productId);
                    if (item) {
                        updateProductQuantity(productId, item.quantity - 1);
                    }
                }

                // حذف المنتج
                if (e.target.closest(".btn-remove")) {
                    const btn = e.target.closest(".btn-remove");
                    const id = btn.dataset.id;
                    
                    let productId;
                    if (id.startsWith('quick_')) {
                        productId = id;
                    } else {
                        productId = Number(id);
                    }
                    
                    removeProductFromInvoice(productId);
                }

                // إضافة منتج من نتائج البحث
                if (e.target.closest(".result-item")) {
                    const resultItem = e.target.closest(".result-item");
                    const id = resultItem.dataset.id;
                    const isQuick = resultItem.dataset.quick === 'true';
                    
                    if (isQuick) {
                        const searchQuery = document.getElementById('searchInput').value;
                        openQuickProductModal(searchQuery);
                    } else if (id) {
                        addProductToInvoice(Number(id));
                    }
                }

                // إضافة منتج من المنتجات السريعة
                if (e.target.closest(".product-card")) {
                    const productCard = e.target.closest(".product-card");
                    const id = productCard.dataset.id;
                    if (id && !productCard.classList.contains('out-of-stock')) {
                        addProductToInvoice(Number(id));
                    }
                }

                // زر الإضافة على بطاقة المنتج
                if (e.target.closest(".add-btn")) {
                    const addBtn = e.target.closest(".add-btn");
                    if (!addBtn.disabled) {
                        const productCard = addBtn.closest(".product-card");
                        const id = productCard.dataset.id;
                        if (id) {
                            addProductToInvoice(Number(id));
                        }
                    }
                }

                // اختيار تصنيف
                if (e.target.closest(".category-tab")) {
                    const tab = e.target.closest(".category-tab");
                    const category = tab.dataset.category;
                    selectCategory(category);
                }

                // اختيار نوع الدفع
                if (e.target.closest(".payment-btn")) {
                    const btn = e.target.closest(".payment-btn");
                    const type = btn.dataset.type;
                    selectPaymentType(type);
                }

                // إغلاق نافذة المنتج السريع
                if (e.target.closest("#btnCloseModal") || e.target.closest("#btnCancelModal")) {
                    closeQuickProductModal();
                }

                // إضافة منتج سريع
                if (e.target.closest("#btnAddQuickProduct")) {
                    addQuickProduct();
                }

                // إلغاء الفاتورة
                if (e.target.closest("#btnCancel")) {
                    clearInvoice();
                }

                // حفظ الفاتورة
                if (e.target.closest("#btnSave")) {
                    saveInvoice();
                }
            });

            // تغيير الكمية يدوياً في حقل الإدخال
            document.addEventListener("input", function(e) {
                if (e.target.classList.contains("quantity-input")) {
                    const input = e.target;
                    const id = input.dataset.id;
                    const qty = parseInt(input.value) || 1;
                    
                    let productId;
                    if (id.startsWith('quick_')) {
                        productId = id;
                    } else {
                        productId = Number(id);
                    }
                    
                    updateProductQuantity(productId, qty);
                }
                
                // البحث الفوري
                if (e.target.id === "searchInput") {
                    performSearch(e.target.value);
                }
            });

            // تغيير العميل المختار
            document.getElementById('customerSelect').addEventListener('change', function() {
                currentCustomerId = this.value ? Number(this.value) : null;
            });

            // إعداد أولي
            document.addEventListener('DOMContentLoaded', function() {
                updateCurrentDate();
                updateInvoiceDisplay();
                setupCategories();
                
                // السماح بالبحث باستخدام Enter
                document.getElementById('searchInput').addEventListener('keypress', function(e) {
                    if (e.key === 'Enter' && this.value.trim()) {
                        const firstResult = document.querySelector('.result-item');
                        if (firstResult) {
                            firstResult.click();
                        }
                    }
                });
                
                // تركيز على حقل البحث
                document.getElementById('searchInput').focus();
            });

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
            
            // عرض/إخفاء نتائج البحث عند النقر خارجها
            document.addEventListener('click', function(event) {
                if (!event.target.closest('.search-container')) {
                    document.getElementById('searchResults').classList.remove('active');
                }
            });
            
        })();
    </script>
</body>
</html>