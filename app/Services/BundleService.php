<?php

namespace App\Services;

use App\Http\Requests\BundleCreateRequest;
use App\Http\Requests\BundleUpdateRequest;
use App\Models\Bundle;
use App\Repositories\Interfaces\BundleRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BundleService
{
    private BundleRepositoryInterface $bundleRepository;

    public function __construct(BundleRepositoryInterface $bundleRepository)
    {
        $this->bundleRepository = $bundleRepository;
    }

    public function getDataTable(Request $request): JsonResponse
    {
        return DataTables()->eloquent($this->bundleRepository->with('operator'))
            ->filter(function ($query) use ($request) {
                if ($request->filled('status')) {
                    $query->where('status', '=', $request->input('status'));
                }
                if ($request->has('keyword')) {
                    $query->where('name', 'like', '%' . $request->input('keyword') . '%');
                }
            })
            ->addColumn('created_at', function (Bundle $bundle) {
                return $bundle->created_at ? $bundle->created_at->format('d/m/Y h:i a') : '---';
            })
            ->addColumn('status', function (Bundle $bundle) {
                return $bundle->nice_status;
            })
            ->toJson();
    }

    public function create(BundleCreateRequest $request): Model
    {
        return $this->bundleRepository->create($request->validated());
    }

    public function update(BundleUpdateRequest $request, $id)
    {
        return $this->bundleRepository->update($request->validated(), $id);
    }
}
