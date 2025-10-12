<?php
return [
    // 'hosts' => explode(',', env('ELASTIC_HOST', 'http://localhost:9200')),
    'hosts' => explode(',', env('ELASTIC_HOST', 'http://elasticsearch:9200')),
];