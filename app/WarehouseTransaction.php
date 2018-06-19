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
}
