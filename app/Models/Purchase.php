<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;

    protected $fillable = [
        'supplier_id',
        'invoice_number',
        'purchase_date',
        'subtotal',
        'tax',
        'discount',
        'total',
        'payment_method',
        'status',
        'notes'
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function items()
    {
        return $this->hasMany(PurchaseItem::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'purchase_items')
                    ->withPivot('quantity', 'purchase_price', 'total')
                    ->withTimestamps();
    }
}