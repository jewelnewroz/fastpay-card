<?php

namespace App\Providers;

use App\Gateways\GatewayInterface;
use App\Models\Bundle;
use Illuminate\Support\ServiceProvider;

class GatewayServiceProvider extends ServiceProvider
{
    public function register(): Void
    {
        //
    }

    public function boot(): Void
    {
        if (!in_array(request()->path(),  ['api/v1/purchase/validate', 'api/v1/purchase/execute'])){
            return;
        }
        $bundle = Bundle::with('operator')->where(['status' => 1, 'id' => request()->input('bundle_id')])->first();

        $this->app->bind(GatewayInterface::class, $this->getClassName($bundle->operator->via ?? 'NotExist'));
    }

    private function getClassName($classname): string
    {
        $classname = str_replace(' ', '', ucwords(str_replace(['-', '_'], ' ', $classname)));
        return "App\Gateways\\" . $classname;
    }
}
