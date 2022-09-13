<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Bundle extends Model
{
    public function operator(): BelongsTo
    {
        return $this->belongsTo(Operator::class);
    }
}
