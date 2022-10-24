<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    protected $fillable = ['attachment', 'extension', 'dimension', 'user_id'];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($media) {
            $media->user_id = auth()->user()->id ?? 1;
        });
    }
}
