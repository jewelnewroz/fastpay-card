<?php

namespace App\Services;

use App\Helper\CommonHelper;
use App\Http\Requests\OperatorCreateRequest;
use App\Http\Requests\OperatorUpdateRequest;
use App\Models\Operator;
use App\Repositories\Interfaces\OperatorRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;

class OperatorService
{
    private OperatorRepositoryInterface $operatorRepository;

    public function __construct(OperatorRepositoryInterface $operatorRepository)
    {
        $this->operatorRepository = $operatorRepository;
    }

    public function getDatatable($request): JsonResponse
    {
        return DataTables()->eloquent($this->operatorRepository->getModel()->query())
            ->filter(function ($query) use ($request) {
                if ($request->filled('status')) {
                    $query->where('status', '=', $request->input('status'));
                }
                if ($request->has('keyword')) {
                    $query->where('name', 'like', '%' . $request->input('keyword') . '%');
                }
            })
            ->addColumn('created_at', function (Operator $operator) {
                return $operator->created_at->format('d/m/Y h:i a');
            })
            ->addColumn('status', function (Operator $operator) {
                return $operator->nice_status;
            })
            ->addColumn('gateway', function (Operator $operator) {
                return CommonHelper::purseGateway($operator->gateway);
            })
            ->toJson();
    }

    public function all()
    {
        return $this->operatorRepository->all();
    }

    public function create(OperatorCreateRequest $request): Model
    {
        return $this->operatorRepository->create($request->validated());
    }

    public function update(OperatorUpdateRequest $request, $id)
    {
        return $this->operatorRepository->update($request->validated(), $id);
    }
}
