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
    $nonce = uniqid();
    $timestamp = (string)time();
    
    // we dont need a request body for this one
    $payload = "";

    // if you're familiar wtih RESTful APIs, you might have guessed this part:
    // we're going to make a DELETE request to update the previous transaction.
    $verb = "DELETE";
    $url = "https://api-cert.sagepayments.com/token/v1/tokens/99e01ac895a0429e894e360afe4be378";

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