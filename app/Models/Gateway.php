<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gateway extends Model
{
    public $timestamps = false;
    protected $fillable = ['name'];
}
