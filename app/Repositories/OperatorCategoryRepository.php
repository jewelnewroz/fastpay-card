<?php

namespace App\Repositories;

use App\Models\OperatorCategory;
use App\Repositories\Interfaces\OperatorTypeRepositoryInterface;

class OperatorCategoryRepository extends BaseRepository implements OperatorTypeRepositoryInterface
{
    public function __construct(OperatorCategory $model)
    {
        parent::__construct($model);
    }
}
