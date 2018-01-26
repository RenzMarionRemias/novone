<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    //
    protected $fillable = [
        'invoice_id','client_id','payment_type','invoice_total_amount','invoice_payment'
    ];
}
