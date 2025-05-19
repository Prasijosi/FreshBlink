<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

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
}
