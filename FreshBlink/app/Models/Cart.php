<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    const MAX_PRODUCTS = 20;

    protected $fillable = [
        'user_id',
        'total_price',
        'date_added',
        'updated_date',
    ];

    protected $casts = [
        'total_price' => 'decimal:2',
        'date_added' => 'date',
        'updated_date' => 'date',
    ];

    /**
     * Get the user that owns the cart.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the products in the cart.
     */
    public function products()
    {
        return $this->belongsToMany(Product::class, 'cart_products')
            ->withPivot('no_of_product', 'total_price')
            ->withTimestamps();
    }

    /**
     * Get the order associated with the cart.
     */
    public function order()
    {
        return $this->hasOne(Order::class);
    }

    /**
     * Check if the cart has reached its maximum product limit.
     */
    public function hasReachedLimit(): bool
    {
        return $this->products()->count() >= self::MAX_PRODUCTS;
    }

    /**
     * Get the remaining number of products that can be added to the cart.
     */
    public function getRemainingProductSlots(): int
    {
        return max(0, self::MAX_PRODUCTS - $this->products()->count());
    }
}
