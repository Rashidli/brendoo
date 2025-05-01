<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PaymentService
{
    protected string $baseUrl;
    protected string $token;

    public function __construct()
    {
        $this->baseUrl = config('tochka.is_sandbox')
            ? 'https://enter.tochka.com/sandbox/v2/acquiring/v1.0/payments'
            : 'https://enter.tochka.com/uapi/acquiring/v1.0/payments';

        $this->token = config('tochka.api_token');
    }

    /**
     * Create payment operation with receipt
     * @param array $data
     * @return array
     */
    public function createPayment(array $data)
    {
        try {

            $response = Http::withHeaders([

                'Authorization' => 'Bearer ' . $this->token,
                'Content-Type' => 'application/json',

            ])->post("{$this->baseUrl}", [

                'Data' => [

                    "customerCode" => "304743305",
                    "amount" => $data['final_price'],
                    "purpose" => "Оплата товара.",

                    "paymentMode" => [
                        "sbp",
                        "card",
                        "tinkoff"
                    ],

                    "redirectUrl" => "https://brendoo.com/success",
                    "failRedirectUrl" => "https://brendoo.com/fail",

                ]

            ]);

            return $response->json();

        } catch (\Exception $e) {

            Log::error('PaymentService error => ' . $e->getMessage());
            return [
                'error' => true,
                'message' => $e->getMessage(),
            ];

        }
    }

    public function checkPaymentStatus(string $operation_id)
    {
        try {

            $response = Http::withHeaders([

                'Authorization' => 'Bearer ' . $this->token,
                'Content-Type' => 'application/json',

            ])->get("{$this->baseUrl}/$operation_id", [

            ]);

            return $response->json();

        } catch (\Exception $e) {

            Log::error('PaymentService error => ' . $e->getMessage());
            return [
                'error' => true,
                'message' => $e->getMessage(),
            ];

        }
    }
}
