<?php

namespace App\Providers;

use App\Http\View\Composers\GatewayComposer;
use App\Http\View\Composers\OperatorCategoryComposer;
use App\Http\View\Composers\OperatorComposer;
use App\Http\View\Composers\PathComposer;
use App\Http\View\Composers\PermissionComposer;
use App\Http\View\Composers\RoleComposer;
use App\Http\View\Composers\TransactionTypeComposer;
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
                'admin.user.edit',
                'admin.operator.create',
                'admin.operator.edit'
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

        View::composer([
            'admin.operator.create',
            'admin.operator.edit',
            'admin.bundle.create',
            'admin.bundle.edit'
        ], GatewayComposer::class);

        View::composer([
            'admin.transaction.index'
        ], TransactionTypeComposer::class);

        View::composer([
            'admin.operator.create',
            'admin.operator.edit'
        ], OperatorCategoryComposer::class);
    }

    public function boot()
    {
        //
    }
}
