<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Model;

use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Trader extends Authenticatable
{
   use Notifiable;

   const TRADER_TYPES = [
    'GROCERY_STORE' => 'Grocery Store',
    'RESTAURANT' => 'Restaurant',
    'BAKERY' => 'Bakery',
    'BUTCHER_SHOP' => 'Butcher Shop',
    'SEAFOOD_MARKET' => 'Seafood Market'
   ];

   protected $fillable = [
    'name',
    'email',
    'password',
    'phone',
    'status',
    'trader_type'
   ];

   protected $hidden = [
    'password',
   ];

   protected $casts = [
    'email_verified_at' => 'datetime',
    'password' => 'hashed',
   ];

   /**
    * Get the display name for the trader type
    */
   public function getTraderTypeDisplayAttribute()
   {
       return self::TRADER_TYPES[$this->trader_type] ?? $this->trader_type;
   }
}
