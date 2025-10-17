<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TelegramGatewayService
{
    private $apiId;
    private $apiHash;
    private $accessToken;
    private $baseUrl = 'https://gatewayapi.telegram.org';

    public function __construct()
    {
        $this->apiId = config('services.telegram_gateway.api_id');
        $this->apiHash = config('services.telegram_gateway.api_hash');
        $this->accessToken = config('services.telegram_gateway.access_token');
    }

    public function sendVerificationMessage($phone)
    {
        try {
            $response = Http::post("{$this->baseUrl}/sendVerificationMessage", [
                'api_id' => $this->apiId,
                'api_hash' => $this->apiHash,
                'phone_number' => $phone,
                'request_id' => uniqid('req_', true)
            ]);

            if ($response->successful()) {
                return $response->json();
            }

            Log::error('Telegram Gateway Error', ['response' => $response->body()]);
            return false;
        } catch (\Exception $e) {
            Log::error('Telegram Gateway Exception', ['error' => $e->getMessage()]);
            return false;
        }
    }

    public function checkVerificationStatus($requestId, $code)
    {
        try {
            $response = Http::post("{$this->baseUrl}/checkVerificationStatus", [
                'api_id' => $this->apiId,
                'api_hash' => $this->apiHash,
                'request_id' => $requestId,
                'code' => $code
            ]);

            if ($response->successful()) {
                return $response->json();
            }

            return false;
        } catch (\Exception $e) {
            Log::error('Telegram Gateway Check Exception', ['error' => $e->getMessage()]);
            return false;
        }
    }
}