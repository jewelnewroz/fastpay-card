<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OperatorRequestParams extends Model
{
    use SoftDeletes;
    protected $fillable = ['name', 'operator_id', 'type', 'key', 'label', 'placeholder'];
    protected $hidden = ['id', 'created_at', 'updated_at', 'deleted_at'];
    protected $casts = [
        'is_required' => 'bool'
    ];
}
