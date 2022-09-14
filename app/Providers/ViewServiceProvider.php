<?php

namespace App\Providers;

use App\Http\View\Composers\OperatorComposer;
use App\Http\View\Composers\PathComposer;
use App\Http\View\Composers\PermissionComposer;
use App\Http\View\Composers\RoleComposer;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    public function register()
    {
        View::composer(
            '*', PathComposer::class
        );
        View::composer(
            [
                'admin.user.index',
                'admin.user.create',
                'admin.user.edit'
            ], RoleComposer::class
        );
        View::composer(
            ['admin.role.edit', 'admin.role.create'], PermissionComposer::class
        );
        View::composer([
            'admin.bundle.index',
            'admin.bundle.create',
            'admin.bundle.edit'
        ], OperatorComposer::class);
    }

    public function boot()
    {
        //
    }
}
