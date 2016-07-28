<?php

    // first, let's get some basic requirements assigned to variables:
    
    // developer credentials, via the dev portal
    $client_id = "kCy6zhnC7MYN9mgA4SxaKePUdxnBrJ5W";
    $client_key = "SeN0uFZtYhqN7gsJ";
    
    // merchant credentials -- ask us for a test account!
    $merchant_id = "417227771521";
    $merchant_key = "I5T2R2K6V1Q3";
    
    // the nonce can be any unique identifier -- guids and timestamps work well
    // duplicate values may be rejected
    $nonce = uniqid();
    
    // a standard unix timestamp. a request must be received within 60s
    // of its timestamp header.
    $timestamp = (string)time();
    
    // now the request data itself:
    $verb = "POST";
    $url = "https://api.sagepayments.com/bankcard/v1/charges?type=Sale";
    $requestArray = [
        "Ecommerce" => [
            "OrderNumber" => "Invoice123",
            "Amounts" => [
                "Total" => "1.00"
            ],
            "CardData" => [
                "Number" => "5454545454545454",
                "Expiration" => "1019"
            ]
        ]
    ];
    $payload = json_encode($requestArray);

    // the Authorization header expects an HMAC
    // we generate this HMAC by concatenating certain variables, 
    // and then hashing it using our developer key.
    
    // concat the request's HTTP verb, target URL, request body, merchant ID,
    // nonce, and timestamp. if you don't have a payload (eg, on a GET),
    // just use an empty string
    $toBeHashed = $verb . $url . $payload . $merchant_id . $nonce . $timestamp;
    
    // http://php.net/manual/en/function.hash-hmac.php
    $hash = hash_hmac(
        "sha512", // use the SHA-512 algorithm
        "",
        $client_key, // use your private dev key to sign
        true // php returns hexits by default; override this
    );
    
    
    echo base64_encode($hash);

?>