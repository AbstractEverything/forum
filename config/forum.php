<?php

return [
    'meta' => [
        'title' => 'Forums',
        'description' => 'A forum made with Laravel',
        'keywords' => 'forum, forums, laravel',
    ],
    'pagination' => [
        'posts' => 20,
        'replies' => 10
    ],
    'hot_post' => 10,
    'last_online_minutes' => 10,
    'cache' => [
        'forums_all' => [
            'duration' => 60 * 60,
        ]
    ]
];