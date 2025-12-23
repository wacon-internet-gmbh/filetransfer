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

namespace Wacon\Filetransfer\Service;

use TYPO3\CMS\Core\Crypto\HashService;
use TYPO3\CMS\Core\Crypto\Random;

class TokenService
{
    /**
     * Summary of __construct
     */
    public function __construct(
        private readonly Random $random,
        private readonly HashService $hashService
    ) {}

    /**
     * Create an unique token which is unique and safe (impossible to guess)
     * @param string $additionalSecret
     * @return string
     */
    public function create($additionalSecret = ''): string
    {
        $randomString = $this->random->generateRandomHexString(16);

        return $this->hashService->hmac($randomString, $additionalSecret);
    }
}
