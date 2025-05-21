<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'shop_id',
        'product_category_id',
        'product_name',
        'description',
        'price',
        'quantity',
        'min_order',
        'max_order',
        'product_image',
        'stock_no',
        'allergy_info',
        'allergen_free',
        'may_contain_allergens',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'allergen_free' => 'boolean',
        'may_contain_allergens' => 'boolean',
    ];

    /**
     * Get the shop that owns the product.
     */
    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }

    /**
     * Get the user that created the product.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the category that the product belongs to.
     */
    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'product_category_id');
    }

    /**
     * Get the reviews for the product.
     */
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    /**
     * Get the wishlists that contain this product.
     */
    public function wishlists()
    {
        return $this->belongsToMany(Wishlist::class, 'wishlist_products');
    }

    /**
     * Get the orders that contain this product.
     */
    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_products')
            ->withPivot('quantity', 'price')
            ->withTimestamps();
    }

    /**
     * Get the carts that contain this product.
     */
    public function carts()
    {
        return $this->belongsToMany(Cart::class, 'cart_products')
            ->withPivot('no_of_product', 'total_price')
            ->withTimestamps();
    }
}
