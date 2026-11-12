<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'phone',
        'email',
        'address',
        'notes',
        'balance'
    ];

    protected $casts = [
        'balance' => 'decimal:2',
    ];

    // علاقة مع المبيعات
    public function sales()
    {
        return $this->hasMany(Sale::class);
    }

    // علاقة مع المدفوعات
    public function payments()
    {
        return $this->hasMany(CustomerPayment::class);
    }

    // فواتير الدين (المبيعات بالدين)
    public function creditSales()
    {
        return $this->sales()->where('sale_type', 'credit');
    }

    // فواتير المدفوعة
    public function paidSales()
    {
        return $this->sales()->where('payment_status', 'paid');
    }

    // فواتير غير المدفوعة
    public function unpaidSales()
    {
        return $this->sales()->where('payment_status', '!=', 'paid');
    }

    // تحديث رصيد العميل
    public function updateBalance()
    {
        $totalCredit = $this->creditSales()->sum('total');
        $totalPaid = $this->payments()->sum('amount');
        $this->balance = $totalCredit - $totalPaid;
        $this->save();
    }

    // الحصول على المدينين (العملاء الذين لديهم ديون)
    public static function getDebtors()
    {
        return self::where('balance', '>', 0)->get();
    }

    // الحصول على العملاء بدون ديون
    public static function getNonDebtors()
    {
        return self::where('balance', '<=', 0)->get();
    }
}