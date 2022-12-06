<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            'admin',
            'attendant_room',
            'user_med'
        ];

        foreach($users as $user){
            $user = User::query()->create([
                'sap_id' => '100'.rand(10000,50000),
                'login' => $user.'.test',
                'full_name' => $user.' test',
                'unit_id' => '1',
                'tel' => '9'.rand(1000,5000),
                'phone' => '0'.rand(612345678,987654321),
            ]);

            $user->assignRole($user);
        }

    }
}
