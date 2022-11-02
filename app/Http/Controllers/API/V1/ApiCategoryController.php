<?php

namespace App\Http\Controllers\API\V1;

use App\Constant\AppConst;
use App\Helper\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Services\OperatorCategoryService;
use Illuminate\Http\JsonResponse;

class ApiCategoryController extends Controller
{
    private OperatorCategoryService $operatorCategoryService;

    public function __construct(OperatorCategoryService $operatorCategoryService)
    {
        $this->operatorCategoryService = $operatorCategoryService;
    }

    public function index(): JsonResponse
    {
        $categories = $this->operatorCategoryService->all()
            ->where('status', AppConst::CATEGORY_ACTIVE)
            ->map(function($category, $key) {
                return $category->format();
            });

        return response()->json(ResponseHelper::success('Success', $categories));
    }
}
