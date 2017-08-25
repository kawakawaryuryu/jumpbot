<?php

// make json file about all buyers
$buyers = [
    0 => [
        'buyer' => 'xxx',
        'buyNum' => 0
    ],
    1 => [
        'buyer' => 'yyy',
        'buyNum' => 0
    ]
];
file_put_contents(dirname(__FILE__).'/buyers.json', json_encode($buyers, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));

// make json file about this week info
$buyer = [
    'lastBuyer' => 0,
    'nextBuyer' => 1
];
file_put_contents(dirname(__FILE__).'/buyer.json', json_encode($buyer, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
