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
        'gives',
        'places',
        'receives',
    ];

    protected $casts = [
        'loyalty_points' => 'integer',
        'gives' => 'boolean',
        'places' => 'boolean',
        'receives' => 'boolean',
    ];

    /**
     * Get the user associated with the customer.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
