<?php

namespace App\Services;

use App\Repositories\Interfaces\OperatorCategoryRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class OperatorCategoryService
{
    private OperatorCategoryRepositoryInterface $operatorCategoryRepository;

    public function __construct(OperatorCategoryRepositoryInterface $operatorCategoryRepository)
    {
        $this->operatorCategoryRepository = $operatorCategoryRepository;
    }

    public function all()
    {
        return Cache::rememberForever('categories', function () {
            return $this->operatorCategoryRepository->all();
        });
    }

    public function getForDataTable()
    {
        return datatables()->eloquent($this->operatorCategoryRepository->getModel()->query());
    }

    public function create(array $data): Model
    {
        return $this->operatorCategoryRepository->create($data);
    }

    public function update(array $data, $id)
    {
        return $this->operatorCategoryRepository->update($data, $id);
    }
}
