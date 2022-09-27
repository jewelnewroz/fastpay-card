<?php

namespace App\Services;

use App\Helper\CommonHelper;
use App\Repositories\Interfaces\OperatorCategoryRepositoryInterface;

class OperatorCategoryService
{
    private OperatorCategoryRepositoryInterface $operatorCategoryRepository;

    public function __construct(OperatorCategoryRepositoryInterface $operatorCategoryRepository)
    {
        $this->operatorCategoryRepository = $operatorCategoryRepository;
    }

    public function getForDataTable()
    {
        return datatables()->eloquent($this->operatorCategoryRepository->getModel());
    }

    public function create(array $data)
    {
        return $this->operatorCategoryRepository->create($data + [
                'calculated_data' => CommonHelper::numberFormat(5.566666)
            ]);
    }
}
