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

namespace Wacon\Filetransfer\Exception;

use TYPO3\CMS\Extbase\Exception;

class FileUploadException extends Exception
{
    /**
     * Set new message
     * @param string $message
     */
    public function setMessage(string $message)
    {
        $this->message = $message;
    }
}
