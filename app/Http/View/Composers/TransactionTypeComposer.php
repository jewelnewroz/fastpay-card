<?php

namespace App\Http\View\Composers;

use App\Services\TransactionTypeService;
use Illuminate\View\View;

class TransactionTypeComposer
{
    private TransactionTypeService $transactionTypeService;

    public function __construct(TransactionTypeService $transactionTypeService)
    {
        $this->transactionTypeService = $transactionTypeService;
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('transaction_types', $this->transactionTypeService->all());
    }
}
