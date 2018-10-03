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


    // you (or your client's) merchant credentials.
    // grab a test account from us for development!
    $merchantCredentials = [
        
        "ID" => "417227771521",
        "KEY" => "I5T2R2K6V1Q3"
        
    ];

    // your application's credentials
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

?>