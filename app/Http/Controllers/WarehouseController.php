<?php

namespace App\Http\Controllers;

use App\Http\Requests\WarehouseRequest;
use Illuminate\Http\Request;
use DB;
use Session;
use App\User;
use App\Warehouse;
use App\WarehouseTransaction;
use App\Http\Requests\WarehouseReturnsRequest;

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
        $warehouse = new Warehouse;
        $warehouse->name = $request->name;
        $warehouse->has_sizes = $request->sizes ? 1 : 0;
        $warehouse->save();
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

        $warehouse->wh_stock = $warehouse->wh_stock + $whTransaction->warehouse_qty;
        $warehouse->save();;

        return redirect()->route('warehouse')->with('success', 'Success');
    }

    public function getOutput(Warehouse $warehouse){
        $staff = User::staff()->get();
        $whSizes = $warehouse->transactions()
                            ->whereIn('warehouse_size', array_keys(getArray('warehouse_size')))
                            ->groupBy('warehouse_size')
                            ->pluck('warehouse_size')
                            ->toArray();
        // get values by keys combining 2 arrays
        $whSizes = array_intersect_key(getArray('warehouse_size'), array_flip($whSizes));
        // make a collection from an array
        $whSizes = collect($whSizes);
         
        // sum qunatity of that product
        $sumQty = $warehouse->transactions()->sum('warehouse_qty');

        return view('pages.warehouse.output_edit', compact('warehouse', 'staff', 'whSizes', 'sumQty'));
    }

    public function postOutput(Warehouse $warehouse, Request $request){
        $this->validate($request, [
            'warehouse_qty' => 'required|integer',
        ]);
        $inputWhSize = isset($request->warehouse_size) ? $request->warehouse_size : 0;

        if ($inputWhSize) {
            $sumQty = $warehouse->transactions()->where('warehouse_size', $inputWhSize)->sum('warehouse_qty');
        } else {
            $sumQty = $warehouse->wh_stock;
        }

        $newWhQty = $sumQty - $request->warehouse_qty;

        if ($newWhQty < 0) {
            return redirect()->back()->with('error', 'Quantity not allowed.');
        }

        $whTransaction = new WarehouseTransaction;
        $whTransaction->user_id = $request->user_id;
        $whTransaction->warehouse_qty = (int)-$request->warehouse_qty;
        $whTransaction->warehouse_size = $request->warehouse_size;
        $whTransaction->warehouse_type = 1;
        $warehouse->transactions()->save($whTransaction);

        $warehouse->wh_stock = $warehouse->wh_stock - $request->warehouse_qty;
        $warehouse->save();

        return redirect()->route('warehouse')->with('success', 'Success');
    }

    public function getReturns()
    {
        $staff = User::staff()->get();
        $warehouses = Warehouse::whereHas('transactions', function ($q) {
            $q->where('warehouse_type', 1)->groupBy('warehouse_id');
        })
        ->get();
        return view('pages.warehouse.returns', compact('staff', 'warehouses'));
    }

    public function postReturns(WarehouseReturnsRequest $request)
    {
        $inputQty = $request->warehouse_qty;
        $user = User::findOrFail($request->staff);
        $warehouse = Warehouse::findOrFail($request->warehouse_product);
        $sumQty = WarehouseTransaction::sumQuantities($request);

        if ($inputQty > $sumQty) {
            Session::flash('error', 'Quantity not allowed.');
            return response()->json(['status' => false]);
        }

        $newWhTransaction = new WarehouseTransaction;
        $newWhTransaction->user_id = $user->id;
        $newWhTransaction->warehouse_size = $request->warehouse_size;
        $newWhTransaction->user_id = $request->staff;
        $newWhTransaction->warehouse_qty = $inputQty;
        $newWhTransaction->depreciation = $request->warehouse_depreciation;
        
        $warehouse->transactions()->save($newWhTransaction);

        if ($request->warehouse_depreciation == 1) {
            $warehouse->wh_stock = $warehouse->wh_stock + $inputQty;
            $warehouse->save();
        }

        Session::flash('success', 'Success');

        return response()->json([
            'status' => true
        ]);
    }

    // AJAX REQUESTS START HERE
    public function sumQuantities(Request $request)
    {
        $sumQty = WarehouseTransaction::where('warehouse_id', $request->warehouse_product)
                                        ->where('warehouse_size', $request->warehouse_size)
                                        ->sum('warehouse_qty');
        return response()->json(['sum' => $sumQty]);
    }

    public function getProductsByStaff(Request $request)
    {
        $whProducts = Warehouse::whereHas('transactions', function ($q) use ($request) {
            $q->where('user_id', $request->staff)->groupBy('warehouse_id');
        })->get();

        return response()->json([
            'whProducts' => $whProducts
        ]);
    }

    public function getSizesByProduct(Request $request)
    {
        // get sizes by product
        $whSizes = WarehouseTransaction::getSizesByProduct($request);
         
        // get values by keys combining 2 arrays
        $whSizes = array_intersect_key(getArray('warehouse_size'), array_flip($whSizes));
        // make a collection from an array
        $whSizes = collect($whSizes);

        $sumQty = 0;
        // sum quantity for products what have no size
        if (!$whSizes->count()) {
            $sumQty = WarehouseTransaction::where('warehouse_id', $request->warehouse_product)
                                            ->where('user_id', $request->staff)
                                            ->sum('warehouse_qty');
        }

        return response()->json([
            'whSizes' => $whSizes,
            'sumQty' => abs($sumQty)
        ]);
    }

    public function getQtyBySize(Request $request)
    {
        $sumQty = WarehouseTransaction::where('warehouse_id', $request->warehouse_product)
                                    ->where('user_id', $request->staff)
                                    ->where('warehouse_size', $request->warehouse_size)
                                            ->sum('warehouse_qty');

        return response()->json([
            'sumQty' => abs($sumQty)
        ]);
    }


}
