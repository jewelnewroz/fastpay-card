<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use DB;

class HeaderServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        return view('layouts.app');
    }
}
