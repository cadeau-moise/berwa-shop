<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Shopkeeper extends Authenticatable
{
    use Notifiable;

    protected $primaryKey = 'ShopkeeperId';
    public $incrementing = true;

    protected $fillable = [
        'UserName',
        'Password',
    ];

    protected $hidden = [
        'Password',
        'remember_token',
    ];
}
