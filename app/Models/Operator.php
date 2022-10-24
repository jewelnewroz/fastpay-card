<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Operator extends Model
{
    protected $casts = ['eligibility' => 'array'];
    protected $fillable = ['name', 'logo', 'type', 'gateway', 'position', 'status'];

    public function bundles(): HasMany
    {
        return $this->hasMany(Bundle::class);
    }

    public function getNiceStatusAttribute()
    {
        return config('common.operator.statuses')[$this->status];
    }
}
