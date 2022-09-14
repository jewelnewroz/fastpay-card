<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Bundle extends Model
{
    protected $casts = [
        'eligibility' => 'array'
    ];

    public function operator(): BelongsTo
    {
        return $this->belongsTo(Operator::class);
    }

    public function getNiceStatusAttribute()
    {
        return config('common.bundle.statuses')[$this->status];
    }
}
