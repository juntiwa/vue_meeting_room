<?php

namespace App\APIs;

use App\Contracts\AuthUserAPI;
use Illuminate\Support\Facades\Http;

class FakeUserAPI implements AuthUserAPI
{
    public function authenticate($login, $password)
    {
        if ($login && ($password == '111')) {
            $data = [
                'ok' => true,
                'found' => true,
                'position_name' => 'นักวิชาการคอมพิวเตอร์',
                'division_name' => 'ภ.อายุรศาสตร์',
                'department_name' => 'ภ.อายุรศาสตร์',
                'office_name' => 'สนง.ภาควิชาอายุรศาสตร์',
                'email' => '',
                'password_expires_in_days' => 46,
                'remark' => 'สนง.ภาควิชาอายุรศาสตร์ ภ.อายุรศาสตร์',
                'reply_code' => 0,
            ];
            if ($login === 'admin.sys') {
                $data['login'] = 'admin.sys';
                $data['org_id'] = '10012341';
                $data['full_name'] = 'น.ส. ผู้ดูแล ระบบ';
                $data['full_name_en'] = 'Miss Admin System';
                $data['name'] = 'น.ส. ผู้ดูแล ระบบ';
                $data['name_en'] = 'Miss Admin System';
            } elseif ($login === 'user.med') {
                $data['login'] = 'user.med';
                $data['org_id'] = '10012342';
                $data['full_name'] = 'น.ส. ผู้ใช้งาน อายุรศาสตร์';
                $data['full_name_en'] = 'Miss User Med';
                $data['name'] = 'น.ส. ผู้ใช้งาน อายุรศาสตร์';
                $data['name_en'] = 'Miss User Med';
            } elseif ($login === 'user.uni') {
                $data['login'] = 'user.uni';
                $data['org_id'] = '10012343';
                $data['full_name'] = 'น.ส. ผู้ใช้งาน สาขา';
                $data['full_name_en'] = 'Miss User Uni';
                $data['name'] = 'น.ส. ผู้ใช้งาน สาขา';
                $data['name_en'] = 'Miss User Uni';
            } elseif ($login === 'user.edu') {
                $data['login'] = 'user.edu';
                $data['org_id'] = '10012345';
                $data['full_name'] = 'น.ส. ผู้ใช้งาน การศึกษา';
                $data['full_name_en'] = 'Miss User Edu';
                $data['name'] = 'น.ส. ผู้ใช้งาน การศึกษา';
                $data['name_en'] = 'Miss User Edu';
            }  else {
                $data['login'] = 'user.sys';
                $data['org_id'] = '10012346';
                $data['full_name'] = 'น.ส. ผู้ใช้งาน ทั่วไป';
                $data['full_name_en'] = 'Miss User System';
                $data['name'] = 'น.ส. ผู้ใช้งาน ทั่วไป';
                $data['name_en'] = 'Miss User System';
                $data['division_name'] = 'งานวิจัย'; //สำหรับนอก med
            }
        } else {
            $data = [
                'reply_code' => 1,
                'reply_text' => 'Username or Password is incorrect',
                'found' => 'false',
            ];
        }


        $dataPassExp = [
            'password_expires_in_days' => 46
        ];

        if ($dataPassExp['password_expires_in_days'] < 1) {
            return ['reply_code' => '2', 'reply_text' => 'password หมดอายุ', 'found' => 'false'];
        }

        if ($data['found'] !== true) {
            return ['reply_code' => '1', 'reply_text' => 'ตรวจสอบ username หรือ password อีกครั้ง', 'found' => 'false'];
        }

        return $data;
    }
}
