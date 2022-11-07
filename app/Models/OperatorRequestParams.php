<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OperatorRequestParams extends Model
{
    protected $fillable = ['name', 'operator_id', 'type', 'key', 'label', 'placeholder'];
    protected $hidden = ['id', 'created_at', 'updated_at'];
}
