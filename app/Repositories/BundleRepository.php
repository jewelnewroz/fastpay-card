<?php

namespace App\Repositories;

use App\Models\Bundle;
use App\Repositories\Interfaces\BundleRepositoryInterface;
use Illuminate\Support\Facades\Cache;

class BundleRepository extends BaseRepository implements BundleRepositoryInterface
{
    public function __construct(Bundle $model)
    {
        parent::__construct($model);
    }

    public function all()
    {
        Cache::rememberForever('operators', function() {
            return parent::all();
        });
    }
}
