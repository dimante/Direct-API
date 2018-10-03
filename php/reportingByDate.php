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

    $verb = "GET";
    $url = "https://api-cert.sagepayments.com/bankcard/v1/charges?startDate=2016-09-02&endDate=2016-10-10&pageSize=250&pageNumber=1";

    $toBeHashed = $verb . $url . $merchantCredentials["ID"] . $nonce . $timestamp;
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

?>