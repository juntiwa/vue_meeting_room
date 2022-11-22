<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Department::create([
            'name_th' => 'ภาควิชาอายุรศาสตร์',
            'name_short_th' => 'อายุรศาสตร์',
            'name_en' => 'Medicine department',
            'name_short_en' => 'Medicine',
        ]);
    }
}
