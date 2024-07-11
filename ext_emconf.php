<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'Filetransfer',
    'description' => 'TYPO3 Extension to send downloadables via email secury and privacy complaint.',
    'category' => 'plugin',
    'author' => 'Kevin Chileong Lee',
    'author_email' => 'support@slavlee.de',
    'author_company' => 'Slavlee',
    'state' => 'stable',
    'version' => '0.0.2',
    'constraints' => [
        'depends' => [
            'typo3' => '12.4.0-12.4.99',
        ],
        'conflicts' => [
        ],
        'suggests' => [
        ],
    ],
];
