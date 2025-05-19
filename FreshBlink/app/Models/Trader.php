<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Model;

use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Trader extends Authenticatable
{
   use Notifiable;

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
}
