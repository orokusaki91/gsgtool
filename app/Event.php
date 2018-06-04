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
}
