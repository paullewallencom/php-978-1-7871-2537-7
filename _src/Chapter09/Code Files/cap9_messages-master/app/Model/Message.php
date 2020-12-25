<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Message extends Model {


    protected $table = 'messages';

    protected $fillable = ['sender_id', 'recipient_id', 'message'];

    public $timestamps  = false;


}