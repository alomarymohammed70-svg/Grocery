<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'color_code'
    ];

    protected $appends = ['products_count'];

    // علاقة مع المنتجات
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    // عدد المنتجات المرتبطة
    public function getProductsCountAttribute()
    {
        return $this->products()->count();
    }
}