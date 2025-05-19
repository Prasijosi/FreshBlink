<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'payment_id',
        'user_id',
        'total_amount',
        'payment_method',
        'transaction_pin',
        'is_made_by',
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
        'is_made_by' => 'boolean',
    ];

    /**
     * Get the order associated with the payment.
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Get the invoice for the payment.
     */
    public function invoice()
    {
        return $this->hasOne(Invoice::class);
    }
}
