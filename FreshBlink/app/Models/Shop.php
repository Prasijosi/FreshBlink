<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    use HasFactory;

    protected $fillable = [
        'trader_id',
        'shop_name',
        'description',
        'address',
        'email',
        'created_on',   
    ];

    public function trader(){
        return $this->belongsTo(Trader::class);
    }
}
