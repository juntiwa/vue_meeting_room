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

        $url = config('app.auth_user.hannah_api_service_url').'auth';
        $response = Http::withHeaders($headers)->withOptions($options)
            ->post($url, ['login' => $login, 'password' => $password]);

        $data = json_decode($response->getBody(), true);

        if ($response->status() != 200) {
            return ['reply_code' => '1', 'reply_text' => 'request failed', 'found' => 'false'];
        }
        if (! $data['ok']) {
            return ['reply_code' => '1', 'reply_text' => 'ตรวจสอบ username หรือ password อีกครั้ง', 'found' => 'false'];
        }
        if (! $data['found']) {
            return ['reply_code' => '1', 'reply_text' => $data['body'], 'found' => 'false'];
        }
        $data['name'] = $data['full_name'];
        $data['remark'] = $data['office_name'].' '.$data['department_name'];
        $data['name_en'] = $data['full_name_en'];
        $data['reply_code'] = 0;

        return $data;
    }
}
