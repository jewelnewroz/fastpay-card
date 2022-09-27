<?php

namespace Database\Seeders;

use App\Models\OperatorCategory;
use Illuminate\Database\Seeder;

class OperatorCategorySeeder extends Seeder
{
    public function run()
    {
        OperatorCategory::insert([
            ['name' => 'mobile_recharge', 'label' => 'Mobile Recharge'],
            ['name' => 'online_cards', 'label' => 'Online Cards'],
            ['name' => 'internet_cards', 'label' => 'Internet Cards'],
        ]);
    }
}
