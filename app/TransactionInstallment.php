<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TransactionInstallment extends Model
{
    //
    protected $fillable = [
        'invoice_id', 'payment_date', 'amount_paid','payment_status'
    ];
}
