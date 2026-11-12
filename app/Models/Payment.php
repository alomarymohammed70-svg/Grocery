<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'sale_id',
        'amount',
        'payment_method',
        'notes',
        'payment_date'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'payment_date' => 'date'
    ];

    // العلاقة مع العميل
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    // العلاقة مع الفاتورة
    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }
}