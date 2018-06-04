<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\DocumentCreateRequest;
use App\Http\Requests\DocumentEditRequest;
use App\Role;
use App\User;

class DocumentController extends Controller
{
    public function __construct(){
        $this->middleware('auth');

        $this->middleware('check_if_admin', [
            'except' => [
                'index', 'ajax'
            ]
        ]);
    }

    public function index($document_type, $user_id = null){
        $type = getDocumentType($document_type);
        $documents = $type::where('archived', 0)->get();
        if($user_id){
            foreach($documents as $k=>$document){
                $ids = explode(',', $document->user_ids);
                if(!in_array($user_id, $ids)){
                    unset($documents[$k]);
                }
            }
        }
        return view('layouts.documents.index', compact('document_type', 'documents'));
    }

    public function create($document_type){
        $document = null;
        $user_roles = Role::all();
        $users = User::where('archived', 0)->get();
        if($document_type == 'receipt'){
            foreach($users as $k=>$user){
                if(!$user->isClient()){
                    unset($users[$k]);
                }
            }
        }else{
            foreach($users as $k=>$user){
                if($user->isClient()){
                    unset($users[$k]);
                }
            }
        }
        return view('layouts.documents.create', compact('document_type', 'document', 'user_roles', 'users'));
    }

    public function store($document_type, DocumentCreateRequest $request){
        $type = getDocumentType($document_type);
        $selected_users = getSelectedUsers($request);
        if($selected_users == ""){
            return redirect()->route('document_create', ['document_type' => $document_type])->with('error', __('messages.empty_staff'));
        }
        $document = new $type();
        $document->name = $request->name;
        $document->text = $request->text;
        $document->user_ids = $selected_users;
        $document->documents = '';
        $document->save();
        if($request->documents) {
            $document->documents = getStringForUploadedDocuments($request, $document, '/staff_documents');
        }
        $document->save();
        return redirect()->route('document_list', ['document_type' => $document_type])->with('success', __('messages.success_store_'. $document_type));
    }

    public function archive($document_type, $document_id){
        $type = getDocumentType($document_type);
        $document = $type::findOrFail($document_id);
        $document->archived = 1;
        $document->save();
        return redirect()->route('document_list', ['document_type' => $document_type])->with('success', __('messages.success_archive_'. $document_type));
    }

    public function archived($document_type){
        $type = getDocumentType($document_type);
        $documents = $type::where('archived', 1)->get();
        return view('layouts.documents.archived', compact('document_type', 'documents'));
    }

    public function unArchive($document_type, $document_id){
        $type = getDocumentType($document_type);
        $document = $type::findOrFail($document_id);
        $document->archived = 0;
        $document->save();
        return redirect()->route('document_archived', ['document_type' => $document_type])->with('success', __('messages.success_un_archive_'. $document_type));
    }

    public function ajax(Request $request){
        $type = getDocumentType($request->document_type);
        $document = $type::findOrFail($request->document_id);
        $updateUrl = route('document_update_files', ['document_type' => $request->document_type, 'document_id' => $document->id]);
        ob_start();
        require base_path(). '/resources/views/layouts/_files_modal.php';
        $html = ob_get_clean();
        return response()->json(['html' => $html]);
    }

    public function updateFiles($document_type, Request $request, $document_id){
        $type = getDocumentType($document_type);
        $document = $type::findOrFail($document_id);
        if($request->documents) {
            $document->documents = getStringForUploadedDocuments($request, $document, '/staff_documents');
        }
        if($request->delete_documents){
            $document->documents = '';
        }
        $document->save();
        return redirect()->route('document_list', ['document_type' => $document_type])->with('success', __('messages.success_update_documents_files'));
    }

    public function deleteFile($document_type, $document_id, $file_name){
        $type = getDocumentType($document_type);
        $document = $type::findOrFail($document_id);
        $files = explode('|,|', $document->documents);
        foreach($files as $k=>$file){
            if(strpos($file, $file_name) !== false) {
                unset($files[$k]);
            }
        }
        $document->documents = implode('|,|', $files);
        $document->save();
        return redirect()->route('document_list', ['document_type' => $document_type])->with('success', __('messages.success_delete_documents_file'));
    }

    public function edit($document_type, $document_id){
        $type = getDocumentType($document_type);
        $document = $type::findOrFail($document_id);
        $user_roles = Role::all();
        $users = User::where('archived', 0)->get();
        if($document_type == 'receipt'){
            foreach($users as $k=>$user){
                if(!$user->isClient()){
                    unset($users[$k]);
                }
            }
        }else{
            foreach($users as $k=>$user){
                if($user->isClient()){
                    unset($users[$k]);
                }
            }
        }
        return view('layouts.documents.edit', compact('document_type', 'document', 'user_roles', 'users'));
    }

    public function update($document_type, DocumentEditRequest $request, $document_id){
        $type = getDocumentType($document_type);
        $document = $type::findOrFail($document_id);
        $selected_users = getSelectedUsers($request);
        if($selected_users == ""){
            return redirect()->route('document_edit', ['document_type' => $document_type, 'document_id' => $document_id])->with('error', __('messages.empty_staff'));
        }
        $document->name = $request->name;
        $document->text = $request->text;
        $document->user_ids = $selected_users;
        $document->save();
        return redirect()->route('document_edit', ['document_type' => $document_type, 'document_id' => $document->id])->with('success', __('messages.success_update_'. $document_type));
    }

    public function delete($document_type, $document_id){
        $type = getDocumentType($document_type);
        $document = $type::findOrFail($document_id);
        $document->delete();
        return redirect()->route('document_list', ['document_type' => $document_type])->with('success', __('messages.success_delete_'. $document_type));
    }
}