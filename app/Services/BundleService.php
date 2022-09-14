<?php

namespace App\Services;

use App\Repositories\Interfaces\BundleRepositoryInterface;
use Illuminate\Http\Request;

class BundleService
{
    private BundleRepositoryInterface $bundleRepository;

    public function __construct(BundleRepositoryInterface $bundleRepository)
    {
        $this->bundleRepository = $bundleRepository;
    }

    public function getDataTable(Request $request)
    {
    }
}
