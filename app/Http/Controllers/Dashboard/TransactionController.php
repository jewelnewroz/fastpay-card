<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Services\TransactionService;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    private TransactionService $transactionService;
    public function __construct(TransactionService $transactionService)
    {
        $this->transactionService = $transactionService;
    }

    public function index(Request $request)
    {
        if($request->ajax() || $request->wantsJson()) {
            return $this->transactionService->getDataTable($request);
        }

        return view('admin.transaction.index')->with(['title' => 'Transactions']);
    }
}
