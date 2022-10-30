<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OperatorCategory extends Model
{
    public $timestamps = false;
    protected $fillable = ['name', 'label', 'icon', 'position_number', 'status'];

    public function getNiceStatusAttribute()
    {
        return config('common.category.statuses')[$this->status] ?? 'Unknown';
    }
}
