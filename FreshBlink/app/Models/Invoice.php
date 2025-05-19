<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'payment_id',
        'invoice_id',
        'status',
        'date',
        'updated_date',
        'due_date',
        'is_received_by',
    ];

    protected $casts = [
        'date' => 'date',
        'updated_date' => 'date',
        'due_date' => 'date',
        'is_received_by' => 'boolean',
    ];

    /**
     * Get the payment associated with the invoice.
     */
    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }
}
