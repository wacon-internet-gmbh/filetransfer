<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'Filetransfer',
    'description' => 'The filetransfer extension enables the secure transfer of files from your own web server ("on-premise"). This eliminates the need for email transfers, which can be challenging for large files and pose security risks for sensitive data. As an alternative to WeTransfer, organizations can use this extension to present themselves in a particularly security-conscious and professional manner.',
    'category' => 'plugin',
    'author' => 'Kevin Chileong Lee',
    'author_email' => 'info@wacon.de',
    'author_company' => 'WACON Internet GmbH',
    'state' => 'stable',
    'version' => '2.0.3',
    'constraints' => [
        'depends' => [
            'typo3' => '12.4.0-13.4.99',
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
