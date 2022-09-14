<?php


namespace App\Http\View\Composers;


use App\Services\OperatorService;
use Illuminate\View\View;

class OperatorComposer
{
    protected OperatorService $operatorService;

    public function __construct(OperatorService $operatorService)
    {
        $this->operatorService = $operatorService;
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('roles', $this->operatorService->all());
    }
}
