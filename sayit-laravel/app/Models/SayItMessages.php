<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SayItMessages extends Model
{
    protected $table= 'sayit_messages';
    protected $primaryKey= 'message_id';
    protected $timeStamps= FALSE;
}
