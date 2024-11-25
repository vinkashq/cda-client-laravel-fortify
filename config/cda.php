<?php

return [
    'server_url' => env('CDA_SERVER_URL'), // example: https://auth.example.com
    'client_id' => env('CDA_CLIENT_ID'),
    'client_secret' => env('CDA_CLIENT_SECRET'),
    'path' => env('CDA_PATH', 'cda'),
    'user_model' => env('CDA_USER_MODEL', 'App\Models\User'),
];
