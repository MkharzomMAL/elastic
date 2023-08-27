<?php

return [
    'host' => env('ELASTICSEARCH_HOST', 'http://localhost:9200'),
    'index' => 'laravel_logs',
    'prefix' => 'tealive',
    'type' => '_doc',
];
