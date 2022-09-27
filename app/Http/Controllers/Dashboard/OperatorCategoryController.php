<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\OperatorCreateRequest;
use App\Models\OperatorCategory;
use App\Services\OperatorCategoryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class OperatorCategoryController extends Controller
{
    private OperatorCategoryService $operatorCategoryService;
    public function __construct(OperatorCategoryService $operatorCategoryService)
    {
        $this->operatorCategoryService = $operatorCategoryService;
    }

    public function index(Request $request)
    {
        if($request->ajax() || $request->wantsJson()) {
            return $this->operatorCategoryService->getForDataTable()->toJson();
        }
        return view('admin.operator.category.index')->with(['title' => 'Categories']);
    }

    public function create(): View
    {
        return view('admin.operator.category.create')->with(['title' => 'Add new category']);
    }

    public function store(OperatorCreateRequest $request)
    {
        try {
            $this->operatorCategoryService->create($request->validated());
        } catch (\Exception $exception) {
            Log::error("Category create " . $exception);
        }
    }

    public function show(OperatorCategory $operatorCategory): View
    {
        return view('admin.operator.category.edit', compact('operatorCategory'))->with(['title' => 'Show category']);
    }

    public function edit(OperatorCategory $operatorCategory): View
    {
        return view('admin.operator.category.edit', compact('operatorCategory'))->with(['title' => 'Update category']);
    }

    public function update(Request $request, $id)
    {
        try {
            $this->operatorCategoryService->update($request->validated(), $id);
        } catch (\Exception $exception) {
            Log::error("Category Update " . $exception);
        }
    }
}
