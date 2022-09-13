<?php

namespace App\Observers;

use App\Models\Operator;

class OperatorObserver
{
    /**
     * Handle the Operator "created" event.
     *
     * @param  \App\Models\Operator  $operator
     * @return void
     */
    public function created(Operator $operator)
    {
        //
    }

    /**
     * Handle the Operator "updated" event.
     *
     * @param  \App\Models\Operator  $operator
     * @return void
     */
    public function updated(Operator $operator)
    {
        //
    }

    /**
     * Handle the Operator "deleted" event.
     *
     * @param  \App\Models\Operator  $operator
     * @return void
     */
    public function deleted(Operator $operator)
    {
        //
    }

    /**
     * Handle the Operator "restored" event.
     *
     * @param  \App\Models\Operator  $operator
     * @return void
     */
    public function restored(Operator $operator)
    {
        //
    }

    /**
     * Handle the Operator "force deleted" event.
     *
     * @param  \App\Models\Operator  $operator
     * @return void
     */
    public function forceDeleted(Operator $operator)
    {
        //
    }
}
