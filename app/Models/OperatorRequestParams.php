<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OperatorRequestParams extends Model
{
    protected $fillable = ['operator_id', 'key', 'label', 'placeholder'];
    protected $hidden = ['id', 'created_at', 'updated_at'];
}
