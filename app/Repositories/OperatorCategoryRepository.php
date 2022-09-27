<?php

namespace App\Repositories;

use App\Models\OperatorCategory;
use App\Repositories\Interfaces\OperatorCategoryRepositoryInterface;

class OperatorCategoryRepository extends BaseRepository implements OperatorCategoryRepositoryInterface
{
    public function __construct(OperatorCategory $model)
    {
        parent::__construct($model);
    }
}
