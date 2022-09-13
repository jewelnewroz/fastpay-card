<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Operator;
use App\Services\OperatorService;
use Illuminate\Http\Request;

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

    public function store(Request $request)
    {
        //
    }

    public function show(Operator $operator)
    {
        return view('admin.operator.show', compact('operator'))->with(['title' => 'Show operator']);
    }

    public function edit(Operator $operator)
    {
        return view('admin.operator.edit', compact('operator'))->with(['title' => 'Edit operator']);
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
