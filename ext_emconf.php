<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'Filetransfer',
    'description' => 'TYPO3 Extension to send downloadables via email secury and privacy complaint.',
    'category' => 'plugin',
    'author' => 'Kevin Chileong Lee',
    'author_email' => 'info@wacon.de',
    'author_company' => 'WACON Internet GmbH',
    'state' => 'stable',
    'version' => '1.0.2',
    'constraints' => [
        'depends' => [
            'typo3' => '12.4.0-12.4.99',
        ],
        'conflicts' => [
        ],
        'suggests' => [
        ],
    ],
    'autoload' => [
        'psr-4' => [
            'Wacon\\Filetransfer\\' => 'Classes',
        ],
    ],
];
