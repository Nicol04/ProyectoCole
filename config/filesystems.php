<?php

return [

    'default' => env('FILESYSTEM_DISK', 'local'),
    'disks' => [

        'local' => [
            'driver' => 'local',
            'root' => storage_path('app/private'),
            'serve' => true,
            'throw' => false,
            'report' => false,
        ],

        'public' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'url' => env('APP_URL').'/storage',
            'visibility' => 'public',
            'throw' => false,
            'report' => false,
        ],

        's3' => [
            'driver' => 's3',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'region' => env('AWS_DEFAULT_REGION'),
            'bucket' => env('AWS_BUCKET'),
            'url' => env('AWS_URL'),
            'endpoint' => env('AWS_ENDPOINT'),
            'use_path_style_endpoint' => env('AWS_USE_PATH_STYLE_ENDPOINT', false),
            'throw' => false,
            'report' => false,
        ],
        'cloudinary' => [
            'driver' => 'cloudinary',
            'cloud' => env('CLOUDINARY_CLOUD_NAME'),
            'key' => env('CLOUDINARY_API_KEY'),
            'secret' => env('CLOUDINARY_API_SECRET'),
            'secure' => true, // o false según tu preferencia
        ],
    ],

    'links' => [
        public_path('storage') => storage_path('app/public'),
    ],

];
