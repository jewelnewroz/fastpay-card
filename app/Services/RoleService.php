<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\Interfaces\RoleRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class RoleService
{
    protected RoleRepositoryInterface $roleRepository;
    public function __construct(RoleRepositoryInterface $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    public function all(): Collection
    {
        return Cache::rememberForever('roles', function () {
            return $this->roleRepository->all();
        });
    }

    public function getDatatable($request): JsonResponse
    {
        return DataTables()->eloquent($this->roleRepository->with('permissions'))
            ->toJson();;
    }
}
