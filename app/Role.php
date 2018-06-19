<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = [
        'role_name'
    ];

    public function users()
    {
        return $this->belongsToMany('App\User', 'user_role');
    }

    public function permissions()
    {
    	return $this->belongsToMany(Permission::class);
    }

    public function givePermissionTo(Permission $permission)
    {
        return $this->permissions()->save($permission);
    }

    public function scopeSecurity($query)
    {
        return $query->whereNotIn('id', [1, 6, 7]);
    }
}
