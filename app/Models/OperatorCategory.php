<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OperatorCategory extends Model
{
    public $timestamps = false;
    protected $fillable = ['name', 'label'];
}
