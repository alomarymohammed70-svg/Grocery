<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerPayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'sale_id',
        'amount',
        'payment_method',
        'payment_date',
        'notes'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'payment_date' => 'date'
    ];

    // علاقة مع العميل
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    // علاقة مع الفاتورة
    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }

    // الحصول على طريقة الدفع ككلمة
    public function getPaymentMethodTextAttribute()
    {
        $methods = [
            'cash' => 'نقداً',
            'transfer' => 'تحويل بنكي',
            'check' => 'شيك'
        ];
        
        return $methods[$this->payment_method] ?? $this->payment_method;
    }
}