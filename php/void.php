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

    // first, let's get set up exactly like we did in the sale sample
    
    $nonce = uniqid();
    $timestamp = (string)time();
    $requestData = [
        "Ecommerce" => [
            "OrderNumber" => "Invoice " . rand(0, 1000),
            "Amounts" => [
                "Total" => "1.00"
            ],
            "CardData" => [
                "Number" => "5454545454545454",
                "Expiration" => "1019"
            ]
        ]
    ];
    $payload = json_encode($requestData);
    
    $verb = "POST";
    $url = "https://api-cert.sagepayments.com/bankcard/v1/charges?type=Sale";

    $toBeHashed = $verb . $url . $payload . $merchantCredentials["ID"] . $nonce . $timestamp;
    $hmac = getHmac($toBeHashed, $developerCredentials["KEY"]);
    
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
    
    // ---------------------------------------------------------------
    
    // so, now we should have an approved charge -- what if we need to cancel it? 
    // if it's still in our open batch (which usually = it's the same day), we 
    // can void it out. if it's already been settled, we have to credit it.

    // we'll need a new nonce and timestamp:
    $nonce = uniqid();
    $timestamp = (string)time();
    
    // we dont need a request body for this one
    $payload = "";

    // if you're familiar wtih RESTful APIs, you might have guessed this part:
    // we're going to make a DELETE request to update the previous transaction.
    $verb = "DELETE";
    $url = "https://api-cert.sagepayments.com/bankcard/v1/charges/" . $response->reference;

    // and then hmac...
    $toBeHashed = $verb . $url . $payload . $merchantCredentials["ID"] . $nonce . $timestamp;
    $hmac = getHmac($toBeHashed, $developerCredentials["KEY"]);
    
    // ... and submit!
    
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
            "ignore_errors" => true // exposes response body on 4XX errors
        ]
    ];
    $context = stream_context_create($config);
    $result = file_get_contents($url, false, $context);
    $response = json_decode($result);
    
    echo '<pre>';
    print_r($response);
    print_r($http_response_header);
    echo '</pre>';

?>