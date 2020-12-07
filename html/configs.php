<?php

// GET key from environment
$key = getenv("MAMMILLARIA_JWT_KEY");
if (! isset($key)) {
    $key = '123';
}

return [
    // -------------------------------------------------------------
    // mammillaria
    // -------------------------------------------------------------
    'mammillaria_storage' => '/mnt/storage',
    'mammillaria_key' => $key,
    'mammillaria_algorithems' => [
        'ES256',
        'HS256',
        'HS384',
        'HS512',
        'RS256',
        'RS384',
        'RS512'
    ]
];