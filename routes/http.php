<?php declare(strict_types = 1);

return [
    [
        'GET',
        '/',
        [
            'OptimyTest\Controllers\NewsController',
            'index'
        ]
    ],
    [
        'GET',
        '/news',
        [
            'OptimyTest\Controllers\NewsController',
            'news'
        ]
    ],
];