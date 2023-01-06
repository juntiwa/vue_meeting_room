<?php

namespace Database\Seeders;

use App\Models\Ability;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AbilityRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $abilities = [
            'booked_room_case',
            'edit_booked_room_case',
            'cancel_booked_room_case',
            'record_data_booked_room_case',
            'record_data_request_equipment_case',
            'period_booked_room_case',
            'view_list_booked_room_case',
            'view_list_request_equipment_case',
        ];

        foreach ($abilities as $ability) {
            Ability::query()->create(['name' => $ability]);
        }

        $roles = [
            'user_med',
            'admin',
            'period_booked',
            'user'
        ];

        foreach ($roles as $role) {
            Role::query()->create(['name' => $role]);
        }

        $admin = Role::whereName('user_med')->first();
        $admin->allowTo('booked_room_case');
        $admin->allowTo('edit_booked_room_case');
        $admin->allowTo('cancel_booked_room_case');
        $admin->allowTo('view_list_booked_room_case');

        $user_med = Role::whereName('admin')->first();
        $user_med->allowTo('record_data_booked_room_case');
        $user_med->allowTo('record_data_request_equipment_case');
        $user_med->allowTo('view_list_request_equipment_case');

        $period_booked = Role::whereName('period_booked')->first();
        $period_booked->allowTo('period_booked_room_case');

    }
}
