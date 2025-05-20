<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_category_name',
        'description',
        'product_category_image',
        'created_on',
        'updated_on',
    ];

    protected $casts = [
        'created_on' => 'date',
        'updated_on' => 'date',
    ];

    /**
     * Get the products in this category.
     */
    public function products()
    {
        return $this->hasMany(Product::class, 'product_category_id');
    }
}
