<?php

namespace Database\Seeders;

use App\Models\DepartmentPurposeBookRoom;
use App\Models\DepartmentRoom;
use App\Models\DepartmentRoomStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DepartmentRoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DepartmentRoomStatus::create([
            'name_th'=>'พร้อมใช้งาน',
            'name_en'=>'Ready',
        ]);

        DepartmentRoom::seed(storage_path('app/seeders/department_rooms.csv'));

        DepartmentPurposeBookRoom::seed(storage_path('app/seeders/department_purpose_book_room.csv'));
    }
}
