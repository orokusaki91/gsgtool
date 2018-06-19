<?php

namespace App\Http\Controllers;

use App\Http\Requests\StaffCreateRequest;
use App\Http\Requests\StaffDocumentCreateRequest;
use App\Http\Requests\StaffDocumentEditRequest;
use App\Http\Requests\StaffEditRequest;
use App\Http\Requests\StaffVacationRequest;
use Illuminate\Http\Request;
use App\User;
use App\Role;
use App\StaffDocument;
use App\StaffVacation;
use Countries;
use Vsmoraes\Pdf\Pdf;

class StaffController extends Controller
{
    private $pdf;

    public function __construct(Pdf $pdf){
        $this->pdf = $pdf;

        $this->middleware('auth');

        $this->middleware('check_if_admin', [
            'except' => [
                'vacation', 'vacationPersonal', 'vacationCreate', 'vacationStore'
            ]
        ]);

        $this->middleware('check_if_can_view_vacation', [
            'only' => [
                'vacation'
            ]
        ]);
    }

    public function index(){
        $users = User::where('archived', 0)->get();
        foreach($users as $k=>$user){
            if($user->isClient()){
                unset($users[$k]);
            }
        }
        return view('pages.staff.index', compact('users'));
    }

    public function create(){
        $user = null;
        $countries = Countries::lookup();
        $user_roles = Role::all();
        foreach($user_roles as $k=>$user_role){
            if($user_role->role_name == 'Client'){
                unset($user_roles[$k]);
            }
        }
        return view('pages.staff.create', compact('user', 'user_roles', 'countries'));
    }

    public function store(StaffCreateRequest $request){
        changeUserParametersAndPutInDB($request);
        return redirect()->route('staff')->with('success', __('messages.success_store_staff'));
    }

    public function archive($user_id){
        $user = User::findOrFail($user_id);
        $user->archived = 1;
        $user->save();
        return redirect()->route('staff')->with('success', __('messages.success_archive_staff'));
    }

    public function archived(){
        $users = User::where('archived', 1)->get();
        foreach($users as $k=>$user){
            if($user->isClient()){
                unset($users[$k]);
            }
        }
        return view('pages.staff.archived', compact('users'));
    }

    public function unArchive($user_id){
        $user = User::findOrFail($user_id);
        $user->archived = 0;
        $user->save();
        return redirect()->route('staff_archived')->with('success', __('messages.success_un_archive_staff'));
    }

    public function vacation(){
        $vacationConfirmed = StaffVacation::where('approved', 1)->get();
        $arr = null;
        foreach($vacationConfirmed as $k=>$vacation){
            if(Auth()->user()->isMainOrganizer()){
                $ids = explode(',', Auth()->user()->users);
                if(!in_array($vacation->user->id, $ids)) {
                    unset($vacationConfirmed[$k]);
                    continue;
                }
            }
            $vacation->start = date("Ymd", strtotime($vacation->start));
            $vacation->end = date("Ymd", strtotime($vacation->end));
            $vacation->firstname = $vacation->user->firstname;
            $vacation->lastname = $vacation->user->lastname;
            $arr[] = $vacation;
        }
        return view('pages.staff.vacation', compact('vacationConfirmed', 'arr'));
    }

    public function vacationPersonal(){
        $vacations = StaffVacation::where('user_id', Auth()->user()->id)->get();
        return view('pages.staff.vacation_personal', compact('vacations'));
    }

    public function vacationCreate(){
        $vacation = null;
        $users = User::where('archived', 0)->get();
        foreach($users as $k=>$user){
            if($user->isClient()){
                unset($users[$k]);
            }
        }
        return view('pages.staff.vacation_create', compact('vacation', 'users'));
    }

    public function vacationStore(StaffVacationRequest $request){
        $personal = false;
        if(!$request->user_id){
            $personal = true;
            $request->merge(['user_id' => Auth()->user()->id]);
        }
        $request->merge(['start' => date('Y-m-d', strtotime($request->start))]);
        $request->merge(['end' => date('Y-m-d', strtotime($request->end))]);
        if(Auth()->user()->isAdmin()) {
            $request->merge(['approved' => 1]);
        }else{
            $request->merge(['approved' => 0]);
        }
        StaffVacation::create($request->all());
        if($personal){
            return redirect()->route('staff_vacation_personal')->with('success', __('messages.success_create_vacation'));
        }
        return redirect()->route('staff_vacation')->with('success', __('messages.success_create_vacation'));
    }

    public function vacationRequested(){
        $vacationRequested = StaffVacation::where('approved', 0)->get();
        return view('pages.staff.vacation_requested', compact('vacationRequested', 'arr'));
    }

    public function vacationRejected(){
        $vacationRejected = StaffVacation::where('approved', 2)->get();
        return view('pages.staff.vacation_rejected', compact('vacationRejected', 'arr'));
    }

    public function vacationApprove($vacation_id){
        $vacation = StaffVacation::findOrFail($vacation_id);
        $vacation->approved = 1;
        $vacation->save();
        return redirect()->route('staff_vacation_requested', ['vacation_id' => $vacation->id])->with('success', __('messages.success_approve_vacation'));
    }

    public function vacationReject($vacation_id){
        $vacation = StaffVacation::findOrFail($vacation_id);
        $vacation->approved = 2;
        $vacation->save();
        return redirect()->route('staff_vacation_requested', ['vacation_id' => $vacation->id])->with('success', __('messages.success_reject_vacation'));
    }

    public function vacationEdit($vacation_id){
        $vacation = StaffVacation::findOrFail($vacation_id);
        $users = User::where('archived', 0)->get();
        foreach($users as $k=>$user){
            if($user->isClient()){
                unset($users[$k]);
            }
        }
        return view('pages.staff.vacation_edit', compact('vacation', 'users'));
    }

    public function vacationUpdate(StaffVacationRequest $request, $vacation_id){
        $vacation = StaffVacation::findOrFail($vacation_id);
        $request->merge(['start' => date('Y-m-d', strtotime($request->start))]);
        $request->merge(['end' => date('Y-m-d', strtotime($request->end))]);
        $vacation->update($request->all());
        return redirect()->route('staff_vacation_edit', ['vacation_id' => $vacation->id])->with('success', __('messages.success_update_vacation'));
    }

    public function vacationDelete($vacation_id){
        $vacation = StaffVacation::findOrFail($vacation_id);
        $vacation->delete();
        return redirect()->route('staff_vacation')->with('success', __('messages.success_delete_vacation'));
    }

    public function pdf(){
        $users = User::where('archived', 0)->get();
        foreach($users as $k=>$user){
            if($user->isClient()){
                unset($users[$k]);
            }
        }
        $html = view('pages.staff.pdf', compact('users'))->render();
        return $this->pdf->load($html)->filename(__('headings.staff_list'))->show();
    }

    public function show(Request $request){
        $user = User::findOrFail($request->user_id);
        $countries = Countries::lookup();
        $maritalStatus = getArray('marital_status');
        $workPermit = getArray('work_permit');
        $accType = getArray('acc_type');
        $currentJob = getArray('current_job');
        $spokenLanguage = getArray('spoken_language');
        $defaultSelect = getArray('default_select');
        $trousersSize = getArray('trousers_size');
        $TShirtSize = getArray('t_shirt_size');
        $canton = getArray('canton');
        $pdfUrl = route('staff_show_pdf', ['user_id' => $request->user_id]);
        ob_start();
        require base_path(). '/resources/views/pages/staff/_show_modal.php';
        $html = ob_get_clean();
        return response()->json(['html' => $html]);
    }

    public function showPdf($user_id){
        $user = User::findOrFail($user_id);
        $country = Countries::lookup();
        $spokenLanguage = getArray('spoken_language');
        $defaultSelect = getArray('default_select');
        $html = view('pages.staff.show_pdf', compact('user', 'country', 'spokenLanguage', 'defaultSelect'))->render();
        
        $options = $this->pdf->getOptions();
        $options->setIsRemoteEnabled(true);

        return $this->pdf->setOptions($options)->load($html)->filename($user->firstname. ' '. $user->lastname)->show();
    }

    public function edit($user_id){
        $countries = Countries::lookup();
        $user_roles = Role::all();
        foreach($user_roles as $k=>$user_role){
            if($user_role->role_name == 'Client'){
                unset($user_roles[$k]);
            }
        }
        $users = User::where('archived', 0)->get();
        foreach($users as $k=>$user){
            if($user->isClient()){
                unset($users[$k]);
            }
        }
        $user = User::findOrFail($user_id);
        return view('pages.staff.edit', compact('user', 'user_roles', 'countries', 'users'));
    }

    public function update(StaffEditRequest $request, $user_id){
        $user = User::findOrFail($user_id);
        changeUserParametersAndPutInDB($request, $user);
        return redirect()->route('staff')->with('success', __('messages.success_update_staff'));
    }

    public function delete($user_id){
        $user = User::findOrFail($user_id);
        $user->delete();
        return redirect()->route('staff')->with('success', __('messages.success_delete_staff'));
    }
}
