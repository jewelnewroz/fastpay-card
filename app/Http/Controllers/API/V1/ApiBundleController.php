<?php

namespace App\Http\Controllers\API\V1;

use App\Helper\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Models\Bundle;
use Illuminate\Http\JsonResponse;

class ApiBundleController extends Controller
{
    public function show(Bundle $bundle): JsonResponse
    {
        return response()->json(ResponseHelper::success('Success', $bundle->formatEverything()));
    }
}
