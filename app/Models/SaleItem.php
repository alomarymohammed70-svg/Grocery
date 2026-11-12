<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SaleItem extends Model
{
    protected $fillable = [
        'sale_id',
        'product_id',
        'quantity',
        'price',
        'total',
    ];

    public function sale(): BelongsTo
    {
        return $this->belongsTo(Sale::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
    
    // دالة لحساب الإجمالي تلقائياً
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($saleItem) {
            if (empty($saleItem->total)) {
                $saleItem->total = $saleItem->quantity * $saleItem->price;
            }
        });
        
        static::updating(function ($saleItem) {
            $saleItem->total = $saleItem->quantity * $saleItem->price;
        });
    }
}