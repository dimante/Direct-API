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
        "retail" => [
        "amounts" => [
          "tip" => 4.24,
          "total" => 42.42,
          "tax" => 2.12,
          "shipping" => 1.06
        ],
        "cardPresent" => true,
        "trackData" => [
            "value" => "%B5454000000005454^CHASE PAYMENTECH TEST CARD^18120000000000000000?;5454000000005454=18120000000000000000?|0600|2C0CDB0967F97458428534F69F6B9951FC734AC91228815ABCF90EAF340F1010B2B6145A458B9AC969E3E9A0AC16DD12A5780086D28B3EE4C1B889AC39E183440BCD88B01A88CED7|40FFAAFFFC692660188B0401C5CEE925E73361A202A069CB54C8A31BC84B9D49CD698D0C2D1588DA||61403000|172DDC9BAABC3D054CEFA68505A832D1DEEAA4BE7B6449824F84849C215089CB93594A40BA97491BB239869EB14E26B427B12C575241820F|B02A41F120910AA|FBBD351008DEBAB0|9011880B02A41F0001B2|06B2||1000",
            "format" => "MagtekEncrypted"
        ],
        "customer" => [
          "email" => "kur@foo.com",
          "telephone" => "4846951106",
          "fax" => "4846951106"
        ],
    "orderNumber" => "",
        "billing" => [
      "name" => "foo",
      "address" => "way road",
      "city" => "",
      "state" => "",
      "postalCode" => "12345",
      "country" => "US"
    ],
    "shipping" => [
      "name" => "foo",
      "address" => "way road",
      "city" => "",
      "state" => "",
      "postalCode" => "12345",
      "country" => "US"
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