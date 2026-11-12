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
        @if(request()->has('search') || request()->has('category_id') || request()->has('status'))
            <small>جرب بحثاً أو فلترة مختلفة</small>
        @else
            <small>ابدأ بإضافة منتج جديد</small>
        @endif
    </td>
</tr>
@endforelse