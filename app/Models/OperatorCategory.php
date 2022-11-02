<?php

namespace App\Models;

use App\Constant\AppConst;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    public function operators(): HasMany
    {
        return $this->hasMany(Operator::class, 'category', 'name');
    }

    public function format(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->label,
            'iocn' => secure_asset($this->icon ?? 'default/icon.png'),
            'operators' => $this->operators->where('status', AppConst::OPERATOR_ACTIVE)
                ->map(function($operator, $key) {
                    return $operator->format();
                })
                ->values()
        ];
    }
}
