<?php

namespace App\Models;

use App\Constant\AppConst;
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

    public function format(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'logo' => secure_asset($this->logo ?? 'default/operator.png')
        ];
    }

    public function formatWithBundles(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'logo' => secure_asset($this->logo ?? 'default/operator.png'),
            'bundles' => $this->bundles->where('status', AppConst::BUNDLE_ACTIVE)->where('offer_only', 0)->map(function($bundle, $key) {
                return $bundle->format();
            })
        ];
    }
}
