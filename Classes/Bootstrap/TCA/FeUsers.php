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

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use Wacon\Filetransfer\Bootstrap\Base;
use Wacon\Filetransfer\Bootstrap\Traits\TcaTrait;

class FeUsers extends Base
{
    use TcaTrait;

    /**
     * Does the main class purpose
     */
    public function invoke()
    {
        $this->dbTable = 'fe_users';
        $this->configureFields();
    }

    /**
     * Configure new TCA fields
     */
    private function configureFields()
    {
        $newFields = [
            'mail_signature' => $this->getRTETCADef(
                true,
                $this->getLLL('locallang_db.xlf:fe_users.mail_signature'),
                false
            ),
        ];

        ExtensionManagementUtility::addTCAcolumns(
            $this->dbTable,
            $newFields
        );

        ExtensionManagementUtility::addToAllTCAtypes(
            $this->dbTable,
            'mail_signature',
            '',
            'after:email'
        );
    }
}
