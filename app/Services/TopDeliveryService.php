<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Log;
use SoapClient;

class TopDeliveryService
{
    private $soapClient;

    private $authLogin;

    private $authPassword;

    private $soapLogin;

    private $soapPassword;

    private $wsdlUrl;

    public function __construct()
    {
        $this->authLogin    = config('topdelivery.auth_login');
        $this->authPassword = config('topdelivery.auth_password');
        $this->soapLogin    = config('topdelivery.soap_login');
        $this->soapPassword = config('topdelivery.soap_password');
        $this->wsdlUrl      = config('topdelivery.wsdl_url');

        try {
            $this->soapClient = new SoapClient($this->wsdlUrl, [
                'login'      => $this->soapLogin,
                'password'   => $this->soapPassword,
                'exceptions' => true,
                'trace'      => 1,
                'cache_wsdl' => WSDL_CACHE_NONE,
            ]);
        } catch (Exception $e) {
            throw new Exception('SOAP client initialization failed: ' . $e->getMessage());
        }
    }

    public function setShipmentOnTheWay(int $shipmentId)
    {
        $params = [
            'auth' => [
                'login'    => $this->authLogin,
                'password' => $this->authPassword,
            ],
            'shipmentId' => $shipmentId,
        ];

        $response = $this->soapClient->__soapCall('setShipmentOnTheWay', [$params]);

        Log::channel('top_delivery')->info('SetShipmentOnTheWay API Call', [
            'request'  => $params,
            'response' => $response,
        ]);

        return $response;
    }

    public function getOrdersInfo(array $data)
    {
        $params = [
            'auth' => [
                'login'    => $this->authLogin,
                'password' => $this->authPassword,
            ],
            'order' => [
                'orderId'       => $data['orderId'],
                'barcode'       => $data['barcode'],
                'webshopNumber' => $data['webshopNumber'],
            ],
        ];

        $response = $this->soapClient->__soapCall('getOrdersInfo', [$params]);

        Log::channel('top_delivery')->info('getOrdersInfo API Call', [
            'request'  => $params,
            'response' => $response,
        ]);

        return $response;
    }

    public function setRegions()
    {
        $params = [
            'auth' => [
                'login'    => $this->authLogin,
                'password' => $this->authPassword,
            ],
            //            'regionId' => 32,
        ];

        $response = $this->soapClient->__soapCall('getCitiesRegions', [$params]);

        Log::channel('top_delivery')->info('getCitiesRegions API Call', [
            'request'  => $params,
            'response' => $response,
        ]);

        return $response;
    }

    public function addShipment(array $data)
    {
        try {
            $params = [
                'auth' => [
                    'login'    => $this->authLogin,
                    'password' => $this->authPassword,
                ],
                'addedShipmentInfo' => [
                    'intake' => [
                        'need'       => 1,
                        'address'    => $data['intake_address'],
                        'contacts'   => $data['intake_contacts'],
                        'intakeDate' => [
                            'date'         => $data['intake_date'],
                            'timeInterval' => [
                                'bTime' => $data['intake_b_time'],
                                'eTime' => $data['intake_e_time'],
                            ],
                        ],
                    ],
                    'comment' => $data['comment'] ?? '',
                    'orders'  => $data['orders'],
                    'places'  => $data['places'],
                ],
            ];

            $response = $this->soapClient->__soapCall('addShipment', [$params]);

            Log::channel('top_delivery')->info('AddShipment API Request', [
                'request'  => $params,
                'response' => $response,
            ]);

            return $response;
        } catch (SoapFault $e) {
            Log::channel('top_delivery')->error('SOAP Fault in addShipment', [
                'error' => $e->getMessage(),
                'data'  => $data,
            ]);
            throw new Exception('SOAP request failed: ' . $e->getMessage());
        } catch (Exception $e) {
            Log::channel('top_delivery')->error('Error in addShipment', [
                'error' => $e->getMessage(),
                'data'  => $data,
            ]);
            throw $e;
        }
    }

    /**
     * Create a new order in TopDelivery system
     *
     * @return string Returns the barcode
     *
     * @throws Exception
     */
    public function createOrder(array $orderData): array
    {
        $params = [
            'addOrders' => [
                'auth' => [
                    'login'    => $this->authLogin,
                    'password' => $this->authPassword,
                ],
                'addedOrders' => [$orderData],
            ],
        ];

        $response = $this->soapClient->__call('addOrders', $params);

        Log::channel('top_delivery')->info('TopDelivery API Response', [
            'request'  => $params,
            'response' => $response,
        ]);

        if (
            isset($response->requestResult) && 0 == $response->requestResult->status && isset($response->addOrdersResult) && 0 == $response->addOrdersResult->status
        ) {
            $barcode = $response->addOrdersResult->orderIdentity->barcode ?? null;
            $orderId = $response->addOrdersResult->orderIdentity->orderId ?? null;
            if ( ! $barcode) {
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
     */
    public function prepareOrderData(
        array $items,
        ?float $weight,
        array $customerInfo,
        string $orderNumber,
        $order,
    ): array {
        return [
            'serviceType'           => 'DELIVERY',
            'orderSubtype'          => 'SIMPLE',
            'deliveryType'          => 'COURIER',
            'webshopNumber'         => $orderNumber,
            'webshopBarcode'        => '6814c92012824',
            'paymentByCard'         => 0,
            'deliveryCostPayAnyway' => 0,
            'execution'             => [
                'executorId' => 0,
            ],
//            'desiredDateDelivery' => [
//                'date'         => now()->addDays(3)->format('Y-m-d'),
//                'timeInterval' => [
//                    'bTime' => '10:00',
//                    'eTime' => '18:00',
//                ],
//            ],
            'deliveryAddress' => [
                'type'          => 'id',
                'region'        => $order->regionId,
                'city'          => $order->cityId,
                'inCityAddress' => [
                    'zipcode' => '101753',
                    'address' => $order->address,
                ],
            ],
            'clientInfo' => [
                'fio'   => $customerInfo['name']  ?? 'Unknown Customer',
                'phone' => $customerInfo['phone'] ?? '0000000000',
            ],
            'clientCosts' => [
                'discount' => [
                    'type'  => 'SUM',
                    'value' => 0,
                ],
                'clientDeliveryCost' => 0,
                'recalcDelivery'     => 0,
            ],
            'services' => [
                'notOpen'   => 0,
                'marking'   => 0,
                'smsNotify' => 0,
                'forChoise' => 1,
                'places'    => 1,
                'pack'      => [
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
                    'width'  => 5,
                ],
            ],
            'items' => $items,
        ];
    }

    public function printOrderAct(int $orderId, string $barcode, string $webshopNumber): string
    {
        $printWsdl = config('topdelivery.print_wsdl_url');

        $printClient = new SoapClient($printWsdl, [
            'login'      => $this->soapLogin,
            'password'   => $this->soapPassword,
            'trace'      => 1,
            'exceptions' => true,
        ]);

        $params = [
            'auth' => [
                'login'    => $this->authLogin,
                'password' => $this->authPassword,
            ],
            'orderIdentity' => [
                'orderId'       => $orderId,
                'barcode'       => $barcode,
                'webshopNumber' => $webshopNumber,
            ],
        ];

        $response = $printClient->__soapCall('printOrderDeliveryList', [$params]);

        Log::channel('top_delivery')->info('printOrderAct API Response', [
            'request'  => $params,
            'response' => $response]);

        if (
            isset($response->requestResult) && 0 === $response->requestResult->status && ! empty($response->reportUrl)
        ) {
            return $response->reportUrl;
        }

        throw new Exception('Unable to get report URL from TopDelivery: ' . json_encode($response));
    }
}
