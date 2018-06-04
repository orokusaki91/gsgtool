<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StaffVacation extends Model
{
    protected $fillable = [
        'type', 'approved', 'start', 'end', 'user_id'
    ];

    public function user(){
        return $this->belongsTo('App\User');
    }
}
