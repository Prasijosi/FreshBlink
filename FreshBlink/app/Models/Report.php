<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id',
        'report_details',
        'is_of',
        'is_received_by',
    ];

    protected $casts = [
        'is_of' => 'boolean',
        'is_received_by' => 'boolean',
    ];

    /**
     * Get the user that submitted the report.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the product being reported.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
