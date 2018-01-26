<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    //
    protected $fillable = [
        'stock_id', 'product_code', 'pcs_per_bundle','total_quantity','user_id'
    ];
}
