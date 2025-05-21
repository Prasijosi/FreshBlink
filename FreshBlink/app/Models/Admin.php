<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    use HasFactory;

    protected $primaryKey = 'user_id';

    protected $fillable = [
        'user_id',
        'admin_permission',
        'emergency_contact',
        'image',
    ];

    protected $casts = [
        'receives' => 'boolean',
    ];

    /**
     * Get the user associated with the admin.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
