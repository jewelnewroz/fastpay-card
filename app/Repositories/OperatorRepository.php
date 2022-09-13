<?php

namespace App\Repositories;

use App\Models\Operator;
use App\Repositories\Interfaces\OperatorRepositoryInterface;

class OperatorRepository extends BaseRepository implements OperatorRepositoryInterface
{
    public function __construct(Operator $model)
    {
        parent::__construct($model);
    }
}
