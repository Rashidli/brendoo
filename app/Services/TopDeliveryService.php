<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Log;

class TopDeliveryService
{
    private $soapClient;
    private $authLogin = 'webshop';
    private $authPassword = 'pass';
    private $soapLogin = 'tdsoap';
    private $soapPassword = '5f3b5023270883afb9ead456c8985ba8';
    private $wsdlUrl = 'https://is-test.topdelivery.ru/api/soap/w/2.0/?wsdl';

    public function __construct()
    {
        try {
            $this->soapClient = new \SoapClient($this->wsdlUrl, [
                'login' => $this->soapLogin,
                'password' => $this->soapPassword
            ]);
        } catch (Exception $e) {
            throw new Exception('SOAP client initialization failed: ' . $e->getMessage());
        }
    }

    /**
     * Create a new order in TopDelivery system
     *
     * @param array $orderData
     * @return string Returns the barcode
     * @throws Exception
     */
    public function createOrder(array $orderData): array
    {
        $params = [
            'addOrders' => [
                'auth' => [
                    'login' => $this->authLogin,
                    'password' => $this->authPassword,
                ],
                'addedOrders' => [$orderData],
            ]
        ];

        $response = $this->soapClient->__call('addOrders', $params);

        Log::channel('top_delivery')->info('TopDelivery API Response', ['response' => $response]);

        if (
            isset($response->requestResult) &&
            $response->requestResult->status == 0 &&
            isset($response->addOrdersResult) &&
            $response->addOrdersResult->status == 0
        ) {
            $barcode = $response->addOrdersResult->orderIdentity->barcode ?? null;
            $orderId = $response->addOrdersResult->orderIdentity->orderId ?? null;
            if (!$barcode) {
                throw new Exception('Missing barcode in order data');
            }

            return [
                'barcode' => $barcode,
                'orderId' => $orderId,
            ];
        }

        throw new Exception('Order not successfully created: ' . json_encode($response));
    }


    /**
     * Prepare order data for TopDelivery API
     *
     * @param array $items
     * @param float|null $weight
     * @param array $customerInfo
     * @param string $orderNumber
     * @return array
     */
    public function prepareOrderData(
        array $items,
        ?float $weight,
        array $customerInfo,
        string $orderNumber
    ): array {
        return [
            'serviceType' => 'DELIVERY',
            'orderSubtype' => 'SIMPLE',
            'deliveryType' => 'PICKUP',
            'webshopNumber' => 'test202522042',
            'paymentByCard' => 0,
            'desiredDateDelivery' => [
                'date' => now()->addDays(3)->format('Y-m-d'),
                'timeInterval' => [
                    'bTime' => '10:00',
                    'eTime' => '18:00'
                ]
            ],
            'deliveryAddress' => [
                'type' => 'pickup',
                'zipcode' => '102049',
                'pickupAddress' => [
                    'id' => '20',
                ]
            ],
            'clientInfo' => [
                'fio' => $customerInfo['name'] ?? 'Unknown Customer',
                'phone' => $customerInfo['phone'] ?? '0000000000',
            ],
            'clientCosts' => [
                'discount' => [
                    'type' => 'SUM',
                    'value' => 0,
                ],
                'clientDeliveryCost' => 0,
                'recalcDelivery' => 0,
            ],
            'services' => [
                'notOpen' => 0,
                'marking' => 0,
                'smsNotify' => 0,
                'forChoise' => 1,
                'places' => 1,
                'pack' => [
                    'need' => 0,
                    'type' => '',
                ],
                'giftPack' => [
                    'need' => 0,
                    'type' => '',
                ],
            ],
            'deliveryWeight' => [
                'weight' => 100, // convert kg to grams
//                'weight' => $weight ??  1000, // convert kg to grams
                'volume' => [
                    'length' => 10,
                    'height' => 3,
                    'width' => 5,
                ],
            ],
            'items' => $items,
        ];
    }

    public function printOrderAct(int $orderId, string $barcode, string $webshopNumber): string
    {
        $printWsdl = 'https://is-test.topdelivery.ru/api/soap/print/2.0/?wsdl';

        $printClient = new \SoapClient($printWsdl, [
            'login'    => $this->soapLogin,
            'password' => $this->soapPassword,
            'trace'    => 1,
            'exceptions' => true
        ]);

        $params = [
            'auth' => [
                'login'    => $this->authLogin,
                'password' => $this->authPassword,
            ],
            'orderIdentity' => [
                'orderId'        => $orderId,
                'barcode'        => $barcode,
                'webshopNumber'  => $webshopNumber,
            ]
        ];

        $response = $printClient->__soapCall('printOrderAct', [$params]);

        Log::channel('top_delivery')->info('printOrderAct API Response', ['response' => $response]);

        if (
            isset($response->requestResult) &&
            $response->requestResult->status === 0 &&
            !empty($response->reportUrl)
        ) {
            return $response->reportUrl;
        }

        throw new \Exception('Unable to get report URL from TopDelivery: ' . json_encode($response));
    }


    public function addShipment(array $data)
    {
        $client = new \SoapClient(config('topdelivery.wsdl_url'));

        $params = [
            'auth' => [
                'login' => config('topdelivery.login'),
                'password' => config('topdelivery.password'),
            ],
            'addedShipmentInfo' => [
                'intake' => [
                    'need' => 1,
                    'address' => $data['intake_address'], // məsələn: "Bakı, Nərimanov, Əhməd Rəcəbli 12"
                    'contacts' => $data['intake_contacts'], // məsələn: "+994501234567"
                    'intakeDate' => [
                        'date' => $data['intake_date'], // format: "2025-05-01"
                        'timeInterval' => [
                            'bTime' => $data['intake_b_time'], // format: "09:00:00"
                            'eTime' => $data['intake_e_time'], // format: "18:00:00"
                        ]
                    ],
                ],
                'comment' => $data['comment'] ?? '',
                'orders' => [
                    [
                        'orderId' => $data['order_id'],
                        'barcode' => $data['barcode'],
                        'webshopNumber' => $data['webshop_number'],
                    ]
                ],
                'places' => [
                    [
                        'number' => $data['place_number'], // unikal string nömrə
                        'weight' => $data['weight'],       // məsələn: 2.5
                        'pallets' => $data['pallets'] ?? 0,
                    ]
                ]
            ]
        ];

        return $client->__soapCall('addShipment', [$params]);
    }

    public function setShipmentOnTheWay(int $shipmentId)
    {
        $client = new \SoapClient(config('topdelivery.wsdl_url'));

        $params = [
            'auth' => [
                'login' => config('topdelivery.login'),
                'password' => config('topdelivery.password'),
            ],
            'shipmentId' => $shipmentId,
        ];

        return $client->__soapCall('setShipmentOnTheWay', [$params]);
    }



}
