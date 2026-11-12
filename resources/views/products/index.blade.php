<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إدارة المنتجات | نظام إدارة البقالة</title>
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

        /* زر إضافة منتج جديد */
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

        /* أدوات التحكم */
        .controls {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
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
            min-width: 180px;
        }

        /* جدول المنتجات */
        .products-table-container {
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

        .products-table {
            width: 100%;
            border-collapse: collapse;
        }

        .products-table th {
            text-align: right;
            padding: 20px;
            color: #8e8e93;
            font-weight: 500;
            border-bottom: 1px solid #e5e5ea;
            background: #fafafa;
        }

        .products-table td {
            padding: 20px;
            border-bottom: 1px solid #f2f2f7;
        }

        .products-table tbody tr {
            transition: background var(--transition-speed) ease;
        }

        .products-table tbody tr:hover {
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
            background: linear-gradient(135deg, var(--warning-color), #ffcc00);
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

        .product-barcode {
            font-size: 12px;
            color: #8e8e93;
            font-family: 'Courier New', monospace;
            background: #f2f2f7;
            padding: 2px 6px;
            border-radius: 4px;
            display: inline-block;
            margin-top: 2px;
        }

        .category-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 500;
            background: rgba(0, 102, 255, 0.1);
            color: var(--primary-color);
        }

        .price-cell {
            font-weight: 600;
            color: var(--dark-color);
        }

        .quantity-cell {
            text-align: center;
        }

        .quantity-badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 500;
        }

        .quantity-badge.high {
            background: rgba(52, 199, 89, 0.1);
            color: var(--success-color);
        }

        .quantity-badge.medium {
            background: rgba(255, 149, 0, 0.1);
            color: var(--warning-color);
        }

        .quantity-badge.low {
            background: rgba(255, 59, 48, 0.1);
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

        .btn-edit {
            background: rgba(0, 102, 255, 0.1);
            color: var(--primary-color);
        }

        .btn-edit:hover {
            background: var(--primary-color);
            color: white;
        }

        .btn-delete {
            background: rgba(255, 59, 48, 0.1);
            color: var(--danger-color);
        }

        .btn-delete:hover {
            background: var(--danger-color);
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

        .total-items {
            font-weight: 500;
            color: #1c1c1e;
        }

        .total-items span {
            font-weight: 600;
            color: var(--primary-color);
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

        /* نافذة إضافة/تعديل المنتج */
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

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #1c1c1e;
        }

        .form-group label.required::after {
            content: " *";
            color: var(--danger-color);
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

        .form-control.error {
            border-color: var(--danger-color);
        }

        .error-message {
            color: var(--danger-color);
            font-size: 14px;
            margin-top: 5px;
            display: none;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }

        .barcode-group {
            display: flex;
            gap: 10px;
        }

        .barcode-group .form-control {
            flex: 1;
        }

        .btn-generate {
            padding: 12px 16px;
            background: rgba(0, 102, 255, 0.1);
            border: 1px solid rgba(0, 102, 255, 0.2);
            border-radius: 12px;
            color: var(--primary-color);
            font-weight: 500;
            cursor: pointer;
            transition: all var(--transition-speed) ease;
            white-space: nowrap;
        }

        .btn-generate:hover {
            background: var(--primary-color);
            color: white;
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

        .alert-message.error {
            border-right: 4px solid var(--danger-color);
        }

        .alert-message i {
            font-size: 20px;
        }

        .alert-message.success i {
            color: var(--success-color);
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
            
            .mobile-menu-btn {
                display: block;
            }
            
            .top-bar {
                flex-direction: column;
                gap: 15px;
                align-items: flex-start;
            }
            
            .controls {
                flex-direction: column;
                align-items: stretch;
            }
            
            .search-box {
                min-width: 100%;
            }
            
            .filter-controls {
                flex-direction: column;
                width: 100%;
            }
            
            .filter-select {
                width: 100%;
            }
            
            .form-row {
                grid-template-columns: 1fr;
            }
            
            .barcode-group {
                flex-direction: column;
            }
            
            .products-table {
                display: block;
                overflow-x: auto;
            }
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        @include('partials.sidebar')
        <!-- الشريط الجانبي -->
        
        <!-- المحتوى الرئيسي -->
        <div class="main-content">
            <!-- شريط العنوان العلوي -->
            <div class="top-bar">
                <div class="page-title">
                    <button class="mobile-menu-btn" onclick="toggleSidebar()">
                        <i class="fas fa-bars"></i>
                    </button>
                    <h1>إدارة المنتجات</h1>
                    <p>إدارة المنتجات القابلة للبيع والمخزون</p>
                </div>
                
                <div class="top-bar-actions">
                    <button class="btn-add" onclick="openAddModal()">
                        <i class="fas fa-plus"></i>
                        إضافة منتج جديد
                    </button>
                </div>
            </div>
            
            <!-- أدوات التحكم -->
            <div class="controls">
                <div class="search-box">
                    <i class="fas fa-search"></i>
                    <input type="text" id="searchInput" placeholder="بحث عن منتج أو باركود..." onkeyup="searchProducts()">
                </div>
                
                <div class="filter-controls">
                    <select class="filter-select" id="categoryFilter" onchange="filterProducts()">
                        <option value="">جميع الأصناف</option>
                        @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                    
                    <select class="filter-select" id="statusFilter" onchange="filterProducts()">
                        <option value="">جميع الحالات</option>
                        <option value="low">مخزون منخفض</option>
                        <option value="expiring">قريب الانتهاء</option>
                        <option value="expired">منتهي الصلاحية</option>
                    </select>
                </div>
            </div>
            
            <!-- جدول المنتجات -->
            <div class="products-table-container">
                <div class="table-header">
                    <h3>قائمة المنتجات</h3>
                    <div class="table-info">
                        <span id="productCount">{{ $products->count() }} منتج</span>
                    </div>
                </div>
                
                <table class="products-table">
                    <thead>
                        <tr>
                            <th>المنتج</th>
                            <th>الصنف</th>
                            <th>سعر الشراء</th>
                            <th>سعر البيع</th>
                            <th>الكمية</th>
                            <th>تاريخ الانتهاء</th>
                            <th>الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody id="productsTableBody">
                        @forelse($products as $product)
                        <tr>
                            <td>
                                <div class="product-info">
                                    <div class="product-icon">
                                        <i class="fas fa-box"></i>
                                    </div>
                                    <div>
                                        <div class="product-name">{{ $product->name }}</div>
                                        <div class="product-barcode">{{ $product->barcode }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="category-badge">{{ $product->category->name ?? 'غير محدد' }}</span>
                            </td>
                            <td class="price-cell">{{ number_format($product->purchase_price, 2) }} ر.س</td>
                            <td class="price-cell">{{ number_format($product->sale_price, 2) }} ر.س</td>
                            <td class="quantity-cell">
                                @php
                                    $quantityClass = $product->quantity_status;
                                    $quantityText = $product->quantity <= 10 ? 'منخفض' : ($product->quantity <= 20 ? 'متوسط' : 'جيد');
                                @endphp
                                <span class="quantity-badge {{ $quantityClass }}">
                                    {{ $product->quantity }} ({{ $quantityText }})
                                </span>
                            </td>
                            <td class="expiry-cell">
                                @php
                                    $expiryClass = $product->expiry_status;
                                    $expiryText = '';
                                    
                                    if ($product->expiry_date) {
                                        $today = \Carbon\Carbon::now();
                                        $expiryDate = \Carbon\Carbon::parse($product->expiry_date);
                                        $diffDays = $today->diffInDays($expiryDate, false);
                                        
                                        if ($diffDays < 0) {
                                            $expiryText = 'منتهي';
                                        } elseif ($diffDays <= 7) {
                                            $expiryText = $diffDays . ' يوم';
                                        } elseif ($diffDays <= 30) {
                                            $expiryText = $diffDays . ' يوم';
                                        } else {
                                            $expiryText = $diffDays . ' يوم';
                                        }
                                    } else {
                                        $expiryText = 'غير محدد';
                                    }
                                @endphp
                                <span class="expiry-badge {{ $expiryClass }}">
                                    {{ $expiryText }}
                                </span>
                                <div style="font-size: 12px; color: #8e8e93; margin-top: 5px;">
                                    {{ $product->expiry_date ? \Carbon\Carbon::parse($product->expiry_date)->format('Y-m-d') : 'غير محدد' }}
                                </div>
                            </td>
                            <td class="actions-cell">
                                <div class="action-buttons">
                                    <button class="btn-action btn-edit" onclick="openEditModal({{ $product->id }})" title="تعديل">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn-action btn-delete" onclick="deleteProduct({{ $product->id }})" title="حذف">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" style="text-align: center; padding: 40px; color: #8e8e93;">
                                <i class="fas fa-box-open" style="font-size: 48px; margin-bottom: 15px; opacity: 0.3;"></i>
                                <p>لا توجد منتجات</p>
                                <small>ابدأ بإضافة منتج جديد</small>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                
                <div class="table-footer">
                    <div class="total-items">
                        إجمالي المنتجات: <span id="totalProducts">{{ $totalProducts }}</span>
                        @if($lowStockProducts > 0)
                        | <span style="color: var(--danger-color);">منخفض المخزون: {{ $lowStockProducts }}</span>
                        @endif
                    </div>
                    
                    <div class="pagination">
                        {{ $products->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- نافذة إضافة/تعديل المنتج -->
    <div class="modal" id="productModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 id="modalTitle">إضافة منتج جديد</h3>
                <button class="btn-close" onclick="closeModal()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <div class="modal-body">
                <form id="productForm">
                    @csrf
                    <input type="hidden" id="productId" name="id">
                    
                    <div class="form-group">
                        <label for="productName" class="required">
                            <i class="fas fa-box"></i> اسم المنتج
                        </label>
                        <input type="text" id="productName" name="name" class="form-control" 
                               placeholder="أدخل اسم المنتج" required>
                        <div class="error-message" id="nameError">اسم المنتج مطلوب</div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="productCategory" class="required">
                                <i class="fas fa-tag"></i> الصنف
                            </label>
                            <select id="productCategory" name="category_id" class="form-control" required>
                                <option value="">اختر الصنف</option>
                                @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                            <div class="error-message" id="categoryError">الرجاء اختيار الصنف</div>
                        </div>
                        
                        <div class="form-group">
                            <label for="barcode" class="required">
                                <i class="fas fa-barcode"></i> باركود المنتج
                            </label>
                            <div class="barcode-group">
                                <input type="text" id="barcode" name="barcode" class="form-control" 
                                       placeholder="أدخل الباركود" required>
                                <button type="button" class="btn-generate" onclick="generateBarcode()">
                                    <i class="fas fa-sync-alt"></i> توليد
                                </button>
                            </div>
                            <div class="error-message" id="barcodeError">الباركود فريد ومطلوب</div>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="purchasePrice" class="required">
                                <i class="fas fa-money-bill-wave"></i> سعر الشراء (ر.س)
                            </label>
                            <input type="number" id="purchasePrice" name="purchase_price" class="form-control" 
                                   placeholder="0.00" step="0.01" min="0" required>
                            <div class="error-message" id="purchasePriceError">الرجاء إدخال سعر شراء صحيح</div>
                        </div>
                        
                        <div class="form-group">
                            <label for="salePrice" class="required">
                                <i class="fas fa-tags"></i> سعر البيع (ر.س)
                            </label>
                            <input type="number" id="salePrice" name="sale_price" class="form-control" 
                                   placeholder="0.00" step="0.01" min="0" required>
                            <div class="error-message" id="salePriceError">الرجاء إدخال سعر بيع صحيح</div>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="quantity" class="required">
                                <i class="fas fa-cubes"></i> الكمية
                            </label>
                            <input type="number" id="quantity" name="quantity" class="form-control" 
                                   placeholder="0" min="0" required>
                            <div class="error-message" id="quantityError">الكمية لا يمكن أن تكون سالبة</div>
                        </div>
                        
                        <div class="form-group">
                            <label for="expiryDate">
                                <i class="fas fa-calendar"></i> تاريخ الانتهاء
                            </label>
                            <input type="date" id="expiryDate" name="expiry_date" class="form-control">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="description">
                            <i class="fas fa-align-left"></i> الوصف (اختياري)
                        </label>
                        <textarea id="description" name="description" class="form-control" 
                                  rows="3" placeholder="أدخل وصفاً للمنتج"></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label for="minimumQuantity">
                            <i class="fas fa-exclamation-triangle"></i> الحد الأدنى للإنذار
                        </label>
                        <input type="number" id="minimumQuantity" name="minimum_quantity" class="form-control" 
                               placeholder="10" min="1" value="10">
                        <small style="color: #8e8e93; font-size: 13px; margin-top: 5px; display: block;">
                            سيظهر المنتج كمخزون منخفض عندما تقل الكمية عن هذا الرقم
                        </small>
                    </div>
                </form>
            </div>
            
            <div class="modal-footer">
                <button type="button" class="btn-secondary" onclick="closeModal()">إلغاء</button>
                <button type="button" class="btn-primary" onclick="saveProduct()">حفظ</button>
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
        let currentProductId = null;
        let isEditing = false;

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

        // فتح نافذة الإضافة
        function openAddModal() {
            @if($categories->count() === 0)
                showAlert('يجب إضافة أصناف أولاً قبل إضافة المنتجات', 'error');
                return;
            @endif
            
            document.getElementById('modalTitle').textContent = 'إضافة منتج جديد';
            document.getElementById('productForm').reset();
            document.getElementById('productId').value = '';
            document.getElementById('minimumQuantity').value = '10';
            currentProductId = null;
            isEditing = false;
            
            // توليد باركود تلقائي
            generateBarcode();
            
            document.getElementById('productModal').classList.add('active');
        }

        // توليد باركود
        async function generateBarcode() {
            try {
                const response = await fetch('{{ route("products.generate-barcode") }}');
                const result = await response.json();
                
                if (result.success) {
                    document.getElementById('barcode').value = result.barcode;
                    validateBarcode();
                }
            } catch (error) {
                console.error('Error:', error);
                showAlert('حدث خطأ في توليد الباركود', 'error');
            }
        }

        // التحقق من الباركود
        async function validateBarcode() {
            const barcode = document.getElementById('barcode').value.trim();
            
            if (!barcode) {
                showError('barcode', 'الباركود مطلوب');
                return false;
            }
            
            if (barcode.length < 3) {
                showError('barcode', 'الباركود قصير جداً');
                return false;
            }
            
            try {
                const response = await fetch(`/products/check-barcode/${barcode}`);
                const result = await response.json();
                
                if (result.exists && !isEditing) {
                    showError('barcode', 'هذا الباركود مستخدم بالفعل');
                    return false;
                }
                
                hideError('barcode');
                return true;
            } catch (error) {
                console.error('Error:', error);
                return false;
            }
        }

        // التحقق من الكمية
        function validateQuantity() {
            const quantity = document.getElementById('quantity').value;
            
            if (!quantity || quantity === "") {
                showError('quantity', 'الكمية مطلوبة');
                return false;
            }
            
            const quantityNum = parseInt(quantity);
            if (isNaN(quantityNum) || quantityNum < 0) {
                showError('quantity', 'الكمية لا يمكن أن تكون سالبة');
                return false;
            }
            
            hideError('quantity');
            return true;
        }

        // التحقق من السعر
        function validatePrice(field) {
            const price = document.getElementById(field).value;
            const fieldName = field === 'purchasePrice' ? 'سعر الشراء' : 'سعر البيع';
            
            if (!price || price === "") {
                showError(field, `${fieldName} مطلوب`);
                return false;
            }
            
            const priceNum = parseFloat(price);
            if (isNaN(priceNum) || priceNum < 0) {
                showError(field, `${fieldName} يجب أن يكون رقماً موجباً`);
                return false;
            }
            
            hideError(field);
            return true;
        }

        // التحقق من الصنف
        function validateCategory() {
            const categoryId = document.getElementById('productCategory').value;
            
            if (!categoryId) {
                showError('category', 'الصنف مطلوب');
                return false;
            }
            
            hideError('category');
            return true;
        }

        // التحقق من اسم المنتج
        function validateProductName() {
            const name = document.getElementById('productName').value.trim();
            
            if (!name) {
                showError('productName', 'اسم المنتج مطلوب');
                return false;
            }
            
            hideError('productName');
            return true;
        }

        // عرض خطأ
        function showError(field, message) {
            const input = document.getElementById(field);
            const errorElement = document.getElementById(`${field}Error`) || document.getElementById('nameError');
            
            if (input) input.classList.add('error');
            if (errorElement) {
                errorElement.textContent = message;
                errorElement.style.display = 'block';
            }
        }

        // إخفاء خطأ
        function hideError(field) {
            const input = document.getElementById(field);
            const errorElement = document.getElementById(`${field}Error`) || document.getElementById('nameError');
            
            if (input) input.classList.remove('error');
            if (errorElement) errorElement.style.display = 'none';
        }

        // فتح نافذة التعديل
        async function openEditModal(productId) {
            try {
                const response = await fetch(`/products/${productId}/details`);
                const result = await response.json();
                
                if (result.success) {
                    const product = result.product;
                    
                    document.getElementById('modalTitle').textContent = 'تعديل منتج';
                    document.getElementById('productId').value = product.id;
                    document.getElementById('productName').value = product.name;
                    document.getElementById('purchasePrice').value = product.purchase_price;
                    document.getElementById('salePrice').value = product.sale_price;
                    document.getElementById('quantity').value = product.quantity;
                    document.getElementById('barcode').value = product.barcode;
                    document.getElementById('expiryDate').value = product.expiry_date || '';
                    document.getElementById('description').value = product.description || '';
                    document.getElementById('minimumQuantity').value = product.minimum_quantity || 10;
                    document.getElementById('productCategory').value = product.category_id;
                    
                    currentProductId = productId;
                    isEditing = true;
                    document.getElementById('productModal').classList.add('active');
                } else {
                    showAlert(result.message, 'error');
                }
            } catch (error) {
                console.error('Error:', error);
                showAlert('حدث خطأ في جلب بيانات المنتج', 'error');
            }
        }

        // إغلاق النافذة
        function closeModal() {
            document.getElementById('productModal').classList.remove('active');
            
            // إعادة تعيين الأخطاء
            ['productName', 'barcode', 'purchasePrice', 'salePrice', 'quantity', 'category'].forEach(field => {
                hideError(field);
            });
        }

        // حفظ المنتج
        async function saveProduct() {
            // التحقق من جميع الحقول
            const isNameValid = validateProductName();
            const isCategoryValid = validateCategory();
            const isBarcodeValid = await validateBarcode();
            const isPurchasePriceValid = validatePrice('purchasePrice');
            const isSalePriceValid = validatePrice('salePrice');
            const isQuantityValid = validateQuantity();
            
            if (!isNameValid || !isCategoryValid || !isBarcodeValid || 
                !isPurchasePriceValid || !isSalePriceValid || !isQuantityValid) {
                showAlert('الرجاء تصحيح الأخطاء في النموذج', 'error');
                return;
            }
            
            const form = document.getElementById('productForm');
            const formData = new FormData(form);
            const url = isEditing ? `/products/${currentProductId}` : '/products';
            const method = isEditing ? 'PUT' : 'POST';
            
            try {
                const response = await fetch(url, {
                    method: method,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(Object.fromEntries(formData))
                });
                
                const result = await response.json();
                
                if (result.success) {
                    showAlert(result.message);
                    closeModal();
                    
                    if (!isEditing) {
                        // إضافة الصف الجديد إلى الجدول
                        const tbody = document.getElementById('productsTableBody');
                        const emptyRow = document.querySelector('#productsTableBody tr td[colspan]');
                        
                        if (emptyRow) {
                            tbody.innerHTML = result.html;
                        } else {
                            tbody.insertAdjacentHTML('afterbegin', result.html);
                        }
                        
                        // تحديث الإحصائيات
                        updateProductCount();
                    } else {
                        // إعادة تحميل الصفحة لرؤية التغييرات
                        location.reload();
                    }
                } else {
                    let errorMessage = result.message;
                    if (result.errors) {
                        errorMessage = Object.values(result.errors).flat().join(', ');
                    }
                    showAlert(errorMessage, 'error');
                }
            } catch (error) {
                console.error('Error:', error);
                showAlert('حدث خطأ في حفظ المنتج', 'error');
            }
        }

        // حذف المنتج
        async function deleteProduct(productId) {
            if (!confirm('هل أنت متأكد من حذف هذا المنتج؟')) {
                return;
            }
            
            try {
                const response = await fetch(`/products/${productId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    }
                });
                
                const result = await response.json();
                
                if (result.success) {
                    showAlert(result.message);
                    // إزالة الصف من الجدول
                    const row = document.querySelector(`tr button[onclick="deleteProduct(${productId})"]`).closest('tr');
                    row.remove();
                    
                    // تحديث الإحصائيات
                    updateProductCount();
                    
                    // إذا كانت الجدول فارغاً، عرض رسالة فارغة
                    const tbody = document.getElementById('productsTableBody');
                    if (tbody.children.length === 1 && tbody.children[0].querySelector('td[colspan]')) {
                        // بالفعل فارغة
                    } else if (tbody.children.length === 0) {
                        tbody.innerHTML = `
                            <tr>
                                <td colspan="7" style="text-align: center; padding: 40px; color: #8e8e93;">
                                    <i class="fas fa-box-open" style="font-size: 48px; margin-bottom: 15px; opacity: 0.3;"></i>
                                    <p>لا توجد منتجات</p>
                                    <small>ابدأ بإضافة منتج جديد</small>
                                </td>
                            </tr>
                        `;
                    }
                } else {
                    showAlert(result.message, 'error');
                }
            } catch (error) {
                console.error('Error:', error);
                showAlert('حدث خطأ في حذف المنتج', 'error');
            }
        }

        // البحث في المنتجات
        async function searchProducts() {
            const searchTerm = document.getElementById('searchInput').value;
            const categoryId = document.getElementById('categoryFilter').value;
            const statusFilter = document.getElementById('statusFilter').value;
            
            try {
                const params = new URLSearchParams({
                    search: searchTerm,
                    category_id: categoryId,
                    status: statusFilter
                });
                
                const response = await fetch(`/products/search?${params}`);
                const result = await response.json();
                
                if (result.success) {
                    document.getElementById('productsTableBody').innerHTML = result.html;
                    updateProductCount();
                }
            } catch (error) {
                console.error('Error:', error);
            }
        }

        // تصفية المنتجات
        function filterProducts() {
            searchProducts();
        }

        // تحديث عدد المنتجات
        function updateProductCount() {
            const rows = document.querySelectorAll('#productsTableBody tr:not([style*="text-align: center"])');
            const count = rows.length;
            
            document.getElementById('productCount').textContent = `${count} منتج`;
            document.getElementById('totalProducts').textContent = count;
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
                sidebar && 
                mobileMenuBtn &&
                !sidebar.contains(event.target) && 
                !mobileMenuBtn.contains(event.target) && 
                sidebar.classList.contains('active')) {
                sidebar.classList.remove('active');
            }
        });

        // إغلاق النافذة عند النقر خارجها
        window.addEventListener('click', function(event) {
            const modal = document.getElementById('productModal');
            if (event.target === modal) {
                closeModal();
            }
        });

        // إضافة مستمعي الأحداث للتحقق في الوقت الحقيقي
        document.getElementById('barcode').addEventListener('blur', validateBarcode);
        document.getElementById('quantity').addEventListener('blur', validateQuantity);
        document.getElementById('purchasePrice').addEventListener('blur', () => validatePrice('purchasePrice'));
        document.getElementById('salePrice').addEventListener('blur', () => validatePrice('salePrice'));
        document.getElementById('productCategory').addEventListener('change', validateCategory);
        document.getElementById('productName').addEventListener('blur', validateProductName);

        // التهيئة
        document.addEventListener('DOMContentLoaded', function() {
            updateProductCount();
        });
    </script>
</body>
</html>