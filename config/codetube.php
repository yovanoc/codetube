<?php

return [

    'buckets' => [

        'videos' => 'https://s3-' . env('S3_REGION') . '.amazonaws.com/' . env('S3_VIDEOS_BUCKET'),
        'images' => 'https://s3-' . env('S3_REGION') . '.amazonaws.com/' . env('S3_IMAGES_BUCKET')

    ]

];