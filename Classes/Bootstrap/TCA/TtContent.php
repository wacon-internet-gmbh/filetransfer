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

use TYPO3\CMS\Core\Information\Typo3Version;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Utility\ExtensionUtility;
use Wacon\Filetransfer\Bootstrap\Base;

class TtContent extends Base
{
    protected int $typo3MajorVersion = 13;

    /**
     * Does the main class purpose
     */
    public function invoke()
    {
        $this->typo3MajorVersion = GeneralUtility::makeInstance(Typo3Version::class)->getMajorVersion();
        $this->registerPlugins();
    }

    /**
     * ExtensionUtility::registerPlugin
     */
    private function registerPlugins()
    {
        if ($this->typo3MajorVersion >= 14) {
            $pluginSignature = ExtensionUtility::registerPlugin(
                $this->getExtensionKeyAsNamespace(),
                'Upload',
                $this->getLLL('locallang_plugins.xlf:upload.title'),
                'tx-filetransfer',
                'plugins',
                '',
                $this->getFlexformPath('Upload.xml')
            );

            ExtensionManagementUtility::addToAllTCAtypes(
                'tt_content',
                'pages',
                $pluginSignature,
                'after:pi_flexform'
            );
        } else {
            $pluginSignature = ExtensionUtility::registerPlugin(
                $this->getExtensionKeyAsNamespace(),
                'Upload',
                $this->getLLL('locallang_plugins.xlf:upload.title')
            );

            $GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';

            ExtensionManagementUtility::addPiFlexFormValue(
                $pluginSignature,
                $this->getFlexformPath('Upload.xml')
            );
        }

        if ($this->typo3MajorVersion >= 14) {
            $pluginSignature = ExtensionUtility::registerPlugin(
                $this->getExtensionKeyAsNamespace(),
                'Download',
                $this->getLLL('locallang_plugins.xlf:download.title'),
                'tx-filetransfer',
                'plugins',
                ''
            );

            ExtensionManagementUtility::addToAllTCAtypes(
                'tt_content',
                '--div--;Plugin, pages',
                $pluginSignature,
                'after:palette:headers'
            );
        } else {
            ExtensionUtility::registerPlugin(
                $this->getExtensionKeyAsNamespace(),
                'Download',
                $this->getLLL('locallang_plugins.xlf:download.title'),
            );
        }
    }
}
