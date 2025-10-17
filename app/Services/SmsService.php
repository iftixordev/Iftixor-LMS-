<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SmsService
{
    private $email;
    private $password;
    private $baseUrl = 'https://notify.eskiz.uz/api';

    public function __construct()
    {
        $this->email = config('services.sms.email');
        $this->password = config('services.sms.password');
    }

    private function getToken()
    {
        try {
            $response = Http::timeout(30)->post("{$this->baseUrl}/auth/login", [
                'email' => $this->email,
                'password' => $this->password
            ]);

            Log::info('SMS Auth Response', ['status' => $response->status(), 'body' => $response->body()]);

            if ($response->successful()) {
                $data = $response->json();
                return $data['data']['token'] ?? null;
            }

            Log::error('SMS Auth Error', ['status' => $response->status(), 'response' => $response->body()]);
            return null;
        } catch (\Exception $e) {
            Log::error('SMS Auth Exception', ['error' => $e->getMessage()]);
            return null;
        }
    }

    public function sendSms($phone, $message)
    {
        $token = $this->getToken();
        if (!$token) {
            Log::error('SMS Token Error', ['email' => $this->email]);
            return false;
        }

        try {
            $response = Http::timeout(30)->withHeaders([
                'Authorization' => 'Bearer ' . $token
            ])->post("{$this->baseUrl}/message/sms/send", [
                'mobile_phone' => $phone,
                'message' => $message,
                'from' => '4546'
            ]);

            Log::info('SMS Send Response', ['status' => $response->status(), 'body' => $response->body()]);

            if ($response->successful()) {
                return $response->json();
            }

            Log::error('SMS Send Error', ['status' => $response->status(), 'response' => $response->body()]);
            return false;
        } catch (\Exception $e) {
            Log::error('SMS Send Exception', ['error' => $e->getMessage()]);
            return false;
        }
    }

    public function sendVerificationCode($phone)
    {
        $code = str_pad(random_int(10000, 99999), 5, '0', STR_PAD_LEFT);
        $message = "Tasdiqlash kodi: {$code}";
        
        $result = $this->sendSms($phone, $message);
        
        if ($result) {
            return [
                'success' => true,
                'code' => $code,
                'message_id' => $result['id'] ?? null
            ];
        }
        
        return ['success' => false];
    }
}