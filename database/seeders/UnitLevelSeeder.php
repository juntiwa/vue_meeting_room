<?php

namespace Database\Seeders;

use App\Models\UnitLevel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UnitLevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UnitLevel::seed(storage_path('app/seeders/unitlevel.csv'));
    }
}
