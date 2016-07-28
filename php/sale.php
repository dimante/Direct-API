<?php
    
    // ===============================
    // SAMPLE DIRECT API REQUEST - PHP
    // Majid Razvi
    // Software Engineer
    // Sage Payment Solutions
    // July 28th, 2016
    // Standard MIT License.
    // ===============================
    
    // your developer credentials
    $client_id = "kCy6zhnC7MYN9mgA4SxaKePUdxnBrJ5W";
    $client_key = "SeN0uFZtYhqN7gsJ";
    
    // you (or your client's) merchant credentials.
    // grab a test account from us for development!
    $merchant_id = "417227771521";
    $merchant_key = "I5T2R2K6V1Q3";
    
    // the nonce can be any unique identifier -- guids and timestamps work well
    $nonce = uniqid();
    
    // a standard unix timestamp. a request must be received within 60s
    // of its timestamp header.
    $timestamp = (string)time();
    
    // setting up the request data itself
    $verb = "POST";
    $url = "https://api.sagepayments.com/bankcard/v1/charges?type=Sale";
    $requestData = [
        // this is a pretty minimalistic example...
        // complete reference material is available on the dev portal.
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
    // convert to json for transport
    $payload = json_encode($requestData);

    // the request is authorized via an HMAC header that we generate by
    // concatenating certain info, and then hashing it using our client key
    $toBeHashed = $verb . $url . $payload . $merchant_id . $nonce . $timestamp;
    $hmac = hash_hmac(
        "sha512", // use the SHA-512 algorithm...
        $toBeHashed, // ... to hash the combined string...
        $client_key, // .. using your private dev key to sign it.
        true // (php returns hexits by default; override this)
    );
    // convert to base-64 for transport
    $hmac_b64 = base64_encode($hmac);

    // ok, let's make the request! cURL is always an option, of course,
    // but i find that file_get_contents is a bit more intuitive.
    $config = [
        "http" => [
            "header" => [
                "clientId: " . $client_id,
                "merchantId: " . $merchant_id,
                "merchantKey: " . $merchant_key,
                "nonce: " . $nonce,
                "timestamp: " . $timestamp,
                "authorization: " . $hmac_b64,
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