<?php

return [
    'recaptcha' => [
        'enabled' => filter_var(env('SIDUTA_RECAPTCHA_ENABLED', false), FILTER_VALIDATE_BOOLEAN),
        'site_key' => env('RECAPTCHA_SITE_KEY', ''),
        'secret_key' => env('RECAPTCHA_SECRET_KEY', ''),
    ],
    'disdukcapil' => [
        'url' => env('DISDUKCAPIL_API_URL', ''),
        'key' => env('DISDUKCAPIL_API_KEY', ''),
    ],
    'upload' => [
        'max_kb' => 5120,
        'image_mimes' => 'jpg,jpeg,png,webp',
        'doc_mimes' => 'pdf,jpg,jpeg,png,doc,docx',
    ],
];
