<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClientRequest;
use App\UserRole;
use Illuminate\Http\Request;
use App\User;
use App\Role;
use Vsmoraes\Pdf\Pdf;

class ClientController extends Controller
{
    private $pdf;

    public function __construct(Pdf $pdf){
        $this->pdf = $pdf;

        $this->middleware('auth');

        $this->middleware('check_if_admin');
    }
    public function index(){
        $clients = User::where('archived', 0)->get();
        foreach($clients as $k=>$client){
            if(!$client->isClient()){
                unset($clients[$k]);
            }
        }
        return view('pages.client.index', compact('clients'));
    }

    public function create(){
        $client = null;
        $staff_types = Role::all();
        foreach($staff_types as $k=>$staff_type){
            if($staff_type->role_name == 'Client' || $staff_type->role_name == 'Partner'){
                unset($staff_types[$k]);
            }
        }
        $main_companies = User::where('archived', 0)->get();
        $companies = ['main' => __('labels.main_company')];
        foreach($main_companies as $k=>$main_company){
            if($main_company->isClient() && $main_company->main_company == 1){
                $companies[$main_company->id] = $main_company->name;
            }
        }
        return view('pages.client.create', compact('client', 'staff_types', 'companies'));
    }

    public function store(ClientRequest $request){
        if($request->password) {
            $request->merge(['password' => bcrypt($request->password)]);
        }
        if($request->main_company_id == 'main'){
            $request->merge(['main_company' => 1]);
        }
        $client = User::create($request->all());
        if ($request->file('logo')) {
            $file = $request->file('logo');
            $path = $file->storeAs('/profile_pictures', $client->id. '-'. $file->getClientOriginalName());
            $client->logo = 'https://s3.eu-central-1.amazonaws.com/gsgtool/'.$path;
        }
        if($request->delete_logo){
            $client->logo = '';
        }
        $client->save();
        $user_role = new UserRole();
        $user_role->user_id = $client->id;
        $user_role->role_id = 6;
        $user_role->save();
        return redirect()->route('client')->with('success', __('messages.success_store_client'));
    }

    public function archive($client_id){
        $client = User::findOrFail($client_id);
        $client->archived = 1;
        $client->save();
        return redirect()->route('client')->with('success', __('messages.success_archive_client'));
    }

    public function archived(){
        $clients = User::where('archived', 1)->get();
        return view('pages.client.archived', compact('clients'));
    }

    public function unArchive($client_id){
        $client = User::findOrFail($client_id);
        $client->archived = 0;
        $client->save();
        return redirect()->route('client_archived')->with('success', __('messages.success_un_archive_client'));
    }

    public function pdf(){
        $clients = User::where('archived', 0)->get();
        foreach($clients as $k=>$client){
            if(!$client->isClient()){
                unset($clients[$k]);
            }
        }
        $html = view('pages.client.pdf', compact('clients'))->render();
        return $this->pdf->load($html)->filename(__('headings.client_list'))->show();
    }

    public function show(Request $request){
        $client = User::findOrFail($request->client_id);
        $pdfUrl = route('client_show_pdf', ['client_id' => $request->client_id]);
        ob_start();
        require base_path(). '/resources/views/pages/client/_show_modal.php';
        $html = ob_get_clean();
        return response()->json(['html' => $html]);
    }

    public function showPdf($client_id){
        $client = User::findOrFail($client_id);
        $html = view('pages.client.show_pdf', compact('client'))->render();
        $options = $this->pdf->getOptions();
        $options->setIsRemoteEnabled(true);
        return $this->pdf->setOptions($options)->load($html)->filename($client->name)->show();
    }

    public function edit($client_id){
        $client = User::findOrFail($client_id);
        $staff_types = Role::all();
        foreach($staff_types as $k=>$staff_type){
            if($staff_type->role_name == 'Client' || $staff_type->role_name == 'Partner'){
                unset($staff_types[$k]);
            }
        }
        $main_companies = User::where('archived', 0)->get();
        $companies = ['main' => __('labels.main_company')];
        foreach($main_companies as $k=>$main_company){
            if($main_company->isClient() && $main_company->id != $client_id && $main_company->main_company == 1){
                $companies[$main_company->id] = $main_company->name;
            }
        }
        return view('pages.client.edit', compact('client', 'staff_types', 'companies'));
    }

    public function update(ClientRequest $request, $client_id){
        $client = User::findOrFail($client_id);
        if($request->password) {
            $request->merge(['password' => bcrypt($request->password)]);
        }
        if($request->main_company_id == 'main'){
            $request->merge(['main_company' => 1]);
        }else{
            $request->merge(['main_company' => 0]);
        }
        $client->update($request->all());
        if ($request->file('logo')) {
            $file = $request->file('logo');
            $path = $file->storeAs('/profile_pictures', $client->id. '-'. $file->getClientOriginalName());
            $client->logo = 'https://s3.eu-central-1.amazonaws.com/gsgtool/'.$path;
        }
        if($request->delete_logo){
            $client->logo = '';
        }
        $client->save();
        return redirect()->route('client')->with('success', __('messages.success_update_client'));
    }

    public function delete($client_id){
        $client = User::findOrFail($client_id);
        $client->delete();
        return redirect()->route('client')->with('success', __('messages.success_delete_client'));
    }
}
