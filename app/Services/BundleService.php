<?php

namespace App\Services;

use App\Repositories\Interfaces\BundleRepositoryInterface;

class BundleService
{
    private BundleRepositoryInterface $bundleRepository;

    public function __construct(BundleRepositoryInterface $bundleRepository)
    {
        $this->bundleRepository = $bundleRepository;
    }
}
