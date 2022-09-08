<?php

namespace App\Observers;

use App\Models\Role;

class RoleObserver
{
    public function created(Role $role)
    {
        $role->syncPermissions(request()->input('permission'));
    }

    public function updated(Role $role)
    {
        dd($role);
        $role->syncPermissions(request()->input('permission'));
    }

    /**
     * Handle the Role "deleted" event.
     *
     * @param  \App\Models\Role  $role
     * @return void
     */
    public function deleted(Role $role)
    {
        //
    }
}
