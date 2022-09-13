<?php

namespace App\Repositories;

use App\Models\Bundle;
use App\Repositories\Interfaces\BundleRepositoryInterface;

class BundleRepository extends BaseRepository implements BundleRepositoryInterface
{
    public function __construct(Bundle $model)
    {
        parent::__construct($model);
    }

    public function all()
    {
        return parent::all();
    }
}
