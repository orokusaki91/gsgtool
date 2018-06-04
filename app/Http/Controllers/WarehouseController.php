<?php

namespace App\Http\Controllers;

use App\Http\Requests\WarehouseRequest;
use Illuminate\Http\Request;
use App\Warehouse;

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

    public function edit($warehouse_id){
        $warehouse = Warehouse::find($warehouse_id);
        return view('pages.warehouse.edit', compact('warehouse'));
    }

    public function update(WarehouseRequest $request, $warehouse_id){
        $warehouse = Warehouse::find($warehouse_id);
        $warehouse->update($request->all());
        return redirect()->route('warehouse')->with('success', __('messages.success_update_warehouse'));
    }

    public function delete($warehouse_id){
        $warehouse = Warehouse::find($warehouse_id);
        $warehouse->delete();
        return redirect()->route('warehouse')->with('success', __('messages.success_delete_warehouse'));
    }
}
