<?php

namespace App\Http\Controllers\Auth;

use App\Http\Requests\StaffEditRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Role;
use App\User;
use Countries;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        $this->middleware('not_client');
    }

    public function edit(){
        $user = Auth()->user();
        $countries = Countries::lookup();
        $user_roles = Role::all();
        foreach($user_roles as $k=>$user_role){
            if($user_role->role_name == 'Client'){
                unset($user_roles[$k]);
            }
        }
        $users = User::where('archived', 0)->get();
        return view('auth.edit', compact('user', 'user_roles', 'countries', 'users'));
    }

    public function update(StaffEditRequest $request){
        $user = Auth()->user();
        changeUserParametersAndPutInDB($request, $user);
        $request->flash();
        return redirect()->back()->with('success', __('messages.success_update_profile'));
    }
}
