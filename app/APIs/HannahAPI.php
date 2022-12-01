<?php

namespace App\APIs;

use App\Contracts\AuthUserAPI;
use Illuminate\Support\Facades\Http;

class HannahAPI implements AuthUserAPI
{
    public function authenticate($login, $password)
    {
        $headers = ['app' => config('app.auth_user.hannah_api_service_secret'), 'token' => config('app.auth_user.hannah_api_service_token')];
        $options = ['timeout' => 8.0, 'verify' => false];

        $checkPassExp = Http::withHeaders($headers)->post(config('app.auth_user.hannah_api_service_expires'),['login' => $login]);

        $dataPassExp = json_decode($checkPassExp->getBody(), true);

        if (!$dataPassExp['found']) {
            return ['reply_code' => '1', 'reply_text' => 'ตรวจสอบ username อีกครั้ง', 'found' => 'false'];
        }

        if ($dataPassExp['password_expires_in_days'] < 1) {
            return ['reply_code' => '2', 'reply_text' => 'รหัสผ่านหมดอายุ กด "ลืมรหัสผ่าน?" ด้านล่างเพื่อรีเซ็ตรหัสผ่าน', 'found' => 'false'];
        }

        $url = config('app.auth_user.hannah_api_service_url').'auth';
        $response = Http::withHeaders($headers)->withOptions($options)
            ->post($url, ['login' => $login, 'password' => $password]);

        $data = json_decode($response->getBody(), true);

        if ($response->status() != 200) {
            return ['reply_code' => '1', 'reply_text' => 'request failed', 'found' => 'false'];
        }

        if ($data['found'] !== true) {
            return ['reply_code' => '1', 'reply_text' => 'ตรวจสอบ username หรือ password อีกครั้ง', 'found' => 'false'];
        }

        $data['reply_code'] = 0;

        return $data;
    }
}
