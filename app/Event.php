<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'client_id', 'start', 'end', 'number', 'reserve', 'description', 'close', 'archived', 'users'
    ];

    public function client(){
        return $this->belongsTo('App\User', 'client_id');
    }

    public function event_users(){
        return $this->belongsToMany('App\User', 'user_event', 'event_id', 'user_id')->withPivot('status');
    }

    public function hasUser($user)
    {
    	return $this->event_users()->where('user_event.user_id', $user)->exists();
    }
}
