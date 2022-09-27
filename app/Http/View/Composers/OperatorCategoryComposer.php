<?php

namespace App\Http\View\Composers;

use App\Services\OperatorCategoryService;
use Illuminate\View\View;

class OperatorCategoryComposer
{
    private OperatorCategoryService $operatorCategoryService;

    public function __construct(OperatorCategoryService $operatorCategoryService)
    {
        $this->operatorCategoryService = $operatorCategoryService;
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('categories', $this->operatorCategoryService->all());
    }
}
