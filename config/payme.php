<?php

return [
    'id'        => env('PAYME_ID'),
    'key'       => env('PAYME_KEY'),
    'url'       => env('PAYME_URL', 'https://checkout.test.paycom.uz/api'),
    'test_mode' => env('PAYME_TEST_MODE', true),
];
