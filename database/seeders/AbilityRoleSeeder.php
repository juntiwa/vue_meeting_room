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
            'view_any_cases',
            'booked_room_any_case',
        ];

        foreach ($abilities as $ability) {
            Ability::query()->create(['name' => $ability]);
        }

        $roles = [
            'admin',
            'attendant_room',
            'user_med',
        ];

        foreach ($roles as $role) {
            Role::query()->create(['name' => $role]);
        }

        $admin = Role::whereName('admin')->first();
        $admin->allowTo('view_any_cases');

        $attendant_room = Role::whereName('attendant_room')->first();
        $attendant_room->allowTo('view_any_cases');

        $user_med = Role::whereName('user_med')->first();
        $user_med->allowTo('view_any_cases');

    }
}
