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
    
	// Note that the verb here is differe from a Sale or Authorization. They use
	// POST, with this request we will use GET.
	$verb = "GET";
	
	// replace value after "reference=" with the transaction reference
    $url = "https://api-cert.sagepayments.com/ach/v1/charges?reference=C61HCDL8b0";
	
	// You can also use other parameters with the request such as orderNumber. More
	// details can be found at https://developer.sagepayments.com/ach/apis/get/charges
	//$url = "https://api-cert.sagepayments.com/ach/v1/charges?orderNumber=Invoice%20624";
	
    // the request is authorized via an HMAC header that we generate by
    // concatenating certain info, and then hashing it using our client key
	// Note that there is no $payload. There is no request body when performing
	// this type of request.
	$toBeHashed = $verb . $url . $merchantCredentials["ID"] . $nonce . $timestamp;
    $hmac = getHmac($toBeHashed, $developerCredentials["KEY"]);
    
    // ok, let's make the request! cURL is always an option, of course,
    // but i find that file_get_contents is a bit more intuitive.
	// Note there is no content header. Since there is no payload this is absent.
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
					if(array_key_exists('startDate', $response)) 
                    {
                        // Successful request
						debug_to_console( "file_get_contents: True" );
						echo '<pre>';
						print_r('HTTP Code: ' . $httpcode);
						echo '</pre>';
						echo '<pre>';
                        echo 'Request Successfully Submitted';
						echo '</pre>';
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
					}
        
                    // print the results
					echo '<pre>';
                    print_r($response);
                    echo '</pre>';
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