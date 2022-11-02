<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OperatorCategory extends Model
{
    public $timestamps = false;
    protected $fillable = ['name', 'label', 'icon', 'position_number', 'status'];
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'icon' => 'string'
    ];

    public function getNiceStatusAttribute()
    {
        return config('common.category.statuses')[$this->status] ?? 'Unknown';
    }

    public function format(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->label,
            'iocn' => secure_asset($this->icon ?? 'default/icon.png')
        ];
    }
}
