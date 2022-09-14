<?php

namespace App\Repositories;

use App\Models\OperatorType;
use App\Repositories\Interfaces\OperatorTypeRepositoryInterface;

class OperatorTypeRepository extends BaseRepository implements OperatorTypeRepositoryInterface
{
    public function __construct(OperatorType $model)
    {
        parent::__construct($model);
    }
}
