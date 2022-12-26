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
            'booked_room_instead_case',
            'booked_room_case',
            'view_list_booked_rooms_case',
        ];

        foreach ($abilities as $ability) {
            Ability::query()->create(['name' => $ability]);
        }

        $roles = [
            'admin',
            'attendant_room',
            'user_med',
            'user'
        ];

        foreach ($roles as $role) {
            Role::query()->create(['name' => $role]);
        }

        $admin = Role::whereName('admin')->first();
        $admin->allowTo('view_any_cases');
        $admin->allowTo('booked_room_instead_case');
        $admin->allowTo('booked_room_case');
        $admin->allowTo('view_list_booked_rooms_case');

        $attendant_room = Role::whereName('attendant_room')->first();
        $attendant_room->allowTo('view_any_cases');
        $attendant_room->allowTo('booked_room_case');
        $attendant_room->allowTo('view_list_booked_rooms_case');

        $user_med = Role::whereName('user_med')->first();
        $user_med->allowTo('view_any_cases');
        $user_med->allowTo('booked_room_case');
        $user_med->allowTo('view_list_booked_rooms_case');

    }
}
