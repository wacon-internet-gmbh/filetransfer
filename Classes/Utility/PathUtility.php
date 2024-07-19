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

namespace Wacon\Filetransfer\Utility;

class PathUtility extends \TYPO3\CMS\Core\Utility\PathUtility
{
    /**
     * Delete the first forwards slash
     * @param mixed $string
     * @return string
     */
    public static function stripFirstForwardSlash($string): string
    {
        if (\strpos($string, '/') === 0) {
            return \substr($string, 1);
        }

        return $string;
    }
}


