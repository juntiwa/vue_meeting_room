<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Company::create([
            'unit_id'=> 1,
            'level'=> 4,
            'name_th'=> 'ทดสอบชื่อบริษัท',
            'name_en'=> 'Test name company',
            'shot_name_th'=> 'บริษัท',
            'shot_name_en'=> 'company',
            'department_id'=> 1, //for department insert
        ]);
    }
}
