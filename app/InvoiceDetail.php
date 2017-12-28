<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InvoiceDetail extends Model
{
    //
    protected $fillable = [
        'invoice_id','product_code','purchase_quantity','purchase_amount'
    ];
}
