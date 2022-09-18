<?php

namespace App\Services;

use App\Models\Bundle;
use App\Models\Transaction;
use App\Repositories\Interfaces\TransactionRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TransactionService
{
    private TransactionRepositoryInterface $transactionRepository;

    public function __construct(TransactionRepositoryInterface $transactionRepository)
    {
        $this->transactionRepository = $transactionRepository;
    }

    public function getDataTable(Request $request): JsonResponse
    {
        return DataTables()->eloquent($this->transactionRepository->with(['sender', 'receiver', 'transactionType']))
            ->filter(function ($query) use ($request) {
                if ($request->filled('status')) {
                    $query->where('status', '=', $request->input('status'));
                }
                if ($request->filled('keyword')) {
                    $query->where('tx_unique_id', '=', $request->input('keyword'));
                }
            })
            ->addColumn('created_at', function (Transaction $transaction) {
                return $transaction->created_at ? $transaction->created_at->format('d/m/Y h:i a') : '---';
            })
            ->addColumn('status', function (Transaction $transaction) {
                return $transaction->nice_status;
            })
            ->toJson();
    }
}
