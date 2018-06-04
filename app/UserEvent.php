<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserEvent extends Model
{
    protected $table = 'user_event';

    protected $fillable = [
        'user_id', 'event_id', 'status'
    ];

    public function user(){
        return $this->belongsTo('App\User', 'user_id');
    }

    public function event(){
        return $this->belongsTo('App\Event', 'event_id');
    }
}
