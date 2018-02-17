<?php

return [ 
   // set your paypal credential 
   'client_id' => 'ARIuy5H8Ljn2_iADlaT9Onc6O5ju9Oxxrh2w5uyMv5duLi7OJLcaStCdZyR8t-NpPQBvqbKJmJWhfefw',
   'secret' => 'EDiFiJFjYCnpSHE3TJGf-eFX2Q7vYPeo2Lnv_HMIlydePptcG0hLrCcg0rnNyVS0eJzFUgTt0rehjKEL',
    
    /**
    * SDK configuration
    */
    'settings' => array(
    /**
    * Available option 'sandbox' or 'live'
    */
    'mode' => env('PAYPAL_MODE','sandbox'),
    
    /**
    * Specify the max request time in seconds
    */
    'http.ConnectionTimeOut' => 30,
    
    /**
    * Whether want to log to a file
    */
    'log.LogEnabled' => true,
    
    /**
    * Specify the file that want to write on
    */
    'log.FileName' => storage_path() . '/logs/paypal.log',
    
    /**
    * Available option 'FINE', 'INFO', 'WARN' or 'ERROR'
    *
    * Logging is most verbose in the 'FINE' level and decreases as you
    * proceed towards ERROR
    */
    'log.LogLevel' => 'ERROR'
    ),
];