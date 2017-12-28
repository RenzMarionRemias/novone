<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    //
    protected $fillable = [
        'client_id', 'email', 'lastname',
        'firstname','middlename','gender',
        'gender','birthdate','business_name',
        'business_address','contact_no','business_contact'
    ];
}
