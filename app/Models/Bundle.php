<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Bundle extends Model
{
    protected $fillable = ['operator_id', 'name', 'logo', 'price', 'top_up_profile', 'validity', 'position', 'status'];
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

    public function format(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'logo' => secure_asset($this->logo ?? 'default/banner.png')
        ];
    }
}
