<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Defect extends Model
{
    //
    protected $fillable = [
        'defect_id', 'product_code', 'defect_type','user_id'
    ];
}
