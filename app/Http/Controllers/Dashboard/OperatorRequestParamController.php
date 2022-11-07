<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\OperatorParamCreateRequest;
use App\Models\Operator;
use App\Models\OperatorRequestParams;
use Illuminate\Http\RedirectResponse;

class OperatorRequestParamController extends Controller
{
    public function create(Operator $operator)
    {
        return view('admin.operator.param.create', compact('operator'))
            ->with(['title' => 'Add new request param']);
    }

    public function store(OperatorParamCreateRequest $request): RedirectResponse
    {
        try {
            OperatorRequestParams::create($request->validated());
            return redirect()->route('operator.show', [$request->input('operator_id'), 'tab' => 'param']);
        } catch (\Exception $exception) {
            return redirect()->back()->withInput($request->all());
        }
    }

    public function destroy($id)
    {
        //
    }
}
