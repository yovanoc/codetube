<?php

return [

    'buckets' => [
        'videos' => 'https://s3-' . env('AWS_REGION') . '.amazonaws.com/' . env('AWS_VIDEOS_BUCKET'),
        'images' => 'https://s3-' . env('AWS_REGION') . '.amazonaws.com/' . env('AWS_IMAGES_BUCKET')
    ]

];
