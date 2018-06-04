<?php

namespace App\Http\Controllers;

use App\Http\Requests\TheftRequest;
use Illuminate\Http\Request;
use App\Theft;
use App\User;
use Vsmoraes\Pdf\Pdf;
use Countries;

class TheftController extends Controller
{
    private $pdf;

    public function __construct(Pdf $pdf){
        $this->pdf = $pdf;

        $this->middleware('auth');

        $this->middleware('check_if_can_view_theft', [
            'only' => [
                'index', 'create', 'store', 'pdf'
            ]
        ]);

        $this->middleware('menage_theft', [
            'only' => [
                'edit', 'update', 'delete'
            ]
        ]);
    }

    public function index(){
        $thefts = Theft::all();
        $countries = Countries::lookup();
        return view('pages.theft.index', compact('thefts', 'countries'));
    }

    public function create(){
        $theft = null;
        $countries = Countries::lookup();
        $clients = User::where('archived', 0)->get();
        foreach($clients as $k=>$client){
            if(!$client->isClient()){
                unset($clients[$k]);
            }
        }
        return view('pages.theft.create', compact('theft', 'countries', 'clients'));
    }

    public function store(TheftRequest $request){
        $request->merge(['user_id' => Auth()->user()->id]);
        if($request->date){
            $request->merge(['date' => date('Y-m-d H:i:s', strtotime($request->date))]);
        }
        if($request->birthdate){
            $request->merge(['birthdate' => date('Y-m-d', strtotime($request->birthdate))]);
        }
        $theft = Theft::create($request->all());
        if($request->documents) {
            $theft->documents = getStringForUploadedDocuments($request, $theft, '/theft');
            $theft->save();
        }
        return redirect()->route('theft')->with('success', __('messages.success_store_theft'));
    }

    public function pdf(){
        $thefts = Theft::all();
        $html = view('pages.theft.pdf', compact('thefts'))->render();
        return $this->pdf->load($html, 'A4', 'landscape')->filename(__('headings.theft_list'))->show();
    }

    public function ajax(Request $request){
        $document = Theft::findOrFail($request->document_id);
        $request->merge(['document_type' => 'theft']);
        $updateUrl = route('theft_update_files', ['theft_id' => $document->id]);
        ob_start();
        require base_path(). '/resources/views/layouts/_files_modal.php';
        $html = ob_get_clean();
        return response()->json(['html' => $html]);
    }

    public function updateFiles(Request $request, $theft_id){
        $theft = Theft::findOrFail($theft_id);
        if($request->documents) {
            $theft->documents = getStringForUploadedDocuments($request, $theft, '/theft');
        }
        if($request->delete_documents){
            $theft->documents = '';
        }
        $theft->save();
        return redirect()->route('theft')->with('success', __('messages.success_update_documents_files'));
    }

    public function deleteFile($document_id, $file_name){
        $theft = Theft::findOrFail($document_id);
        $files = explode('|,|', $theft->documents);
        foreach($files as $k=>$file){
            if(strpos($file, $file_name) !== false) {
                unset($files[$k]);
            }
        }
        $theft->documents = implode('|,|', $files);
        $theft->save();
        return redirect()->route('theft')->with('success', __('messages.success_delete_documents_file'));
    }

    public function edit($theft_id){
        $theft = Theft::find($theft_id);
        $countries = Countries::lookup();
        $clients = User::where('archived', 0)->get();
        foreach($clients as $k=>$client){
            if(!$client->isClient()){
                unset($clients[$k]);
            }
        }
        return view('pages.theft.edit', compact('theft', 'countries', 'clients'));
    }

    public function update(TheftRequest $request, $theft_id){
        $theft = Theft::find($theft_id);
        if($request->date){
            $request->merge(['date' => date('Y-m-d H:i:s', strtotime($request->date))]);
        }
        if($request->birthdate){
            $request->merge(['birthdate' => date('Y-m-d', strtotime($request->birthdate))]);
        }
        $theft->update($request->all());
        return redirect()->route('theft')->with('success', __('messages.success_update_theft'));
    }

    public function delete($theft_id){
        $theft = Theft::findOrFail($theft_id);
        $theft->delete();
        return redirect()->route('theft')->with('success', __('messages.success_delete_theft'));
    }
}
