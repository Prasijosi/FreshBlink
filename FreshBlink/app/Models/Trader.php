<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Model;

use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Trader extends Authenticatable
{
   use Notifiable;

   protected $fillable =[
    'name','email','password','phone_number','status','trader_type',
   ];

   protected $hidden=[
    'password',
   ];

   public function shop(){
    return $this->hasMany(Shop::class);
   }  

}
