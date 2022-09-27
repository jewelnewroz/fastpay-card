<?php

namespace App\Services;

use App\Repositories\Interfaces\OperatorCategoryRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class OperatorCategoryService
{
    private OperatorCategoryRepositoryInterface $operatorCategoryRepository;

    public function __construct(OperatorCategoryRepositoryInterface $operatorCategoryRepository)
    {
        $this->operatorCategoryRepository = $operatorCategoryRepository;
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
