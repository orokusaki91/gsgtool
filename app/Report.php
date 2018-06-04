<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $fillable = [
        'date', 'description', 'user_id', 'client_id'
    ];

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function client(){
        return $this->belongsTo('App\User', 'client_id');
    }
}
