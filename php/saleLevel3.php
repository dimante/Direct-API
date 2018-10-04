<?php
/*----------------------------------------------
Author: SDK Support Group
Company: Paya
Contact: sdksupport@paya.com
!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
!!! Samples intended for educational use only!!!
!!!        Not intended for production       !!!
!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
-----------------------------------------------*/
    
    require("shared.php");

    // the nonce can be any unique identifier -- guids and timestamps work well
    $nonce = uniqid();
    
    // a standard unix timestamp. a request must be received within 60s
    // of its timestamp header.
    $timestamp = (string)time();
    
    // setting up the request data itself
    $verb = "POST";
    $url = "https://api-cert.sagepayments.com/bankcard/v1/charges?type=Sale";
    $requestData = [
    // complete reference material is available on the dev portal: https://developer.sagepayments.com/apis
    "ECommerce" => [
        "amounts" => [
            "tip" => 4.24,
            "total" => 42.42,
            "tax" => 2.12,
            "shipping" => 1.06
        ],
        "cardData" => [
            "number" => "4128123412341231",
            "expiration" => "0620",
            "cvv" => "123"
        ],
        "customer" => [
            "email" => "kur@foo.com",
            "telephone" => "4846951106",
            "fax" => "4846951106"
        ],
        "orderNumber" => "",
            "billing" => [
            "name" => "Level3 Sale",
            "address" => "way road",
            "city" => "Reston",
            "state" => "VA",
            "postalCode" => "12345",
            "country" => "US"
        ],
        "shipping" => [
            "name" => "foo",
            "address" => "123 Test road",
            "city" => "Reston",
            "state" => "VA",
            "postalCode" => "12345",
            "country" => "US"
        ],
        "level3" => [
            "destinationCountryCode" => "840",
            "amounts" => [
                "discount" => 10,
                "duty" => 0,
                "nationalTax" => 30
            ],
            "vat" => [
                "idNumber" => "vat123456789",
                "invoiceNumber" => "PO# 456",
                "amount" => 40,
                "rate" => 50
            ],
            "customerNumber" => "7890"
        ]

    ]
];
    // convert to json for transport
    $payload = json_encode($requestData);

    // the request is authorized via an HMAC header that we generate by
    // concatenating certain info, and then hashing it using our client key
    $toBeHashed = $verb . $url . $payload . $merchantCredentials["ID"] . $nonce . $timestamp;
    $hmac = getHmac($toBeHashed, $developerCredentials["KEY"]);


    // ok, let's make the request! cURL is always an option, of course,
    // but i find that file_get_contents is a bit more intuitive.
    $config = [
        "http" => [
            "header" => [
                "clientId: " . $developerCredentials["ID"],
                "merchantId: " . $merchantCredentials["ID"],
                "merchantKey: " . $merchantCredentials["KEY"],
                "nonce: " . $nonce,
                "timestamp: " . $timestamp,
                "authorization: " . $hmac,
                "content-type: application/json",
            ],
            "method" => $verb,
            "content" => $payload,
            "ignore_errors" => true // exposes response body on 4XX errors
        ]
    ];
    $context = stream_context_create($config);
    $result = file_get_contents($url, false, $context);
    $response = json_decode($result);
    
    echo '<pre>';
    print_r($response);
    echo '</pre>';

?>
