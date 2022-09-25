<?php

namespace App\Http\View\Composers;

use App\Models\Gateway;
use App\Services\OperatorService;
use Illuminate\View\View;

class GatewayComposer
{
    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('gateways', Gateway::all());
    }
}
