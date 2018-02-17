<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    //
    protected $fillable = [
        'message_id', 'sender', 'recipient','message'
    ];
}
