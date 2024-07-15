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

namespace Wacon\Filetransfer\Domain\Repository;

use TYPO3\CMS\Extbase\Persistence\QueryResultInterface;
use TYPO3\CMS\Extbase\Persistence\Repository;

class UploadRepository extends Repository
{
    /**
     * End transaction
     */
    public function commit()
    {
        $this->persistenceManager->persistAll();
    }

    /**
     * Return all records where the validity date has expired
     * @return \QueryResultInterface
     */
    public function findByAllExpired(): QueryResultInterface
    {
        $query = $this->createQuery();
        return $query->matching(
            $query->lessThan('validity_date', new \DateTime())
        )->execute();
    }
}
