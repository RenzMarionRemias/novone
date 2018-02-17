<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Measurement extends Model
{
    //
    protected $fillable = [
        'measurement_id', 'measurement_name',
    ];
}
