<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'category_id',
        'barcode',
        'purchase_price',
        'sale_price',
        'quantity',
        'minimum_quantity',
        'expiry_date',
        'description',
        'image',
        'status'
    ];

    protected $casts = [
        'purchase_price' => 'decimal:2',
        'sale_price' => 'decimal:2',
        'expiry_date' => 'date',
        'quantity' => 'integer',
        'minimum_quantity' => 'integer'
    ];

    protected $appends = ['quantity_status', 'expiry_status'];

    // علاقة مع الصنف
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // علاقة مع فواتير البيع
    public function saleItems()
    {
        return $this->hasMany(SaleItem::class);
    }

    // علاقة مع مشتريات
    public function purchaseItems()
    {
        return $this->hasMany(PurchaseItem::class);
    }

    // Accessor لحالة الكمية
    public function getQuantityStatusAttribute()
    {
        if ($this->quantity <= $this->minimum_quantity) {
            return 'low';
        } elseif ($this->quantity <= ($this->minimum_quantity * 2)) {
            return 'medium';
        } else {
            return 'high';
        }
    }

    // Accessor لحالة الصلاحية
    public function getExpiryStatusAttribute()
    {
        if (!$this->expiry_date) {
            return 'safe';
        }

        $today = now();
        $expiryDate = \Carbon\Carbon::parse($this->expiry_date);
        $diffDays = $today->diffInDays($expiryDate, false);

        if ($diffDays < 0) {
            return 'expired';
        } elseif ($diffDays <= 7) {
            return 'danger';
        } elseif ($diffDays <= 30) {
            return 'warning';
        } else {
            return 'safe';
        }
    }

    // Accessor للربح
    public function getProfitAttribute()
    {
        return $this->sale_price - $this->purchase_price;
    }

    // Accessor لإجمالي القيمة
    public function getTotalValueAttribute()
    {
        return $this->quantity * $this->purchase_price;
    }
}