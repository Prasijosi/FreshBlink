<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'user_id',
        'shop_id',
        'product_category_id',
        'name',
        'price',
        'quantity',
        'description',
        'min_order',
        'max_order',
        'stock_no'
    ];

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'product_category_id');
    }
}
