@foreach($products as $product)
<tr data-status="{{ $product->status }}" data-category="{{ $product->category_id }}">
    <td>{{ $product->name }}</td>
    <td>{{ $product->quantity }}</td>
    <td>
        {{ $product->expiry_date ?? 'غير محدد' }}
    </td>
    <td>{{ number_format($product->inventory_value) }} ر.س</td>
    <td>
        <button onclick="editProduct({{ $product->id }})">تعديل</button>
    </td>
</tr>
@endforeach
