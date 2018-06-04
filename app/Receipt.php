<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Receipt extends Model
{
    protected $fillable = [
        'name', 'text', 'documents', 'user_ids'
    ];
}
