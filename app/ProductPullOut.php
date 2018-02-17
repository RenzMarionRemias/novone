<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductPullOut extends Model
{
    //
    protected $fillable = [
        'product_pull_out_id', 'product_code', 'quantity',
    ];
}
