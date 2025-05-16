<?php

return [

    'auth_login' => env('TOPDELIVERY_AUTH_LOGIN', 'webshop'),
    'auth_password' => env('TOPDELIVERY_AUTH_PASSWORD', 'pass'),
    'soap_login' => env('TOPDELIVERY_SOAP_LOGIN', 'tdsoap'),
    'soap_password' => env('TOPDELIVERY_SOAP_PASSWORD'),
    'wsdl_url' => env('TOPDELIVERY_WSDL_URL'),
    'print_wsdl_url' => env('TOPDELIVERY_PRINT_WSDL_URL'),

];
