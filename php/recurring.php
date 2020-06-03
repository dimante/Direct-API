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
        // this is a pretty minimalistic example...
        // complete reference material is available on the dev portal.
        "Ecommerce" => [
            "OrderNumber" => "Invoice " . rand(0, 1000),
            "Amounts" => [
                "Total" => "1.00"
            ],
            "CardData" => [
                "Number" => "5454545454545454",
                "Expiration" => "1230"
            ],
            "billing" => [
              "name" => "SDK Test",
              "address" => "123 Main St",
              "city" => "Savannah",
              "state" => "GA",
              "postalCode" => "31405",
              "country" => "US",
            ],
            "isRecurring" => true, // indicates this transaction is part of a recurring set of transactions. Set to true if you are managing the recurring schedule and sending a vault token/GUID or if you also want to use our recurring service by including the following recurringSchedule fields
            "recurringSchedule" => [
              "amount" => 10, //Amount of the Recurring transaction. This can be different from the initial charge.
              "frequency" => "Monthly", //Indicates whether the Recurring trx will be "Monthly" or "Daily".
              "interval" => 1, //Indicates how you want your "Monthly" or "Daily" recurring to process. For example, an interval of "1" on a "Monthly" frequency means Once a Month. An interval of "7" on a "Daily" frequency means Once a Week.
              "nonBusinessDaysHandling" => "ThatDay", //Indicates if the recurring will be processed "That Day" (same day), "Before" (weekend or holiday), or "After" (weekend or holiday).
              "startDate" => "06/04/2020", //Can be M/DD/YY or MM/DD/YYYY
              "totalCount" => 0, //How many times the Recurring transactions will be processed. If the "interval" string is set to "0" you must enter a number. If not, leave the totalCount at "0".
              "groupId" => "42401" //You'll need to create a Group in the VT to get a groupId number.
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
