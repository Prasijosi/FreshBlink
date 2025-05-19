<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CollectionSlot extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'slot_date',
        'time_details',
        'is_made_for',
        'required_slot',
    ];

    protected $casts = [
        'slot_date' => 'date',
        'time_details' => 'datetime',
        'is_made_for' => 'boolean',
        'required_slot' => 'boolean',
    ];

    /**
     * Get the order associated with the collection slot.
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
