<?php

namespace App\Observers;

use App\Models\Bundle;

class BundleObserver
{
    /**
     * Handle the Bundle "created" event.
     *
     * @param  \App\Models\Bundle  $bundle
     * @return void
     */
    public function created(Bundle $bundle)
    {
        //
    }

    /**
     * Handle the Bundle "updated" event.
     *
     * @param  \App\Models\Bundle  $bundle
     * @return void
     */
    public function updated(Bundle $bundle)
    {
        //
    }

    /**
     * Handle the Bundle "deleted" event.
     *
     * @param  \App\Models\Bundle  $bundle
     * @return void
     */
    public function deleted(Bundle $bundle)
    {
        //
    }

    /**
     * Handle the Bundle "restored" event.
     *
     * @param  \App\Models\Bundle  $bundle
     * @return void
     */
    public function restored(Bundle $bundle)
    {
        //
    }

    /**
     * Handle the Bundle "force deleted" event.
     *
     * @param  \App\Models\Bundle  $bundle
     * @return void
     */
    public function forceDeleted(Bundle $bundle)
    {
        //
    }
}
