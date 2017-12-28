<?php
return [
    'mode' => 'sandbox',        // Can only be 'sandbox' Or 'live'. If empty or invalid, 'live' will be used.
    'sandbox' => [
        'username' => 'novone_api1.gmail.com',       // Api Username
        'password' => 'RMW3BECP72E6H7DM',       // Api Password
        'secret' => 'A.TzJNj9shbYBAmb0.QmzsuZ4bT2AV637627Yc3UEOPYAydIRkrhDFZg',         // This refers to api signature
        'certificate' => '',    // Link to paypals cert file, storage_path('cert_key_pem.txt')
    ],
    'live' => [
        'username' => '',       // Api Username
        'password' => '',       // Api Password
        'secret' => '',         // This refers to api signature
        'certificate' => '',    // Link to paypals cert file, storage_path('cert_key_pem.txt')
    ],
    'payment_action' => 'Sale', // Can Only Be 'Sale', 'Authorization', 'Order'
    'currency' => 'PHP',
    'notify_url' => '',         // Change this accordingly for your application.
    'validate_ssl' => true,     // Validate SSL when creating api client.
];