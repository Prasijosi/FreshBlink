<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'cart_id',
        'status',
        'total_order',
        'collection_slot_id',
        'order_id',
        'transaction_pin',
        'total_amount',
        'payment_method',
        'order_product',
        'no_of_product',
        'total_price',
        'order_type',
        'slot_date',
        'time_details',
        'required_slot',
        'is_placed',
        'is_received',
        'points_earned',
        'points_redeemed',
        'points_discount',
    ];

    protected $casts = [
        'total_order' => 'decimal:2',
        'total_price' => 'decimal:2',
        'points_discount' => 'decimal:2',
        'slot_date' => 'date',
        'time_details' => 'datetime',
        'required_slot' => 'boolean',
        'is_placed' => 'boolean',
        'is_received' => 'boolean',
        'points_earned' => 'integer',
        'points_redeemed' => 'integer',
    ];

    /**
     * Get the user that placed the order.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the cart associated with the order.
     */
    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    /**
     * Get the products in the order.
     */
    public function products()
    {
        return $this->belongsToMany(Product::class, 'order_products')
            ->withPivot('quantity', 'price')
            ->withTimestamps();
    }

    /**
     * Get the collection slot for the order.
     */
    public function collectionSlot()
    {
        return $this->hasOne(CollectionSlot::class);
    }

    /**
     * Get the payment for the order.
     */
    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    /**
     * Calculate final total after applying loyalty points discount
     */
    public function getFinalTotal()
    {
        $total = $this->total_order;
        if ($this->points_discount > 0) {
            $total -= $this->points_discount;
        }
        return max(0, $total);
    }
} 