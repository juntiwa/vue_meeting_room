<?php

namespace App\APIs;

use App\Contracts\AuthUserAPI;
use Illuminate\Support\Facades\Http;

class FakeUserAPI implements AuthUserAPI
{
    public function authenticate($login, $password)
    {
        if ($login == $password) {
            $data = [
                'ok' => true,
                'found' => true,
                'login' => 'admin.sys',
                'org_id' => '10012345',
                'full_name' => 'น.ส. ผู้ใช้งาน ทั่วไป',
                'full_name_en' => 'Miss User System',
                'position_name' => 'นักวิชาการคอมพิวเตอร์',
                'division_name' => 'ภ.อายุรศาสตร์',
                'department_name' => 'ภ.อายุรศาสตร์',
                'office_name' => 'สนง.ภาควิชาอายุรศาสตร์',
                'email' => '',
                'password_expires_in_days' => 46,
                'remark' => 'สนง.ภาควิชาอายุรศาสตร์ ภ.อายุรศาสตร์',
                'name' => 'น.ส. ผู้ใช้งาน ทั่วไป',
                'name_en' => 'Miss User System',
                'reply_code' => 0,
            ];
        } else {
            $data = [
                'reply_code' => 1,
                'reply_text' => 'Username or Password is incorrect',
                'found' => 'false',
            ];
        }

        if ($data['found'] !== true) {
            return ['reply_code' => '1', 'reply_text' => 'ตรวจสอบ username หรือ password อีกครั้ง', 'found' => 'false'];
        }

        return $data;
    }
}
