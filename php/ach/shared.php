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

    // You (or your client's) merchant credentials.
    // grab a test account from us for development!
	// If you would like a merchant test account, please
	// email us at sdksupport@paya.com, otherwise
	// you are welcome to test with the credentials below.
    $merchantCredentials = [
       "ID" => "173859436515",
       "KEY" => "P1J2V8P2Q3D8"
    ];
    
	// Your application's credentials. In order to obtain
	// your individual developer credentials you must
	// register with the developer portal at https://developer.sagepayments.com
	// and setup an app under "My Apps".
    $developerCredentials = [
       "ID" => "W8yvKQ5XbvAn7dUDJeAnaWCEwA4yXEgd",
       "KEY" => "iLzODV5AUsCGWGkr"
    ];

	
	function getHmac($toBeHashed, $privateKey){
       
        $hmac = hash_hmac(
            "sha512", // use the SHA-512 algorithm...
            $toBeHashed, // ... to hash the combined string...
            $privateKey, // .. using your private dev key to sign it.
            true // (php returns hexits by default; override this)
        );
        // convert to base-64 for transport
        $hmac_b64 = base64_encode($hmac);
        return $hmac_b64;
    }
	
	// This function allows you to easily print data to the console
	// for debugging. 
	// !!!!!!!!!!!!!!!!!!!!!!!!  IMPORTANT NOTE  !!!!!!!!!!!!!!!!!!!!!!!!!!!!!
	// Please make sure you are not printing PCI-
	// sensitive data to the console when moving to production.
	// !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
	function debug_to_console( $data ) {
		$output = $data;
		if ( is_array( $output ) )
			$output = implode( ',', $output);

		echo "<script>console.log( 'Debug Objects: " . $output . "' );</script>";
	}
	
?>