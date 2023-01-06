<?php

namespace Database\Seeders;

use App\Models\AddPermissionAuto;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AddPermissionAutoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            ['sap_id' => '10012341', 'role' => 'admin'],
            ['sap_id' => '10012344', 'role' => 'attendant_room'],
            ['sap_id' => '10012345', 'role' => 'period_booked'],
        ];
        foreach ($users as $user){
            AddPermissionAuto::query()->create($user);
        }
    }
}
