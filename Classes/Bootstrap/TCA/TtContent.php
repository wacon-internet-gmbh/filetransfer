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

namespace Wacon\Filetransfer\Bootstrap\TCA;

use TYPO3\CMS\Extbase\Utility\ExtensionUtility;
use Wacon\Filetransfer\Bootstrap\Base;

class TtContent extends Base
{
    /**
     * Does the main class purpose
     */
    public function invoke()
    {
        $this->registerPlugins();
    }

    /**
     * ExtensionUtility::registerPlugin
     */
    private function registerPlugins()
    {
        ExtensionUtility::registerPlugin(
            $this->getExtensionKeyAsNamespace(),
            'Upload',
            $this->getLLL('locallang_plugins.xlf:upload.title'),
        );

        ExtensionUtility::registerPlugin(
            $this->getExtensionKeyAsNamespace(),
            'Download',
            $this->getLLL('locallang_plugins.xlf:download.title'),
        );
    }
}
