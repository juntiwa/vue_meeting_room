<?php

namespace Database\Seeders;

use App\Models\UnitInner;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UnitInnerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UnitInner::seed(storage_path('app/seeders/innerunits.csv'));
    }
}
