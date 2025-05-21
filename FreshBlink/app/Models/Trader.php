<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Trader extends Model
{
    const TRADER_TYPES = [
        'GROCERY_STORE' => 'Grocery Store',
        'RESTAURANT' => 'Restaurant',
        'BAKERY' => 'Bakery',
        'BUTCHER_SHOP' => 'Butcher Shop',
        'SEAFOOD_MARKET' => 'Seafood Market'
    ];

    protected $primaryKey = 'user_id';
    protected $fillable = [
        'user_id',
        'trader_type',
        'trader_status',
        'image',
    ];

    protected $casts = [
        'status' => 'string',
        'trader_type' => 'string'
    ];

    // Relationships
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function shops(): HasMany
    {
        return $this->hasMany(Shop::class, 'trader_id', 'user_id');
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Get the display name for the trader type
     */
    public function getTraderTypeDisplayAttribute(): string
    {
        return self::TRADER_TYPES[$this->trader_type] ?? $this->trader_type;
    }
}
