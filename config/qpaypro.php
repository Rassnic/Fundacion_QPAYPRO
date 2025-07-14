<?php

return [
    'login'        => env('QPAYPRO_LOGIN', 'visanetgt_qpay_testings'),
    'private_key'  => env('QPAYPRO_PRIVATE_KEY', '88888888888'),
    'api_secret'   => env('QPAYPRO_API_SECRET', '99999999999'),
    'endpoint'     => env('QPAYPRO_ENDPOINT', 'https://devbilling.qpaypro.com/api/payment_token'),
];
