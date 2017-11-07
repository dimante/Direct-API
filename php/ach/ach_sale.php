<?php

/*----------------------------------------------
Author: SDK Support Group
Company: Sage Payment Solutions
Contact: sdksupport@sage.com
!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
!!! Samples intended for educational use only!!!
!!!        Not intended for production       !!!!!!!!!!!
!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
-----------------------------------------------*/
    
    require("shared.php");
	
    // the nonce can be any unique identifier -- guids and timestamps work well
    $nonce = uniqid();
    
    // a standard unix timestamp. a request must be received within 60s
    // of its timestamp header.
    $timestamp = (string)time();
    
    // setting up the request data itself
    $verb = "POST";
    $url = "https://api-cert.sagepayments.com/ach/v1/charges";
	$requestData = [
        // this is a pretty minimalistic example...
        // complete reference material is available on the dev portal.
		// at https://developer.sagepayments.com/ach/apis
        "orderNumber" => "Invoice " . rand(0, 1000),
		"secCode" => "PPD",
        "amounts" => [
			"total" => "10.01"
        ],
        "account" => [
			"type" => "Checking", 
            "routingNumber" => "056008849",
			"accountNumber" => "12345678901234"
        ],
		"billing" => [
			"name" => [
				"first" => "John", 
				"middle" => "",
				"last" => "Simpson",
				"suffix" => "Dr."
			], 
            "address" => "123 Main St",
			"city" => "Savannah",
			"state" => "GA",
			"postalCode" => "31405",
			"country" => "US"
        ],
		"addenda" => "Widgets",
		"isRecurring" => false,
		"vault" => [
			"operation" => "Create"
        ],
		"memo" => "Test ACH Sale in Dev Portal"
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
    
	
	// Process request and perform error checking.
	try {
              $context = stream_context_create($config);
			  $result = file_get_contents($url, false, $context);
              $response = json_decode($result);
			  $httpcode = http_response_code();

			  
			// file_get_contents will return a true or false based on the success or failure of the connection  
            if($result == FALSE) 
            { 
                debug_to_console( "file_get_contents: False" );
				echo '<pre>';
				print_r('HTTP Code: ' . $httpcode);
				echo '</pre>';
				echo '<pre>';
				echo 'Error: Failed to read page'; 
				echo '</pre>';
				exit();
			} 
            else 
            {
                // check to see if the results are empty
				if (empty($result)){
					debug_to_console( "Error: Empty Result" );
					echo '<pre>';
					print_r('HTTP Code: ' . $httpcode);
					echo '</pre>';
					echo '<pre>';
                    echo 'Error Empty Result';
					echo '</pre>';
                    print_r(json_encode($result));
					exit();
                }
                else 
                {
                    // If the "status" key is present then the transaction either approved or declined. Otherwise
					// the result will contain a code with an error
					if(array_key_exists('status', $response)) 
                    {
                        // Successful request
						debug_to_console( "file_get_contents: True" );
						echo '<pre>';
						print_r('HTTP Code: ' . $httpcode);
						echo '</pre>';
						echo '<pre>';
                        echo 'Request Successfully Submitted';
						echo '</pre>';
						echo '<pre>';
						print 'Status: '. $response->{'status'};
						echo '</pre>';
						echo '<pre>';
						print 'Reference: '. $response->{'reference'};
						echo '</pre>';
						echo '<pre>';
						print 'Message: '. $response->{'message'};
						echo '</pre>';
						echo '<pre>';
						print 'Order Number: '. $response->{'orderNumber'};
						echo '</pre>';
						echo '<pre>';
						print 'Vault Response Status: '. $response->{'vaultResponse'}->{'status'};
						echo '</pre>';
						echo '<pre>';
						print 'Vault Response Message: '. $response->{'vaultResponse'}->{'message'};
						echo '</pre>';
						echo '<pre>';
						print 'Vault Token: '. $response->{'vaultResponse'}->{'data'};
						echo '</pre>';
						echo '<pre>';
						print_r($response);
						echo '</pre>';
						exit();
                    }
                    else 
                    {
                        // failed request
						debug_to_console( "Error response from server!" );
						echo '<pre>';
						print_r('HTTP Code: ' . $httpcode);
						echo '</pre>';
						echo '<pre>';
                        echo 'Error response from the server!';
						echo '</pre>';
                        echo '<pre>';
						print 'Error Code: '. $response->{'code'};
						echo '</pre>';
						echo '<pre>';
						print 'Error Message: '. $response->{'message'};
						echo '</pre>';
						echo '<pre>';
						print 'Error Information: '. $response->{'info'};
						echo '</pre>';
						echo '<pre>';
						print 'Error Details: '. $response->{'detail'};
						echo '</pre>';
						echo '<pre>';
						print_r($response);
						echo '</pre>';
						exit();
					}
        
                }
            }
            
        }
		
		// Catch and print any exceptions
		catch (Exception $ex) {
            debug_to_console( $ex );
			print_r($ex);
			exit();
        }

?>
