<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WorkingTime extends Model
{
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function client()
    {
        return $this->belongsTo('App\User', 'client_id');
    }

    public function scopeDependingOnRole($query, $user)
    {
        if ($user->hasAnyRole(['Detective', 'Security', 'Guard'])) {
            return 	$query->whereHas('user', function ($q) use ($user) {
                    	$q->withId($user);
                    });
        } elseif ($user->isMainOrganizer()) {
            $users = $user->users ? explode(',', $user->users) : [];
            return 	$query->whereHas('user', function ($q) use ($user, $users) {
                    	$q->withId($user)->orWhereIn('id', $users);
                    });
        }
        return $query;
    }
}
