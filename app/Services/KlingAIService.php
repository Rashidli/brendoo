<?php

namespace App\Services;
use Firebase\JWT\JWT;
use Illuminate\Support\Facades\Http;
class KlingAIService
{
    private $accessKey;
    private $secretKey;
    private $apiBaseUrl = 'https://api.klingai.com';

    public function __construct()
    {
        $this->accessKey = config('services.kling.access_key');
        $this->secretKey = config('services.kling.secret_key');
    }

    private function generateToken()
    {
        $headers = [
            "alg" => "HS256",
            "typ" => "JWT"
        ];

        $payload = [
            "iss" => $this->accessKey,
            "exp" => time() + 1800, // 30 minutes expiration
            "nbf" => time() - 5    // Not before 5 seconds ago
        ];

        return JWT::encode($payload, $this->secretKey, 'HS256', null, $headers);
    }

    public function submitVirtualTryOn(array $data)
    {
        $token = $this->generateToken();

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
            'Content-Type' => 'application/json',
        ])->post($this->apiBaseUrl . '/v1/images/kolors-virtual-try-on', $data);

        return $response->json();
    }

    public function checkTaskStatus(string $taskId)
    {
        $token = $this->generateToken();

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
            'Content-Type' => 'application/json',
        ])->get($this->apiBaseUrl . '/v1/images/kolors-virtual-try-on/' . $taskId);

        return $response->json();
    }
}
