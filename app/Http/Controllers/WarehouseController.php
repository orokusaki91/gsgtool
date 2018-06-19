<?php

namespace App\Http\Controllers;

use App\Http\Requests\WarehouseRequest;
use Illuminate\Http\Request;
use App\Warehouse;
use App\WarehouseTransaction;

class WarehouseController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
        $this->middleware('check_if_admin');
    }

    public function index(){
        $warehouses = Warehouse::all();
        return view('pages.warehouse.index', compact('warehouses'));
    }

    public function create(){
        $warehouse = null;
        return view('pages.warehouse.create', compact('warehouse'));
    }

    public function store(WarehouseRequest $request){
        Warehouse::create($request->all());
        return redirect()->route('warehouse')->with('success', __('messages.success_store_warehouse'));
    }

    public function edit(Warehouse $warehouse){
        return view('pages.warehouse.edit', compact('warehouse'));
    }

    public function update(Warehouse $warehouse, WarehouseRequest $request){
        $warehouse->update($request->all());
        return redirect()->route('warehouse')->with('success', __('messages.success_update_warehouse'));
    }

    public function delete(Warehouse $warehouse){
        $warehouse->delete();
        return redirect()->route('warehouse')->with('success', __('messages.success_delete_warehouse'));
    }

    public function getInput(Warehouse $warehouse){
        return view('pages.warehouse.input_edit', compact('warehouse'));
    }

    public function postInput(Warehouse $warehouse, Request $request){
        $this->validate($request, [
            'warehouse_qty' => 'required|integer',
            'warehouse_size' => 'integer|nullable'
        ]);

        $whTransaction = new WarehouseTransaction;
        $whTransaction->warehouse_qty = $request->warehouse_qty;
        $whTransaction->warehouse_size = $request->warehouse_size;
        $warehouse->transactions()->save($whTransaction);

        $warehouse->wh_qty = $warehouse->quantity + $whTransaction->warehouse_qty;
        $warehouse->save();;

        return redirect()->route('warehouse')->with('success', 'Success');
    }

    public function getOutput(Warehouse $warehouse){
        return view('pages.warehouse.output_eit', compact('warehouse'));
    }

    public function postOutput(Warehouse $warehouse){
        return redirect()->route('warehouse')->with('success', 'Success');
    }
}
