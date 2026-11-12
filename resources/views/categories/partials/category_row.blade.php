@php
    // ألوان جاهزة (Fallback) إذا ما كان للصنف لون محفوظ في قاعدة البيانات
    $colors = [
        'linear-gradient(135deg, #0066ff, #5ac8fa)',
        'linear-gradient(135deg, #34c759, #4cd964)',
        'linear-gradient(135deg, #ff9500, #ffcc00)',
        'linear-gradient(135deg, #5856d6, #af52de)',
        'linear-gradient(135deg, #ff2d55, #ff3b30)',
        'linear-gradient(135deg, #5ac8fa, #007aff)',
        'linear-gradient(135deg, #4cd964, #34c759)',
        'linear-gradient(135deg, #ffcc00, #ff9500)',
    ];

    $fallbackColor = $colors[$category->id % count($colors)] ?? 'linear-gradient(135deg, #0066ff, #5ac8fa)';

    // إذا موجود color_code في قاعدة البيانات استخدمه، إذا لا استخدم fallback
    $bgColor = $category->color_code ?? $fallbackColor;
@endphp

<tr>
    <td>
        <div class="category-info">
            <div class="category-icon" style="background: {{ $bgColor }};">
                <i class="fas fa-tag"></i>
            </div>

            <div class="category-details">
                <h4>{{ $category->name }}</h4>
                <p>{{ $category->description ?? 'تصنيف عام للمنتجات' }}</p>
            </div>
        </div>
    </td>

    <td>
        <span class="products-count">
            {{ $category->products_count ?? 0 }} منتج
        </span>
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