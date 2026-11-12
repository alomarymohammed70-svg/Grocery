<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إدارة الأصناف | نظام إدارة البقالة</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/sidebar.css') }}">

    <style>
        :root {
            --primary-color: #0066ff;
            --secondary-color: #5ac8fa;
            --success-color: #34c759;
            --warning-color: #ff9500;
            --danger-color: #ff3b30;
            --dark-color: #1c1c1e;
            --light-color: #f2f2f7;
            --header-height: 70px;
            --border-radius: 16px;
            --transition-speed: 0.3s;
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
        }

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

        .search-box {
            margin-bottom: 25px;
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

        .categories-table-container {
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
        .categories-table {
            width: 100%;
            border-collapse: collapse;
        }

        .categories-table th {
            text-align: right;
            padding: 20px;
            color: #8e8e93;
            font-weight: 500;
            border-bottom: 1px solid #e5e5ea;
            background: #fafafa;
        }

        .categories-table td {
            padding: 20px;
            border-bottom: 1px solid #f2f2f7;
        }

        .categories-table tbody tr {
            transition: background var(--transition-speed) ease;
        }

        .categories-table tbody tr:hover {
            background: #fafafa;
        }

        .category-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .category-icon {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 20px;
        }

        .category-details h4 {
            font-weight: 500;
            margin-bottom: 4px;
        }

        .category-details p {
            font-size: 13px;
            color: #8e8e93;
        }

        .products-count {
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
            width: 40px;
            height: 40px;
            border-radius: 10px;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all var(--transition-speed) ease;
            font-size: 16px;
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

        .btn-products {
            background: rgba(52, 199, 89, 0.1);
            color: var(--success-color);
        }

        .btn-products:hover {
            background: var(--success-color);
            color: white;
        }

        .table-footer {
            padding: 20px 25px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-top: 1px solid #e5e5ea;
            background: #fafafa;
        }

        .total-categories {
            font-weight: 500;
            color: #1c1c1e;
        }

        .total-categories span {
            font-weight: 600;
            color: var(--primary-color);
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
            
            .categories-table {
                display: block;
                overflow-x: auto;
            }
            
            .action-buttons {
                flex-direction: column;
                gap: 5px;
            }
            
            .btn-action {
                width: 100%;
                height: 36px;
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
                    <h1>إدارة الأصناف</h1>
                    <p>تنظيم المنتجات ضمن تصنيفات رئيسية</p>
                </div>
                
                <div class="top-bar-actions">
                    <button class="btn-add" onclick="openAddModal()">
                        <i class="fas fa-plus"></i>
                        إضافة صنف جديد
                    </button>
                </div>
            </div>
            
            <!-- شريط البحث -->
            <div class="search-box">
                <i class="fas fa-search"></i>
                <input type="text" id="searchInput" placeholder="بحث عن صنف..." onkeyup="searchCategories()">
            </div>
            
            <!-- جدول الأصناف -->
            <div class="categories-table-container">
                <div class="table-header">
                    <h3>قائمة الأصناف</h3>
                    <div class="table-info">
                        <span id="categoryCount">{{ $categories->count() }} صنف</span>
                    </div>
                </div>
                
                <table class="categories-table">
                    <thead>
                        <tr>
                            <th style="width: 50%;">اسم الصنف</th>
                            <th>عدد المنتجات</th>
                            <th>الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody id="categoriesTableBody">
                        @forelse($categories as $category)
                        <tr data-category-id="{{ $category->id }}">
                            <td>
                                <div class="category-info">
                                    <div class="category-icon" style="background: {{ $category->color_code ?? getCategoryColor($category->id) }};">
                                        <i class="fas fa-tag"></i>
                                    </div>
                                    <div class="category-details">
                                        <h4>{{ $category->name }}</h4>
                                        <p>{{ $category->description ?? 'تصنيف عام للمنتجات' }}</p>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="products-count">{{ $category->products_count ?? 0 }} منتج</span>
                            </td>
                            <td class="actions-cell">
                                <div class="action-buttons">
                                    <button class="btn-action btn-edit" onclick="openEditModal({{ $category->id }})" title="تعديل">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn-action btn-delete" onclick="deleteCategory({{ $category->id }})" title="حذف">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                    <button class="btn-action btn-products" onclick="viewCategoryProducts({{ $category->id }})" title="عرض المنتجات">
                                        <i class="fas fa-box"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" style="text-align: center; padding: 40px; color: #8e8e93;">
                                <i class="fas fa-inbox" style="font-size: 48px; margin-bottom: 15px; opacity: 0.3;"></i>
                                <p>لا توجد أصناف</p>
                                <small>ابدأ بإضافة صنف جديد</small>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                
                <div class="table-footer">
                    <div class="total-categories">
                        إجمالي الأصناف: <span id="totalCategories">{{ $totalCategories ?? $categories->count() }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- نافذة إضافة/تعديل الصنف -->
    <div class="modal" id="categoryModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 id="modalTitle">إضافة صنف جديد</h3>
                <button class="btn-close" onclick="closeModal()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <div class="modal-body">
                <form id="categoryForm">
                    @csrf
                    <input type="hidden" id="categoryId" name="id">
                    
                    <div class="form-group">
                        <label for="categoryName">
                            <i class="fas fa-tag"></i> اسم الصنف
                        </label>
                        <input type="text" id="categoryName" name="name" class="form-control" 
                               placeholder="أدخل اسم الصنف (مثال: مشتقات الحليب)" required>
                        <small style="color: #8e8e93; font-size: 13px; margin-top: 5px; display: block;">
                            الصنف هو مجرد حاوية تنظيمية للمنتجات
                        </small>
                    </div>
                    
                    <div class="form-group">
                        <label for="categoryDescription">
                            <i class="fas fa-align-left"></i> الوصف (اختياري)
                        </label>
                        <textarea id="categoryDescription" name="description" class="form-control" 
                                  rows="3" placeholder="أدخل وصفاً للصنف"></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label for="categoryColor">
                            <i class="fas fa-palette"></i> لون الصنف (اختياري)
                        </label>
                        <input type="color" id="categoryColor" name="color_code" class="form-control" 
                               value="#0066ff" style="height: 45px; padding: 5px;">
                    </div>
                </form>
            </div>
            
            <div class="modal-footer">
                <button type="button" class="btn-secondary" onclick="closeModal()">إلغاء</button>
                <button type="button" class="btn-primary" id="saveButton" onclick="saveCategory()">حفظ</button>
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
        let currentCategoryId = null;
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
        }

        // فتح نافذة الإضافة
        function openAddModal() {
            document.getElementById('modalTitle').textContent = 'إضافة صنف جديد';
            document.getElementById('categoryForm').reset();
            document.getElementById('categoryId').value = '';
            document.getElementById('categoryColor').value = '#0066ff';
            currentCategoryId = null;
            isEditing = false;
            document.getElementById('categoryModal').classList.add('active');
            
            // تفعيل زر الحفظ
            document.getElementById('saveButton').disabled = false;
            document.getElementById('saveButton').innerHTML = 'حفظ';
        }

        // فتح نافذة التعديل
        async function openEditModal(categoryId) {
            try {
                // إظهار مؤشر التحميل
                const saveButton = document.getElementById('saveButton');
                saveButton.disabled = true;
                saveButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> جاري التحميل...';
                
                document.getElementById('modalTitle').textContent = 'تعديل صنف';
                document.getElementById('categoryModal').classList.add('active');
                
                const response = await fetch(`/categories/${categoryId}/details`);
                const result = await response.json();
                
                if (result.success) {
                    const category = result.category;
                    
                    document.getElementById('categoryId').value = category.id;
                    document.getElementById('categoryName').value = category.name;
                    document.getElementById('categoryDescription').value = category.description || '';
                    document.getElementById('categoryColor').value = category.color_code || '#0066ff';
                    
                    currentCategoryId = categoryId;
                    isEditing = true;
                    
                    // إعادة تفعيل زر الحفظ
                    saveButton.disabled = false;
                    saveButton.innerHTML = 'حفظ';
                } else {
                    showAlert(result.message, 'error');
                    closeModal();
                }
            } catch (error) {
                console.error('Error:', error);
                showAlert('حدث خطأ في جلب بيانات الصنف', 'error');
                closeModal();
            }
        }

        // إغلاق النافذة
        function closeModal() {
            document.getElementById('categoryModal').classList.remove('active');
        }

        // حفظ الصنف
        async function saveCategory() {
            // التحقق من صحة النموذج
            const nameInput = document.getElementById('categoryName');
            if (!nameInput.value.trim()) {
                showAlert('يرجى إدخال اسم الصنف', 'error');
                nameInput.focus();
                return;
            }
            
            // تعطيل زر الحفظ أثناء المعالجة
            const saveButton = document.getElementById('saveButton');
            saveButton.disabled = true;
            saveButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> جاري الحفظ...';
            
            const url = isEditing ? `/categories/${currentCategoryId}` : '/categories';
            const method = isEditing ? 'PUT' : 'POST';
            
            // تحضير البيانات
            const data = {
                name: document.getElementById('categoryName').value.trim(),
                description: document.getElementById('categoryDescription').value.trim(),
                color_code: document.getElementById('categoryColor').value,
                _token: document.querySelector('meta[name="csrf-token"]').content
            };
            
            if (isEditing) {
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
                    closeModal();
                    
                    // إعادة تحميل الصفحة بعد ثانيتين
                    setTimeout(() => {
                        location.reload();
                    }, 1500);
                    
                } else {
                    let errorMessage = result.message || 'حدث خطأ غير معروف';
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
                showAlert('حدث خطأ في الاتصال بالخادم', 'error');
                
                // إعادة تفعيل زر الحفظ
                saveButton.disabled = false;
                saveButton.innerHTML = 'حفظ';
            }
        }

        // حذف الصنف
        async function deleteCategory(categoryId) {
            // البحث عن اسم الصنف المحدد
            const row = document.querySelector(`tr[data-category-id="${categoryId}"]`);
            if (!row) {
                showAlert('لم يتم العثور على الصنف', 'error');
                return;
            }
            
            const categoryName = row.querySelector('.category-details h4').textContent;
            
            if (!confirm(`هل أنت متأكد من حذف الصنف "${categoryName}"؟\n\nملاحظة: لن تتمكن من استعادة البيانات المحذوفة.`)) {
                return;
            }
            
            try {
                const response = await fetch(`/categories/${categoryId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    }
                });
                
                const result = await response.json();
                
                if (result.success) {
                    showAlert(result.message);
                    row.remove();
                    
                    // تحديث العدد
                    updateCategoryCount();
                    
                    // إذا كان الجدول فارغاً
                    const tbody = document.getElementById('categoriesTableBody');
                    if (tbody.children.length === 0) {
                        tbody.innerHTML = `
                            <tr>
                                <td colspan="3" style="text-align: center; padding: 40px; color: #8e8e93;">
                                    <i class="fas fa-inbox" style="font-size: 48px; margin-bottom: 15px; opacity: 0.3;"></i>
                                    <p>لا توجد أصناف</p>
                                    <small>ابدأ بإضافة صنف جديد</small>
                                </td>
                            </tr>
                        `;
                    }
                } else {
                    showAlert(result.message, 'error');
                }
            } catch (error) {
                console.error('Error:', error);
                showAlert('حدث خطأ في حذف الصنف', 'error');
            }
        }

        // عرض منتجات الصنف
        function viewCategoryProducts(categoryId) {
            window.location.href = `/products?category=${categoryId}`;
        }

        // البحث في الأصناف
        async function searchCategories() {
            const searchTerm = document.getElementById('searchInput').value;
            
            try {
                const response = await fetch(`/categories/search?search=${encodeURIComponent(searchTerm)}`);
                const result = await response.json();
                
                if (result.success) {
                    document.getElementById('categoriesTableBody').innerHTML = result.html;
                    updateCategoryCount();
                }
            } catch (error) {
                console.error('Error:', error);
            }
        }

        // تحديث عدد الأصناف
        function updateCategoryCount() {
            const rows = document.querySelectorAll('#categoriesTableBody tr[data-category-id]');
            const count = rows.length;
            
            document.getElementById('categoryCount').textContent = `${count} صنف`;
            document.getElementById('totalCategories').textContent = count;
        }

        // تفعيل/تعطيل الشريط الجانبي على الجوال
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            if (sidebar) {
                sidebar.classList.toggle('active');
            }
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
            const modal = document.getElementById('categoryModal');
            if (event.target === modal) {
                closeModal();
            }
        });

        // إغلاق النافذة عند الضغط على زر ESC
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeModal();
            }
        });

        // التهيئة
        document.addEventListener('DOMContentLoaded', function() {
            updateCategoryCount();
            
            // إضافة حدث للنموذج لمنع الإرسال التقليدي
            document.getElementById('categoryForm').addEventListener('submit', function(e) {
                e.preventDefault();
                saveCategory();
            });
        });
    </script>
</body>
</html>

@php
    function getCategoryColor($id) {
        $colors = [
            'linear-gradient(135deg, #0066ff, #5ac8fa)',
            'linear-gradient(135deg, #34c759, #4cd964)',
            'linear-gradient(135deg, #ff9500, #ffcc00)',
            'linear-gradient(135deg, #5856d6, #af52de)',
            'linear-gradient(135deg, #ff2d55, #ff3b30)',
            'linear-gradient(135deg, #5ac8fa, #007aff)',
            'linear-gradient(135deg, #4cd964, #34c759)',
            'linear-gradient(135deg, #ffcc00, #ff9500)'
        ];
        return $colors[$id % count($colors)] ?? 'linear-gradient(135deg, #0066ff, #5ac8fa)';
    }
@endphp