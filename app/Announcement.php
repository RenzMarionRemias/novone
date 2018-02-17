<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Announcement extends Model {
    protected $fillable = [
        'announcement_id', 'content_title','content_description','user_id'
    ];
}
