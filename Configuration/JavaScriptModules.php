<?php

return [
    'dependencies' => ['frontend', 'fluid'],
    'imports' => [
        '@wacon/filetransfer/' => [
            'path' => 'EXT:filetransfer/Resources/Public/JavaScript/',
            'exclude' => [
                'EXT:filetransfer/Resources/Public/JavaScript/Contrib/',
                'EXT:filetransfer/Resources/Public/JavaScript/Overrides/',
            ],
        ],
    ],
];
