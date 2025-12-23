<?php

declare(strict_types=1);

use TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider;

return [
    // Icon identifier
    'tx-filetransfer' => [
        // Icon provider class
        'provider' => SvgIconProvider::class,
        'source' => 'EXT:filetransfer/Resources/Public/Icons/Extension.svg',
    ],
];
