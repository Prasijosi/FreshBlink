<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'wishlist_name',
        'created_on',
        'updated_on',
    ];

    protected $casts = [
        'created_on' => 'date',
        'updated_on' => 'date',
    ];

    /**
     * Get the user that owns the wishlist.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the products in the wishlist.
     */
    public function products()
    {
        return $this->belongsToMany(Product::class, 'wishlist_products')
            ->withTimestamps();
    }
}
