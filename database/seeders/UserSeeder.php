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
            'user_medicine'
        ];
        $password = Hash::make('111');

        foreach($users as $user){
            $user = User::create([
                'name' => $user,
                'full_name' => $user.' test',
                'sap_id' => '10012345',
                'email' => $user.'@med.si',
                // 'email_verified_at' => '',
                'password' => $password,
                'unit_level' => '0',
                'unit_id' => '1',
            ]);
            $user->assignRole($user);
        }

    }
}
