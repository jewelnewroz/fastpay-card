<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\OperatorCategoryCreateRequest;
use App\Http\Requests\OperatorCategoryUpdateRequest;
use App\Http\Requests\OperatorCreateRequest;
use App\Models\OperatorCategory;
use App\Services\OperatorCategoryService;
use Illuminate\Http\RedirectResponse;
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

    public function store(OperatorCategoryCreateRequest $request)
    {
        try {
            $this->operatorCategoryService->create($request->validated());
            return redirect()->route('category.index');
        } catch (\Exception $exception) {
            Log::error("Category create " . $exception);
            return redirect()->back()->withInput($request->all());
        }
    }

    public function show(OperatorCategory $operatorCategory): View
    {
        return view('admin.operator.category.edit', compact('operatorCategory'))->with(['title' => 'Show category']);
    }

    public function edit(OperatorCategory $category): View
    {
        return view('admin.operator.category.edit', compact('category'))->with(['title' => 'Update category']);
    }

    public function update(OperatorCategoryUpdateRequest $request, $id): RedirectResponse
    {
        try {
            $this->operatorCategoryService->update($request->validated(), $id);
            return redirect()->route('category.index');
        } catch (\Exception $exception) {
            Log::error("Category Update " . $exception);
            return redirect()->back()->withInput($request->all());
        }
    }
}
