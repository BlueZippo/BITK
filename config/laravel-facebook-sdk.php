<?php

return [
    
    'facebook_config' => [
        'app_id'                => env('FACEBOOK_ID'),
        'app_secret'            => env('FACEBOOK_SECRET'),
        'default_graph_version' => 'v2.10',
        //'enable_beta_mode' => true,
        //'http_client_handler' => 'guzzle',
    ],

    
    'default_scope' => [],

    
    'default_redirect_uri' => '/facebook/callback',
    ];
