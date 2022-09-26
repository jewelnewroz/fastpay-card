<?php

namespace Database\Seeders;

use App\Models\Gateway;
use Illuminate\Database\Seeder;

class GatewaySeeder extends Seeder
{
    public function run()
    {
        $gateways = [
            ['name' => 'own_card', 'label' => 'Own Card'],
            ['name' => 'FTTH', 'label' => 'FTTH'],
            ['name' => 'FTTH_Special', 'label' => 'FTTH Special'],
            ['name' => 'fast_link', 'label' => 'Fastlink'],
            ['name' => 'newroz', 'label' => 'Newroz'],
            ['name' => 'mint_route', 'label' => 'Mint Route'],
            ['name' => 'mint_route_direct', 'label' => 'Mint Route Direct'],
            ['name' => 'easy_pay', 'label' => 'EasyPay'],
        ];

        Gateway::insert($gateways);
    }
}
