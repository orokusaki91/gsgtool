<?php

namespace App\Http\Controllers;

use Gate;
use Auth;
use App\User;
use Carbon\Carbon;
use App\WorkingTime;
use Illuminate\Http\Request;
use App\Http\Requests\WorkingTimeRequest;

class WorkingTimeController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index()
    {
        $authUser = Auth::user();
        $workingTimes = WorkingTime::with('user', 'client')->dependingOnRole($authUser)->get();
                
        return view('pages.working_time.index', compact('workingTimes'));
    }

    public function create()
    {
        $workingTime = null;
        $authUser = Auth::user();
        $users = User::staff()->dependingOnRole($authUser)->get();
        $clients = User::clients()->get();

        return view('pages.working_time.create', compact('workingTime', 'users', 'clients'));
    }

    public function store(WorkingTimeRequest $request)
    {
        if (Gate::denies('store_wt')) {
            return response('Insufficient Permissions', 401);
        }

        $authUser = Auth::user();        
        $client = User::clients()->findOrFail($request->client_id);
        $user = User::staff()->dependingOnRole($authUser)->findOrFail($request->user_id);

        $workingTime = new WorkingTime;
        $workingTime->client_id = $client->id;
        $workingTime->check_in = date('Y-m-d H:i:s', strtotime($request->check_in));
        $workingTime->check_out = date('Y-m-d H:i:s', strtotime($request->check_out));
        $workingTime->comment = $request->comment;
        $workingTime->pause = $request->pause;

        $user->working_times()->save($workingTime);

        return redirect()->route('working_time')->with('success', 'Success');
    }

    public function edit(WorkingTime $workingTime)
    {
        $authUser = Auth::user();
        $users = User::staff()->dependingOnRole($authUser)->get();
        $clients = User::clients()->get();

        if  (Gate::denies('edit_wt') && 
                !$authUser->owns($workingTime) && 
                !in_array($workingTime->user_id, getMainOrganizerUsers($authUser))
            ) {
            return response('Insufficient Permissions', 401);
        }

        return view('pages.working_time.edit', compact('workingTime', 'users', 'clients'));
    }

    public function update(WorkingTimeRequest $request, WorkingTime $workingTime)
    {
        $authUser = Auth::user();
        $client = User::clients()->findOrFail($request->client_id);

        if  (Gate::denies('update_wt') && !$authUser->owns($workingTime)) {
            return response('Insufficient Permissions', 401);
        }

        $workingTime->client_id = $client->id;
        $workingTime->check_in = date('Y-m-d H:i:s', strtotime($request->check_in));
        $workingTime->check_out = date('Y-m-d H:i:s', strtotime($request->check_out));
        $workingTime->comment = $request->comment;
        $workingTime->pause = $request->pause;
        $workingTime->save();

        return redirect()->route('working_time')->with('success', 'Success');
    }

    public function delete(WorkingTime $workingTime)
    {
        $authUser = Auth::user();
        if  (Gate::denies('delete_wt', $workingTime) && 
                !in_array($workingTime->user_id, getMainOrganizerUsers($authUser))
            ) {
            return response('Insufficient Permissions', 401);
        }

        $workingTime->delete();

        return redirect()->route('working_time')->with('success', 'Success');
    }
}
