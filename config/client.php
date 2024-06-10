<?php

return [
    'url' => env('CLIENT_URL', 'http://localhost:8080'),
    'subscribe_verify_success_url' => env('SUBSCRIBER_VERIFY_SUCCESS_URL', 'http://localhost:8080/subscriber/verify/success'),
    'subscribe_verify_error_url' => env('SUBSCRIBER_VERIFY_ERROR_URL', 'http://localhost:8080/subscriber/verify/error'),
];