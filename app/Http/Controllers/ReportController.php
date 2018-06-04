<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReportRequest;
use Illuminate\Http\Request;
use App\Report;
use App\User;
use Vsmoraes\Pdf\Pdf;

class ReportController extends Controller
{
    private $pdf;

    public function __construct(Pdf $pdf){
        $this->pdf = $pdf;

        $this->middleware('auth');

        $this->middleware('check_if_can_view_report', [
            'only' => [
                'index', 'create', 'store', 'pdf'
            ]
        ]);

        $this->middleware('menage_report', [
            'only' => [
                'edit', 'update', 'delete'
            ]
        ]);
    }

    public function index(){
        $reports = Report::all();
        return view('pages.report.index', compact('reports'));
    }

    public function create(){
        $report = null;
        $clients = User::where('archived', 0)->get();
        foreach($clients as $k=>$client){
            if(!$client->isClient()){
                unset($clients[$k]);
            }
        }
        return view('pages.report.create', compact('report', 'clients'));
    }

    public function store(ReportRequest $request){
        $request->merge(['user_id' => Auth()->user()->id]);
        if($request->date){
            $request->merge(['date' => date('Y-m-d H:i:s', strtotime($request->date))]);
        }
        Report::create($request->all());
        return redirect()->route('report')->with('success', __('messages.success_store_report'));
    }

    public function pdf(){
        $reports = Report::all();
        $html = view('pages.report.pdf', compact('reports'))->render();
        return $this->pdf->load($html)->filename(__('headings.report_list'))->show();
    }

    public function edit($report_id){
        $report = Report::find($report_id);
        $clients = User::where('archived', 0)->get();
        foreach($clients as $k=>$client){
            if(!$client->isClient()){
                unset($clients[$k]);
            }
        }
        return view('pages.report.edit', compact('report', 'clients'));
    }

    public function update(ReportRequest $request, $report_id){
        $report = Report::find($report_id);
        if($request->date){
            $request->merge(['date' => date('Y-m-d H:i:s', strtotime($request->date))]);
        }
        $report->update($request->all());
        return redirect()->route('report')->with('success', __('messages.success_update_report'));
    }

    public function delete($report_id){
        $report = Report::findOrFail($report_id);
        $report->delete();
        return redirect()->route('report')->with('success', __('messages.success_delete_report'));
    }
}
