<?php

namespace App\Http\Controllers;

use App\Http\Requests\EventCreateRequest;
use App\Http\Requests\EventUpdateRequest;
use Illuminate\Http\Request;
use App\Event;
use App\Role;
use App\User;
use App\UserEvent;

class EventController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){
        $events = Event::where('close', 0)->get();
        return view('pages.event.index', compact('events'));
    }

    public function create(){
        $event = null;
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
        return view('pages.event.create', compact('event', 'user_roles', 'clients'));
    }

    public function store(EventCreateRequest $request){
        $request->merge(['users' => getSelectedUsers($request)]);
        if($request->users == ""){
            return redirect()->route('event_create')->with('error', __('messages.empty_staff'));
        }
        if($request->start){
            $request->merge(['start' => date('Y-m-d H:i:s', strtotime($request->start))]);
        }
        if($request->end){
            $request->merge(['end' => date('Y-m-d H:i:s', strtotime($request->end))]);
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
        $user_events = UserEvent::where('event_id', $event_id)->get();
        return view('pages.event.users', compact('user_events'));
    }

    public function user_accept($event_user_id){
        $user_event = UserEvent::find($event_user_id);
        $user_event->status = 1;
        $user_event->save();
        return redirect()->route('event_users', ['event_id' => $user_event->event_id])->with('success', __('messages.success_accept_user_event'));
    }

    public function user_reserve($event_user_id){
        $user_event = UserEvent::find($event_user_id);
        $user_event->status = 2;
        $user_event->save();
        return redirect()->route('event_users', ['event_id' => $user_event->event_id])->with('success', __('messages.success_reserve_user_event'));
    }

    public function user_delete($event_user_id){
        $user_event = UserEvent::find($event_user_id);
        $user_event->delete();
        return redirect()->route('event_users', ['event_id' => $user_event->event_id])->with('success', __('messages.success_delete_user_event'));
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
        $event = Event::find($event_id);
        if($request->start){
            $request->merge(['start' => date('Y-m-d H:i:s', strtotime($request->start))]);
        }
        if($request->end){
            $request->merge(['end' => date('Y-m-d H:i:s', strtotime($request->end))]);
        }
        $event->update($request->all());
        return redirect()->route('event')->with('success', __('messages.success_update_event'));
    }

    public function close($event_id){
        $event = Event::find($event_id);
        $event->close = 1;
        $event->save();
        return redirect()->route('event')->with('success', __('messages.success_close_event'));
    }

    public function delete($event_id){
        $event = Event::find($event_id);
        $event->delete();
        return redirect()->route('event')->with('success', __('messages.success_delete_event'));
    }
}
