<?php

namespace App\Http\Controllers\Dashboard;

use App\Helper\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\OperatorCreateRequest;
use App\Http\Requests\OperatorUpdateRequest;
use App\Models\Operator;
use App\Services\OperatorService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class OperatorController extends Controller
{
    private OperatorService $operatorService;

    public function __construct(OperatorService $operatorService)
    {
        $this->operatorService = $operatorService;
    }

    public function index(Request $request)
    {
        if($request->ajax() || $request->wantsJson()) {
            return $this->operatorService->getDatatable($request);
        }
        return view('admin.operator.index')->with(['title' => 'Operators']);
    }

    public function create()
    {
        return view('admin.operator.create')->with(['title' => 'Add new operator']);
    }

    public function store(OperatorCreateRequest $request): RedirectResponse
    {
        try {
            if($this->operatorService->create($request)) {
                return redirect()->route('operator.index')->with(ResponseHelper::success(__('Operator successfully created')));
            }
        } catch (\Exception $exception) {
            Log::error('User Create ' . $exception);
        }

        return redirect()->back()->with(ResponseHelper::failed(__('Operator cannot be created')))->withInput($request->all());
    }

    public function show(Operator $operator)
    {
        return view('admin.operator.show', compact('operator'))->with(['title' => 'Show operator']);
    }

    public function edit(Operator $operator)
    {
        return view('admin.operator.edit', compact('operator'))->with(['title' => 'Edit operator']);
    }

    public function update(OperatorUpdateRequest $request, $id): RedirectResponse
    {
        try {
            if($this->operatorService->update($request, $id)) {
                return redirect()->route('operator.index')->with(ResponseHelper::success(__('Operator successfully updated')));
            }
        } catch (\Exception $exception) {
            Log::error('User Create ' . $exception);
        }

        return redirect()->back()->with(ResponseHelper::failed(__('Operator cannot be updated')))->withInput($request->all());
    }

    public function destroy($id)
    {
        //
    }
}
