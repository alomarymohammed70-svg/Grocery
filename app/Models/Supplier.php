<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'phone',
        'email',
        'tax_number',
        'company',
        'address',
        'status',
        'payment_terms',
        'notes'
    ];

    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }
}