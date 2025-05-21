<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Product;

class Shop extends Model
{
    use HasFactory;

    protected $fillable = [
        'trader_id',
        'name',
        'description',
        'address',
        'phone',
        'email',
        'opening_hours',
        'closing_hours',
        'status',
        'image',
    ];

    protected $casts = [
        'status' => 'string'
    ];

    public function trader(): BelongsTo
    {
        return $this->belongsTo(Trader::class, 'trader_id', 'user_id');
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function getFullAddressAttribute(): string
    {
        return $this->address;
    }

    public function getOperatingHoursAttribute(): string
    {
        return "{$this->opening_hours} - {$this->closing_hours}";
    }
}

