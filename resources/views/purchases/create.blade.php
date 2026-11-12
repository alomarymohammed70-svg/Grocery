<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>المشتريات | نظام إدارة البقالة</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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

        /* زر إضافة مشتريات */
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

        .btn-success {
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

        .btn-success:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(52, 199, 89, 0.3);
        }

        /* محتوى المشتريات */
        .purchase-container {
            display: grid;
            grid-template-columns: 1fr 400px;
            gap: 20px;
            flex: 1;
            min-height: 0;
        }

        .products-section {
            background: white;
            border-radius: var(--border-radius);
            padding: 25px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            display: flex;
            flex-direction: column;
            height: calc(100vh - 200px);
        }

        .invoice-section {
            background: white;
            border-radius: var(--border-radius);
            padding: 25px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            display: flex;
            flex-direction: column;
            height: calc(100vh - 200px);
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 2px solid #f2f2f7;
        }

        .section-header h3 {
            font-size: 18px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        /* اختيار المورد */
        .supplier-selector {
            background: #fafafa;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 25px;
            border: 2px solid transparent;
            transition: border-color var(--transition-speed) ease;
        }

        .supplier-selector.focused {
            border-color: var(--primary-color);
        }

        .supplier-info {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 15px;
        }

        .supplier-avatar {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, #8a2be2, #9370db);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 18px;
            flex-shrink: 0;
        }

        .supplier-details h4 {
            font-weight: 600;
            margin-bottom: 4px;
        }

        .supplier-details p {
            font-size: 14px;
            color: #8e8e93;
        }

        .btn-select-supplier {
            width: 100%;
            padding: 12px;
            border: 2px dashed #e5e5ea;
            background: white;
            border-radius: 12px;
            color: #8e8e93;
            font-size: 14px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            transition: all var(--transition-speed) ease;
        }

        .btn-select-supplier:hover {
            border-color: var(--primary-color);
            color: var(--primary-color);
        }

        /* بحث المنتجات */
        .products-search {
            position: relative;
            margin-bottom: 25px;
        }

        .products-search input {
            width: 100%;
            padding: 15px 20px 15px 50px;
            border: 1px solid #e5e5ea;
            border-radius: 12px;
            font-size: 16px;
            transition: all var(--transition-speed) ease;
            background: white;
        }

        .products-search input:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(0, 102, 255, 0.1);
        }

        .products-search i {
            position: absolute;
            right: 20px;
            top: 50%;
            transform: translateY(-50%);
            color: #8e8e93;
        }

        /* قائمة المنتجات */
        .products-list {
            flex: 1;
            overflow-y: auto;
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 15px;
            padding-right: 5px;
        }

        .product-card {
            background: white;
            border: 1px solid #e5e5ea;
            border-radius: 12px;
            padding: 15px;
            cursor: pointer;
            transition: all var(--transition-speed) ease;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .product-card:hover {
            border-color: var(--primary-color);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

        .product-image {
            width: 100%;
            height: 120px;
            background: linear-gradient(135deg, #f2f2f7, #e5e5ea);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #8e8e93;
            font-size: 40px;
        }

        .product-info h4 {
            font-weight: 500;
            margin-bottom: 5px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .product-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 14px;
            color: #8e8e93;
        }

        .product-stock {
            padding: 2px 8px;
            background: #f2f2f7;
            border-radius: 10px;
            font-size: 12px;
        }

        /* سلة المشتريات */
        .cart-items {
            flex: 1;
            overflow-y: auto;
            margin-bottom: 20px;
            padding-right: 5px;
        }

        .cart-item {
            background: white;
            border: 1px solid #e5e5ea;
            border-radius: 12px;
            padding: 15px;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 15px;
            transition: all var(--transition-speed) ease;
        }

        .cart-item:hover {
            border-color: var(--primary-color);
        }

        .cart-item-image {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, #f2f2f7, #e5e5ea);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #8e8e93;
            font-size: 20px;
            flex-shrink: 0;
        }

        .cart-item-details {
            flex: 1;
        }

        .cart-item-details h4 {
            font-weight: 500;
            margin-bottom: 5px;
        }

        .cart-item-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 14px;
            color: #8e8e93;
        }

        .quantity-controls {
            display: flex;
            align-items: center;
            gap: 10px;
            background: #fafafa;
            border-radius: 20px;
            padding: 5px;
        }

        .quantity-btn {
            width: 30px;
            height: 30px;
            border: none;
            background: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-weight: 600;
            transition: all var(--transition-speed) ease;
        }

        .quantity-btn:hover {
            background: var(--primary-color);
            color: white;
        }

        .quantity-input {
            width: 50px;
            text-align: center;
            border: none;
            background: transparent;
            font-size: 16px;
            font-weight: 500;
        }

        .quantity-input:focus {
            outline: none;
        }

        .item-price {
            font-weight: 600;
            color: var(--dark-color);
            min-width: 80px;
            text-align: left;
        }

        .btn-remove-item {
            width: 30px;
            height: 30px;
            border: none;
            background: rgba(255, 59, 48, 0.1);
            color: var(--danger-color);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all var(--transition-speed) ease;
        }

        .btn-remove-item:hover {
            background: var(--danger-color);
            color: white;
        }

        /* ملخص الفاتورة */
        .invoice-summary {
            border-top: 2px solid #f2f2f7;
            padding-top: 20px;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
            padding: 8px 0;
            color: #8e8e93;
        }

        .summary-row.total {
            border-top: 2px solid #f2f2f7;
            padding-top: 15px;
            margin-top: 10px;
            font-size: 18px;
            font-weight: 700;
            color: var(--dark-color);
        }

        .summary-value {
            font-weight: 500;
            color: var(--dark-color);
        }

        /* خيارات الدفع */
        .payment-options {
            background: #fafafa;
            border-radius: 12px;
            padding: 20px;
            margin-top: 20px;
        }

        .payment-methods {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 10px;
            margin-top: 15px;
        }

        .payment-method {
            padding: 12px;
            border: 2px solid #e5e5ea;
            background: white;
            border-radius: 10px;
            text-align: center;
            cursor: pointer;
            transition: all var(--transition-speed) ease;
        }

        .payment-method:hover {
            border-color: var(--primary-color);
        }

        .payment-method.selected {
            border-color: var(--primary-color);
            background: rgba(0, 102, 255, 0.1);
        }

        .payment-method i {
            font-size: 20px;
            margin-bottom: 8px;
            color: var(--primary-color);
        }

        .payment-method span {
            display: block;
            font-size: 12px;
            font-weight: 500;
        }

        /* أزرار الفاتورة */
        .invoice-actions {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
            margin-top: 20px;
        }

        .btn-secondary {
            padding: 12px;
            border: 1px solid #e5e5ea;
            background: white;
            border-radius: 12px;
            color: #1c1c1e;
            font-weight: 500;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: all var(--transition-speed) ease;
        }

        .btn-secondary:hover {
            background: #f2f2f7;
            transform: translateY(-2px);
        }

        /* نافذة اختيار المورد */
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
            max-width: 600px;
            max-height: 80vh;
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

        /* قائمة الموردين */
        .suppliers-list {
            max-height: 400px;
            overflow-y: auto;
            padding-right: 10px;
        }

        .supplier-item {
            padding: 15px;
            border: 1px solid #e5e5ea;
            border-radius: 12px;
            margin-bottom: 10px;
            cursor: pointer;
            transition: all var(--transition-speed) ease;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .supplier-item:hover {
            border-color: var(--primary-color);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

        .supplier-item.selected {
            border-color: var(--primary-color);
            background: rgba(0, 102, 255, 0.1);
        }

        .supplier-item-avatar {
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

        .supplier-item-details h4 {
            font-weight: 500;
            margin-bottom: 4px;
        }

        .supplier-item-details p {
            font-size: 13px;
            color: #8e8e93;
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
        @media (max-width: 1024px) {
            .purchase-container {
                grid-template-columns: 1fr;
                height: auto;
            }
            
            .products-section, .invoice-section {
                height: auto;
                min-height: 500px;
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
            
            .payment-methods {
                grid-template-columns: 1fr 1fr;
            }
            
            .invoice-actions {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 480px) {
            .products-list {
                grid-template-columns: 1fr;
            }
            
            .payment-methods {
                grid-template-columns: 1fr;
            }
            
            .cart-item {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }
            
            .cart-item-meta {
                width: 100%;
            }
        }

        /* تحسينات التمرير */
        .table-scroll {
            overflow-y: auto;
            flex: 1;
            min-height: 0;
        }

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
                        <h1>المشتريات</h1>
                        <p>تسجيل عمليات الشراء من الموردين وتغذية المخزون</p>
                    </div>
                </div>
                
                <div class="top-bar-actions">
                    <button class="btn-success" onclick="savePurchase()">
                        <i class="fas fa-save"></i>
                        حفظ الفاتورة
                    </button>
                </div>
            </div>
            
            <!-- محتوى المشتريات -->
            <div class="purchase-container">
                <!-- قسم المنتجات -->
                <div class="products-section">
                    <div class="section-header">
                        <h3><i class="fas fa-box-open"></i> المنتجات المتاحة</h3>
                        <div class="section-actions">
                            <button class="btn-secondary" onclick="clearCart()">
                                <i class="fas fa-trash"></i>
                                تفريغ السلة
                            </button>
                        </div>
                    </div>
                    
                    <!-- اختيار المورد -->
                    <div class="supplier-selector" id="supplierSelector">
                        <div class="supplier-info" id="selectedSupplierInfo" style="display: none;">
                            <div class="supplier-avatar" id="supplierAvatar">م</div>
                            <div class="supplier-details">
                                <h4 id="supplierName">اسم المورد</h4>
                                <p id="supplierPhone">رقم الهاتف</p>
                            </div>
                        </div>
                        <button class="btn-select-supplier" onclick="openSupplierModal()" id="selectSupplierBtn">
                            <i class="fas fa-user-plus"></i>
                            اختر موردًا للمشتريات
                        </button>
                    </div>
                    
                    <!-- بحث المنتجات -->
                    <div class="products-search">
                        <i class="fas fa-search"></i>
                        <input type="text" id="productSearch" placeholder="ابحث عن منتج بالاسم أو الرمز..." onkeyup="searchProducts()">
                    </div>
                    
                    <!-- قائمة المنتجات -->
                    <div class="table-scroll">
                        <div class="products-list" id="productsList">
                            <!-- سيتم تعبئة المنتجات عن طريق JavaScript -->
                        </div>
                    </div>
                </div>
                
                <!-- قسم الفاتورة -->
                <div class="invoice-section">
                    <div class="section-header">
                        <h3><i class="fas fa-file-invoice"></i> فاتورة الشراء</h3>
                        <span id="invoiceNumber">{{ $invoiceNumber }}</span>
                    </div>
                    
                    <!-- سلة المشتريات -->
                    <div class="cart-items" id="cartItems">
                        <!-- سيتم تعبئة عناصر السلة عن طريق JavaScript -->
                    </div>
                    
                    <!-- ملخص الفاتورة -->
                    <div class="invoice-summary">
                        <div class="summary-row">
                            <span>عدد المنتجات</span>
                            <span class="summary-value" id="totalItems">0</span>
                        </div>
                        <div class="summary-row">
                            <span>إجمالي الكميات</span>
                            <span class="summary-value" id="totalQuantity">0</span>
                        </div>
                        <div class="summary-row">
                            <span>المبلغ الإجمالي</span>
                            <span class="summary-value" id="subtotal">0.00 ر.س</span>
                        </div>
                        <div class="summary-row">
                            <span>الضريبة (15%)</span>
                            <span class="summary-value" id="taxAmount">0.00 ر.س</span>
                        </div>
                        <div class="summary-row">
                            <span>خصم (إن وجد)</span>
                            <span class="summary-value" id="discount">0.00 ر.س</span>
                        </div>
                        <div class="summary-row total">
                            <span>المبلغ النهائي</span>
                            <span class="summary-value" id="totalAmount">0.00 ر.س</span>
                        </div>
                    </div>
                    
                    <!-- خيارات الدفع -->
                    <div class="payment-options">
                        <h4><i class="fas fa-credit-card"></i> طريقة الدفع</h4>
                        <div class="payment-methods">
                            <div class="payment-method selected" data-method="cash" onclick="selectPaymentMethod('cash')">
                                <i class="fas fa-money-bill-wave"></i>
                                <span>نقداً</span>
                            </div>
                            <div class="payment-method" data-method="transfer" onclick="selectPaymentMethod('transfer')">
                                <i class="fas fa-university"></i>
                                <span>تحويل بنكي</span>
                            </div>
                            <div class="payment-method" data-method="credit" onclick="selectPaymentMethod('credit')">
                                <i class="fas fa-calendar"></i>
                                <span>آجل</span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- أزرار الفاتورة -->
                    <div class="invoice-actions">
                        <button class="btn-secondary" onclick="printInvoice()">
                            <i class="fas fa-print"></i>
                            طباعة
                        </button>
                        <button class="btn-primary" onclick="savePurchase()">
                            <i class="fas fa-save"></i>
                            حفظ وتأكيد
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- نافذة اختيار المورد -->
    <div class="modal" id="supplierModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3><i class="fas fa-users"></i> اختر موردًا</h3>
                <button class="btn-close" onclick="closeSupplierModal()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <div class="modal-body">
                <div class="suppliers-list" id="suppliersList">
                    <!-- سيتم تعبئة الموردين عن طريق JavaScript -->
                </div>
            </div>
            
            <div class="modal-footer" style="padding: 20px 25px; border-top: 1px solid #e5e5ea;">
                <button class="btn-primary" onclick="confirmSupplierSelection()">
                    <i class="fas fa-check"></i> تأكيد الاختيار
                </button>
            </div>
        </div>
    </div>
    
    <!-- رسالة تنبيه -->
    <div id="alertMessage" class="alert-message">
        <i class="fas fa-check-circle"></i>
        <span id="alertText">تمت العملية بنجاح</span>
    </div>

    <script>
        // بيانات متغيرة
        let cart = [];
        let selectedSupplier = null;
        let selectedPaymentMethod = 'cash';
        let selectedSupplierInModal = null;
        let allProducts = [];

        // الحصول على CSRF token
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        // تحميل الموردين من الخادم
        async function loadSuppliers() {
            try {
                const response = await fetch("{{ route('purchases.api.suppliers') }}");
                return await response.json();
            } catch (error) {
                console.error('Error loading suppliers:', error);
                return [];
            }
        }

        // تحميل المنتجات من الخادم
        async function loadProducts() {
            try {
                const response = await fetch("{{ route('purchases.api.products') }}");
                const products = await response.json();
                allProducts = products;
                return products;
            } catch (error) {
                console.error('Error loading products:', error);
                return [];
            }
        }

        // توليد رقم فاتورة جديد
        async function generateInvoiceNumber() {
            try {
                const response = await fetch("{{ route('purchases.api.invoice-number') }}");
                const data = await response.json();
                document.getElementById('invoiceNumber').textContent = data.invoice_number;
                return data.invoice_number;
            } catch (error) {
                console.error('Error generating invoice number:', error);
                return '{{ $invoiceNumber }}';
            }
        }

        // الحصول على اسم مختصر للمورد
        function getSupplierInitials(name) {
            const names = name.split(' ');
            if (names.length >= 2) {
                return names[0][0] + names[1][0];
            }
            return name.substring(0, 2).toUpperCase();
        }

        // الحصول على اسم مختصر للمنتج
        function getProductInitials(name) {
            const names = name.split(' ');
            if (names.length >= 2) {
                return names[0][0] + names[1][0];
            }
            return name.substring(0, 2).toUpperCase();
        }

        // تحديث ملخص الفاتورة
        function updateInvoiceSummary() {
            const totalItems = cart.length;
            const totalQuantity = cart.reduce((sum, item) => sum + item.quantity, 0);
            const subtotal = cart.reduce((sum, item) => sum + (item.purchase_price * item.quantity), 0);
            const taxAmount = subtotal * 0.15; // ضريبة 15%
            const discount = 0; // يمكن إضافة خصم لاحقاً
            const totalAmount = subtotal + taxAmount - discount;
            
            document.getElementById('totalItems').textContent = totalItems;
            document.getElementById('totalQuantity').textContent = totalQuantity;
            document.getElementById('subtotal').textContent = subtotal.toFixed(2) + ' ر.س';
            document.getElementById('taxAmount').textContent = taxAmount.toFixed(2) + ' ر.س';
            document.getElementById('discount').textContent = discount.toFixed(2) + ' ر.س';
            document.getElementById('totalAmount').textContent = totalAmount.toFixed(2) + ' ر.س';
            
            return { totalItems, totalQuantity, subtotal, taxAmount, discount, totalAmount };
        }

        // فتح نافذة اختيار المورد
        async function openSupplierModal() {
            selectedSupplierInModal = null;
            await renderSuppliersList();
            document.getElementById('supplierModal').classList.add('active');
        }

        // إغلاق نافذة اختيار المورد
        function closeSupplierModal() {
            document.getElementById('supplierModal').classList.remove('active');
        }

        // عرض قائمة الموردين
        async function renderSuppliersList() {
            const suppliersList = document.getElementById('suppliersList');
            suppliersList.innerHTML = '';
            
            const suppliers = await loadSuppliers();
            
            if (suppliers.length === 0) {
                suppliersList.innerHTML = `
                    <div class="empty-state">
                        <i class="fas fa-users"></i>
                        <p>لا توجد موردين</p>
                        <small>يجب إضافة موردين أولاً</small>
                    </div>
                `;
                return;
            }
            
            suppliers.forEach(supplier => {
                const supplierDiv = document.createElement('div');
                supplierDiv.className = `supplier-item ${selectedSupplier && selectedSupplier.id === supplier.id ? 'selected' : ''}`;
                supplierDiv.onclick = () => selectSupplierInModal(supplier);
                
                supplierDiv.innerHTML = `
                    <div class="supplier-item-avatar">
                        ${getSupplierInitials(supplier.name)}
                    </div>
                    <div class="supplier-item-details">
                        <h4>${supplier.name}</h4>
                        <p>${supplier.phone || ''} | ${supplier.company || 'لا توجد شركة'}</p>
                        <p><small>${supplier.address || 'لا يوجد عنوان'}</small></p>
                    </div>
                `;
                
                suppliersList.appendChild(supplierDiv);
            });
        }

        // اختيار مورد في النافذة
        function selectSupplierInModal(supplier) {
            selectedSupplierInModal = supplier;
            
            // تحديث التحديد
            document.querySelectorAll('.supplier-item').forEach(item => {
                item.classList.remove('selected');
            });
            event.currentTarget.classList.add('selected');
        }

        // تأكيد اختيار المورد
        function confirmSupplierSelection() {
            if (!selectedSupplierInModal) {
                showAlert('الرجاء اختيار مورد', 'warning');
                return;
            }
            
            selectedSupplier = selectedSupplierInModal;
            updateSelectedSupplierDisplay();
            closeSupplierModal();
            
            // تصفية المنتجات حسب المورد المختار
            renderProductsList();
            
            showAlert(`تم اختيار المورد: ${selectedSupplier.name}`);
        }

        // تحديث عرض المورد المختار
        function updateSelectedSupplierDisplay() {
            if (selectedSupplier) {
                document.getElementById('selectedSupplierInfo').style.display = 'flex';
                document.getElementById('selectSupplierBtn').style.display = 'none';
                document.getElementById('supplierAvatar').textContent = getSupplierInitials(selectedSupplier.name);
                document.getElementById('supplierName').textContent = selectedSupplier.name;
                document.getElementById('supplierPhone').textContent = selectedSupplier.phone || 'لا يوجد رقم';
                document.getElementById('supplierSelector').classList.add('focused');
            } else {
                document.getElementById('selectedSupplierInfo').style.display = 'none';
                document.getElementById('selectSupplierBtn').style.display = 'block';
                document.getElementById('supplierSelector').classList.remove('focused');
            }
        }

        // البحث عن المنتجات
        function searchProducts() {
            renderProductsList();
        }

        // عرض قائمة المنتجات
        async function renderProductsList() {
            const productsList = document.getElementById('productsList');
            productsList.innerHTML = '';
            
            const searchTerm = document.getElementById('productSearch').value.toLowerCase();
            
            // تصفية المنتجات حسب المورد والبحث
            let filteredProducts = allProducts;
            
            if (selectedSupplier) {
                // في نظام حقيقي، قد يكون هناك حقل supplier_id في جدول المنتجات
                // للتبسيط، سنعرض جميع المنتجات
                // filteredProducts = filteredProducts.filter(product => product.supplier_id === selectedSupplier.id);
            }
            
            if (searchTerm) {
                filteredProducts = filteredProducts.filter(product => 
                    product.name.toLowerCase().includes(searchTerm) || 
                    (product.barcode && product.barcode.toLowerCase().includes(searchTerm))
                );
            }
            
            if (filteredProducts.length === 0) {
                productsList.innerHTML = `
                    <div class="empty-state" style="grid-column: 1 / -1;">
                        <i class="fas fa-box-open"></i>
                        <p>${selectedSupplier ? 'لا توجد منتجات لهذا المورد' : 'اختر منتجات من القائمة'}</p>
                        <small>${searchTerm ? 'جرب بحثاً مختلفاً' : ''}</small>
                    </div>
                `;
                return;
            }
            
            filteredProducts.forEach(product => {
                const productCard = document.createElement('div');
                productCard.className = 'product-card';
                productCard.onclick = () => addToCart(product);
                
                productCard.innerHTML = `
                    <div class="product-image">
                        ${getProductInitials(product.name)}
                    </div>
                    <div class="product-info">
                        <h4 title="${product.name}">${product.name}</h4>
                        <div class="product-meta">
                            <span>${product.barcode || 'لا يوجد باركود'}</span>
                            <span class="product-stock">${product.quantity || 0} ${product.unit || 'وحدة'}</span>
                        </div>
                        <div style="margin-top: 10px; text-align: left;">
                            <small style="color: #8e8e93;">سعر الشراء:</small>
                            <div style="font-weight: 600; color: var(--primary-color);">
                                ${product.purchase_price ? product.purchase_price.toFixed(2) : '0.00'} ر.س
                            </div>
                        </div>
                    </div>
                `;
                
                productsList.appendChild(productCard);
            });
        }

        // إضافة منتج إلى السلة
        function addToCart(product) {
            // التحقق إذا كان المنتج موجوداً بالفعل في السلة
            const existingItem = cart.find(item => item.id === product.id);
            
            if (existingItem) {
                existingItem.quantity += 1;
            } else {
                cart.push({
                    ...product,
                    quantity: 1,
                    total: product.purchase_price || 0
                });
            }
            
            updateCartDisplay();
            updateInvoiceSummary();
            showAlert(`تم إضافة ${product.name} إلى السلة`);
        }

        // تحديث عرض السلة
        function updateCartDisplay() {
            const cartItems = document.getElementById('cartItems');
            
            if (cart.length === 0) {
                cartItems.innerHTML = `
                    <div class="empty-state">
                        <i class="fas fa-shopping-cart"></i>
                        <p>سلة المشتريات فارغة</p>
                        <small>اختر منتجات من القائمة لإضافتها إلى السلة</small>
                    </div>
                `;
                return;
            }
            
            cartItems.innerHTML = '';
            
            cart.forEach((item, index) => {
                const cartItem = document.createElement('div');
                cartItem.className = 'cart-item';
                
                cartItem.innerHTML = `
                    <div class="cart-item-image">
                        ${getProductInitials(item.name)}
                    </div>
                    <div class="cart-item-details">
                        <h4>${item.name}</h4>
                        <div class="cart-item-meta">
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <div class="quantity-controls">
                                    <button class="quantity-btn" onclick="decreaseQuantity(${index})">-</button>
                                    <input type="number" 
                                           class="quantity-input" 
                                           value="${item.quantity}" 
                                           min="1" 
                                           onchange="updateQuantity(${index}, this.value)"
                                           onblur="updateQuantity(${index}, this.value)">
                                    <button class="quantity-btn" onclick="increaseQuantity(${index})">+</button>
                                </div>
                                <span style="color: #8e8e93;">${item.unit || 'وحدة'}</span>
                            </div>
                            <div style="text-align: left;">
                                <div class="item-price">
                                    ${((item.purchase_price || 0) * item.quantity).toFixed(2)} ر.س
                                </div>
                                <small style="color: #8e8e93; display: block; margin-top: 2px;">
                                    ${(item.purchase_price || 0).toFixed(2)} ر.س لل${item.unit || 'وحدة'}
                                </small>
                            </div>
                        </div>
                    </div>
                    <button class="btn-remove-item" onclick="removeFromCart(${index})" title="إزالة من السلة">
                        <i class="fas fa-times"></i>
                    </button>
                `;
                
                cartItems.appendChild(cartItem);
            });
        }

        // زيادة كمية المنتج
        function increaseQuantity(index) {
            if (index >= 0 && index < cart.length) {
                cart[index].quantity += 1;
                updateCartDisplay();
                updateInvoiceSummary();
            }
        }

        // تقليل كمية المنتج
        function decreaseQuantity(index) {
            if (index >= 0 && index < cart.length) {
                if (cart[index].quantity > 1) {
                    cart[index].quantity -= 1;
                } else {
                    cart.splice(index, 1);
                }
                updateCartDisplay();
                updateInvoiceSummary();
            }
        }

        // تحديث كمية المنتج
        function updateQuantity(index, value) {
            const quantity = parseInt(value);
            if (quantity >= 1 && index >= 0 && index < cart.length) {
                cart[index].quantity = quantity;
                updateCartDisplay();
                updateInvoiceSummary();
            }
        }

        // إزالة منتج من السلة
        function removeFromCart(index) {
            if (index >= 0 && index < cart.length) {
                const productName = cart[index].name;
                cart.splice(index, 1);
                updateCartDisplay();
                updateInvoiceSummary();
                showAlert(`تم إزالة ${productName} من السلة`);
            }
        }

        // تفريغ السلة
        function clearCart() {
            if (cart.length === 0) {
                showAlert('السلة فارغة بالفعل', 'warning');
                return;
            }
            
            if (confirm('هل تريد تفريغ سلة المشتريات بالكامل؟')) {
                cart = [];
                updateCartDisplay();
                updateInvoiceSummary();
                showAlert('تم تفريغ سلة المشتريات');
            }
        }

        // اختيار طريقة الدفع
        function selectPaymentMethod(method) {
            selectedPaymentMethod = method;
            
            // تحديث التحديد
            document.querySelectorAll('.payment-method').forEach(item => {
                item.classList.remove('selected');
                if (item.dataset.method === method) {
                    item.classList.add('selected');
                }
            });
        }

        // حفظ المشتريات
        async function savePurchase() {
            if (!selectedSupplier) {
                showAlert('الرجاء اختيار مورد أولاً', 'error');
                openSupplierModal();
                return;
            }
            
            if (cart.length === 0) {
                showAlert('الرجاء إضافة منتجات إلى السلة', 'error');
                return;
            }
            
            const invoiceSummary = updateInvoiceSummary();
            
            // تحضير البيانات
            const purchaseData = {
                supplier_id: selectedSupplier.id,
                invoice_number: document.getElementById('invoiceNumber').textContent,
                purchase_date: new Date().toISOString().split('T')[0],
                items: cart.map(item => ({
                    product_id: item.id,
                    quantity: item.quantity,
                    purchase_price: item.purchase_price || 0
                })),
                subtotal: invoiceSummary.subtotal,
                tax: invoiceSummary.taxAmount,
                discount: invoiceSummary.discount,
                total: invoiceSummary.totalAmount,
                payment_method: selectedPaymentMethod,
                notes: ''
            };
            
            try {
                const response = await fetch("{{ route('purchases.store') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(purchaseData)
                });
                
                const result = await response.json();
                
                if (result.success) {
                    showAlert('تم حفظ فاتورة الشراء بنجاح', 'success');
                    
                    // إعادة تعيين النموذج
                    resetPurchaseForm();
                    
                    // إعادة توجيه أو تحديث الصفحة
                    setTimeout(() => {
                        window.location.href = "{{ route('purchases.index') }}";
                    }, 2000);
                } else {
                    showAlert(result.message || 'حدث خطأ أثناء الحفظ', 'error');
                }
            } catch (error) {
                console.error('Error saving purchase:', error);
                showAlert('حدث خطأ أثناء حفظ الفاتورة', 'error');
            }
        }

        // إعادة تعيين نموذج المشتريات
        async function resetPurchaseForm() {
            cart = [];
            selectedSupplier = null;
            selectedPaymentMethod = 'cash';
            selectedSupplierInModal = null;
            
            updateSelectedSupplierDisplay();
            updateCartDisplay();
            updateInvoiceSummary();
            
            // إعادة اختيار طريقة الدفع الافتراضية
            selectPaymentMethod('cash');
            
            // تحديث رقم الفاتورة
            await generateInvoiceNumber();
            
            // إعادة تحميل المنتجات
            await loadProducts();
            renderProductsList();
        }

        // طباعة الفاتورة
        function printInvoice() {
            if (cart.length === 0) {
                showAlert('لا يمكن طباعة فاتورة فارغة', 'warning');
                return;
            }
            
            // محاكاة الطباعة
            alert('جاري طباعة الفاتورة...');
            // في نظام حقيقي، هنا يتم فتح نافذة طباعة أو إنشاء ملف PDF
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
            alert.style.display = 'flex';
        }

        // تفعيل/تعطيل الشريط الجانبي على الجوال
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('active');
        }

        // التهيئة عند تحميل الصفحة
        document.addEventListener('DOMContentLoaded', async function() {
            await loadProducts();
            renderProductsList();
            updateInvoiceSummary();
            
            // البحث الفوري عن المنتجات
            document.getElementById('productSearch').addEventListener('input', renderProductsList);
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
    </script>
</body>
</html>