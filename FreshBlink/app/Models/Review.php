<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id',
        'review_details',
        'review_date',
        'rating',
        'comment',
        'belongs_to',
        'is_given_by',
    ];

    protected $casts = [
        'review_date' => 'date',
        'rating' => 'integer',
        'belongs_to' => 'boolean',
        'is_given_by' => 'boolean',
    ];

    /**
     * Get the user that wrote the review.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the product that was reviewed.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
