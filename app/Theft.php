<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Theft extends Model
{
    protected $fillable = [
        'date', 'firstname', 'lastname', 'birthdate', 'nationality', 'gender', 'goods', 'price', 'damaged', 'description', 'user_id', 'client_id'
    ];

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function client(){
        return $this->belongsTo('App\User', 'client_id');
    }
}
