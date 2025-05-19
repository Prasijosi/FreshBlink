<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'notification_preference',
        'loyalty_points',
        'favorite_shop',
    ];

    protected $casts = [
        'loyalty_points' => 'integer',
    ];

    /**
     * Get the user associated with the customer.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
