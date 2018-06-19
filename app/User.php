<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'email', 'password', 'name', 'firstname', 'lastname', 'nickname', 'profile_picture', 'logo', 'general', 'service_number', 'birthdate', 'address_1', 'address_2', 'zip_code', 'city', 'country', 'canton', 'official_address', 'post_address', 'phone', 'mobile', 'contact', 'info', 'ahv', 'apartment', 'marital_status', 'wedding_date', 'nationality', 'work_permit', 'work_permit_date', 'acc_type', 'iban', 'number_bank', 'number_post', 'current_job', 'spoken_language', 'auto', 'driving_license', 'height', 'trousers_size', 't_shirt_size', 'shoe_size', 'users', 'archived', 'main_company', 'main_company_id', 'staff_type'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function roles()
    {
        return $this->belongsToMany('App\Role', 'user_role');
    }

    public function working_times()
    {
        return $this->hasMany('App\WorkingTime');
    }

    public function events(){
        return $this->belongsToMany('App\Event', 'user_event', 'event_id', 'user_id')->withPivot('status');
    }

    public function role()
    {
        $roles = $this->roles;
        return $roles[0];
    }

    public function hasRole($role)
    {
        if ($this->roles()->where('role_name', $role)->first()) {
            return true;
        }

        return false;
    }

    public function hasAnyRole($roles)
    {
        if (is_array($roles)) {
            foreach ($roles as $role) {
                if ($this->hasRole($role)) {
                    return true;
                }
            }
        } else {
            if ($this->hasRole($roles)) {
                return true;
            }
        }

        return false;
    }

    public function isAdmin()
    {
        return $this->hasRole('Admin') ? true : false;
    }

    public function isMainOrganizer()
    {
        return $this->hasRole('Main Organizer') ? true : false;
    }

    public function isDetective()
    {
        return $this->hasRole('Detective') ? true : false;
    }

    public function isSecurity()
    {
        return $this->hasRole('Security') ? true : false;
    }

    public function isGuard()
    {
        return $this->hasRole('Guard') ? true : false;
    }

    public function isClient()
    {
        return $this->hasRole('Client') ? true : false;
    }

    public function isPartner()
    {
        return $this->hasRole('Partner') ? true : false;
    }

    public function vacations(){
        return $this->hasMany('App\StaffVacation');
    }

    public function main(){
        return $this->belongsTo('App\User', 'main_company_id');
    }

    public function mainCompany(){
        if($this->main_company_id == 'main'){
            return 'Main';
        }else{
            return $this->main->name;
        }
    }

    public function staffType(){
        return $this->belongsTo('App\Role', 'staff_type');
    }

    public function scopeStaff($query)
    {
        return $query->whereHas('roles', function ($q) {
            $q->whereNotIn('roles.id', [6, 7]);
        });
    }

    public function scopeSecurity($query)
    {
        return $query->whereHas('roles', function ($q) {
            $q->whereNotIn('roles.id', [1, 6, 7]);
        });
    }

    public function scopeClients($query)
    {
        return $query->whereHas('roles', function ($q) {
            $q->where('roles.id', 6);
        });
    }

    public function scopeWithId($query, $user)
    {
        return $query->where('id', $user->id);
    }

    public function scopeDependingOnRole($query, $user)
    {
        if ($user->hasAnyRole(['Detective', 'Security', 'Guard'])) {
            return $query->withId($user);
        } elseif ($user->isMainOrganizer()) {
            $users = $user->users ? explode(',', $user->users) : [];
            return $query->withId($user)->orWhereIn('id', $users);
        }
        return $query;
    }

    public function scopeMainOrganizerUsers($query, $users)
    {
        $users = $users ? explode(',', $users) : [];
        return $query->whereIn('id', $users);
    }

    public function owns($related)
    {
        return $this->id == $related->user_id;
    }
}
