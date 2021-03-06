<?php
return [
    'disks' => [
        'local' => [
            'driver' => 'local',
            'root'   => storage_path('public'),
        ],
		's3' => [
			'driver' => 's3',
			'key' => env('AWS_KEY'),
			'secret' => env('AWS_SECRET'),
			'region' => env('AWS_REGION'),
			'bucket' => env('AWS_BUCKET'),
		],
    ],
];