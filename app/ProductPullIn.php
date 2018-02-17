<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductPullIn extends Model
{
    //
    protected $fillable = [
        'product_pull_in_id', 'product_code', 'quantity',
    ];
}
