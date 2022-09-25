<?php

namespace App\Services;

use App\Models\TransactionType;
use Illuminate\Support\Facades\Cache;

class TransactionTypeService
{
    public function all()
    {
        return Cache::rememberForever('transaction_types', function () {
            return TransactionType::all();
        });
    }
}
