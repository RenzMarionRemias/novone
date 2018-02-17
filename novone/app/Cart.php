<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    //
    protected $fillable = [
        'cart_id', 'product_code', 'quantity','user_id',
    ];
}
