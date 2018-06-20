<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WarehouseTransaction extends Model
{
    public function warehouse()
    {
		return  $this->belongsTo(Warehouse::class);
    }

    public function user()
    {
		return  $this->belongsTo(User::class);
    }

    public static function getSizesByProduct($request) {
    	$query = self::where('warehouse_id', $request->warehouse_product)
                    ->where('user_id', $request->staff);

	    $query = $request->warehouse_size ? $query->where('warehouse_size', $request->warehouse_size) : $query;

	    return $query->groupBy('warehouse_size')
                    ->pluck('warehouse_size')
                    ->filter(function ($value) { return $value != null; })
                    ->toArray();
    }
}
