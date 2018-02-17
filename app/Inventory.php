<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    //
    protected $fillable = [
        'inventory_id', 'product_code', 'quantity','user_id'
    ];
}
