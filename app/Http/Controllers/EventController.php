<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use App\Role;
use App\User;
use App\Event;
use Carbon\Carbon;
use App\UserEvent;
use App\WorkingTime;
use Illuminate\Http\Request;
use App\Http\Requests\EventCreateRequest;
use App\Http\Requests\EventUpdateRequest;

class EventController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){
        $user = Auth::user();
        $userRole = $user->role()->id;
        if ($user->hasRole('Admin')) {
            $events = Event::where('close', 0)->get();
        } else {
            $events = Event::where('close', 0)->whereRaw("find_in_set({$userRole}, users)")->get();
        }
        return view('pages.event.index', compact('events', 'user'));
    }

    public function create(){
        $event = null;
        $user_roles = Role::security()->get();
        $clients = User::where('archived', 0)->clients()->get();
        return view('pages.event.create', compact('event', 'user_roles', 'clients'));
    }

    public function store(EventCreateRequest $request){
        $request->merge(['users' => getSelectedUsers($request)]);
        if($request->users == ""){
            return redirect()->route('event_create')->with('error', __('messages.empty_staff'));
        }
        if($request->start){
            $request->merge(['start' => Carbon::parse($request->start)]);
        }
        if($request->end){
            $request->merge(['end' => Carbon::parse($request->end)]);
        }
        Event::create($request->all());
        return redirect()->route('event')->with('success', __('messages.success_store_event'));
    }

    public function old(){
        $events = Event::where('close', 1)->where('archive', 0)->get();
        return view('pages.event.old', compact('events'));
    }

    public function archive($event_id){
        $event = Event::find($event_id);
        $event->archive = 1;
        $event->save();
        return redirect()->route('event_old')->with('success', __('messages.success_archive_event'));
    }

    public function un_archive($event_id){
        $event = Event::find($event_id);
        $event->archive = 0;
        $event->save();
        return redirect()->route('event_archived')->with('success', __('messages.success_un_archive_event'));
    }

    public function archived(){
        $events = Event::where('archive', 1)->get();
        return view('pages.event.archived', compact('events'));
    }

    public function users($event_id){
        $event = Event::with('event_users')->findOrFail($event_id);
        return view('pages.event.users', compact('user_events', 'event'));
    }

    public function signUpUser($event_id) 
    {
        $user = Auth::user();
        $userRole = $user->role()->id;
        $event = Event::where('close', 0)->whereRaw("find_in_set({$userRole}, users)")->findOrFail($event_id);
        $event->event_users()->sync([$user->id => ['status' => 2]], false);
        return redirect()->route('event')->with('success', 'Success');
    }

    public function signOutUser($event_id) 
    {
        $user = Auth::user();
        $userRole = $user->role()->id;
        $event = Event::where('close', 0)->whereRaw("find_in_set({$userRole}, users)")->findOrFail($event_id);
        $event->event_users()->detach($user->id);
        return redirect()->route('event')->with('success', 'Success');
    }

    public function user_accept($event_id, $user_id){
        $user = User::findOrFail($user_id);
        $event = Event::with('event_users')->findOrFail($event_id);
        $event->event_users()->sync([$user->id => ['status' => 1]], false);
        return redirect()->route('event_users', ['event_id' => $event->id])->with('success', __('messages.success_accept_user_event'));
    }

    public function user_reserve($event_id, $user_id){
        $user = User::findOrFail($user_id);
        $event = Event::with('event_users')->findOrFail($event_id);
        $event->event_users()->sync([$user->id => ['status' => 2]], false);
        return redirect()->route('event_users', ['event_id' => $event->id])->with('success', __('messages.success_reserve_user_event'));
    }

    public function user_delete($event_id, $user_id){
        $user = User::findOrFail($user_id);
        $event = Event::with('event_users')->findOrFail($event_id);
        $event->event_users()->detach($user->id);
        return redirect()->route('event_users', ['event_id' => $event->id])->with('success', __('messages.success_delete_user_event'));
    }

    public function edit($event_id){
        $event = Event::find($event_id);
        $user_roles = Role::all();
        foreach($user_roles as $k=>$user_role){
            if($user_role->role_name == 'Admin' || $user_role->role_name == 'Main Organizer' || $user_role->role_name == 'Client' || $user_role->role_name == 'Partner'){
                unset($user_roles[$k]);
            }
        }
        $clients = User::where('archived', 0)->get();
        foreach($clients as $k=>$user){
            if(!$user->isClient()){
                unset($clients[$k]);
            }
        }
        return view('pages.event.edit', compact('event', 'user_roles', 'clients'));
    }

    public function update(EventUpdateRequest $request, $event_id){
        $event = Event::findOrFail($event_id);
        if($request->start){
            $request->merge(['start' => Carbon::parse($request->start)]);
        }
        if($request->end){
            $request->merge(['end' => Carbon::parse($request->end)]);
        }
        $event->update($request->all());
        return redirect()->route('event')->with('success', __('messages.success_update_event'));
    }

    public function close($event_id){
        $event = Event::findOrFail($event_id);
        $event->close = 1;
        $event->save();

        foreach ($event->event_users as $user) {
            $workingTime = new WorkingTime;
            $workingTime->client_id = $event->client->id;
            $workingTime->check_in = Carbon::parse($event->start);
            $workingTime->check_out = Carbon::parse($event->end);
            $workingTime->pause = 1;

            $user->working_times()->save($workingTime);
        }

        return redirect()->route('event')->with('success', __('messages.success_close_event'));
    }

    public function delete($event_id){
        $event = Event::find($event_id);
        $event->delete();
        return redirect()->route('event')->with('success', __('messages.success_delete_event'));
    }

    public function createUser($event_id)
    {
        $event = Event::with('event_users')->findOrFail($event_id);
        $users = User::whereHas('roles', function($query) {
            $query->where('role_name', '!=','admin');
        })->get();
        return view('pages.event.users_create', compact('users', 'event'));
    }

    public function storeUser(Request $request, $event_id, $user_id)
    {
        $user = User::findOrFail($user_id);
        $event = Event::with('event_users')->findOrFail($event_id);
        $event->event_users()->sync([$user->id => ['status' => 3]], false);
        return redirect()->back();
    }
}
