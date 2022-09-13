<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Operator extends Model
{
    use HasFactory;

    protected $casts = ['eligibility' => 'array'];

    public function getNiceStatusAttribute()
    {
        return config('common.operator.statuses')[$this->status];
    }
}
