<?php

return [ 
   // set your paypal credential 
   'client_id' => 'AQldMoGCq-zgjqKIYLjTRZKTdRjrKQp_HZLRNDtHKsNsV1HjElwNVzqp4QCa4Lxnn1SRYvRsnNtZViS4',
   'secret' => 'ELLHhhopJo0AUMcArfRIKSCCmYyWNrjg1tm_Xt7QfjX_6NldUx5yZrifmdbPGGjx1tcG8bIOb4x45NB0',
    
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