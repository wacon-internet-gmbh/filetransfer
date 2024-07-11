<?php

declare(strict_types=1);

/*
 * This file is part of the TYPO3 extension: filetransfer.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

namespace Wacon\Filetransfer\Bootstrap;

use TYPO3\CMS\Extbase\Utility\ExtensionUtility;
use Wacon\Filetransfer\Controller\DownloadController;
use Wacon\Filetransfer\Controller\UploadController;

class ExtLocalconf extends Base
{
    /**
     * Does the main class purpose
     */
    public function invoke()
    {
        $this->configurePlugins();
    }

    /**
     * ExtensionUtility::configurePlugin
     */
    private function configurePlugins()
    {
        ExtensionUtility::configurePlugin(
            $this->getExtensionKeyAsNamespace(),
            'Upload',
            [
                UploadController::class => 'form,upload,success',
            ],
            [
                UploadController::class => 'form,upload',
            ]
        );

        ExtensionUtility::configurePlugin(
            $this->getExtensionKeyAsNamespace(),
            'Upload',
            [
                DownloadController::class => 'download',
            ],
            [
                DownloadController::class => 'download',
            ]
        );
    }
}
