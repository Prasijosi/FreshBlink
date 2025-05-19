<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    use HasFactory;

    protected $fillable = [
        'trader_id',
        'name',
        'description',
    ];

    public function trader()
    {
        return $this->belongsTo(User::class, 'trader_id');
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

}
