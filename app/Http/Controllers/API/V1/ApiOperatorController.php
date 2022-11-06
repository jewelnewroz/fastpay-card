<?php

namespace App\Http\Controllers\API\V1;

use App\Helper\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Models\Operator;
use Illuminate\Http\JsonResponse;

class ApiOperatorController extends Controller
{
    public function show(Operator $operator): JsonResponse
    {
        return response()->json(ResponseHelper::success('Success', $operator->formatWithBundles()));
    }
}
