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

    // in this example we're going to use the vault to tokenize a credit card,
    // and then charge the credit card using the token.
    // this is great for situations where you're charging the same customer 
    // repeatedly -- why collect their data every single time? 
    
    $nonce = uniqid();
    $timestamp = (string)time();
    $requestData = [
        "CardData" => [
            "Number" => "5454545454545454",
            "Expiration" => "1019"
        ]
    ];
    $payload = json_encode($requestData);
    
    $verb = "POST";
    $url = "https://api-cert.sagepayments.com/bankcard/v1/tokens";

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
    
    // so now we should have a credit card stored in the vault.
    // at this point, we can run any transactions that usually require credit 
    // card data (or ACH data), and use our vault token instead.

    $nonce = uniqid();
    $timestamp = (string)time();
    $requestData = [
        "Ecommerce" => [
            "OrderNumber" => "Invoice " . rand(0, 1000),
            "Amounts" => [
                "Total" => "1.00"
            ]
            // notice that the "CardData" element is removed here...
        ],
        // .. and replaced with this "Vault" element.
        "Vault" => [
            "Token" => $response->vaultResponse->data,
            "Operation" => "Read" // CRUD
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

?>