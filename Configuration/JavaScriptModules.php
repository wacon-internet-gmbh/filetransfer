<?php

return [
    'dependencies' => ['frontend', 'fluid'],
    'imports' => [
        '@wacon/filetransfer/' => [
            'path' => 'EXT:filetransfer/Resources/Public/JavaScript/',
            # Exclude files of the following folders from being import-mapped
            'exclude' => [
                'EXT:filetransfer/Resources/Public/JavaScript/Contrib/',
                'EXT:filetransfer/Resources/Public/JavaScript/Overrides/',
            ],
        ],
    ],
];
