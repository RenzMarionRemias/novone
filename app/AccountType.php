<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AccountType extends Model
{
    //
    protected $fillable = [
        'account_type_id', 'account_type_name',
    ];
}
