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

namespace Wacon\Filetransfer\Domain\QueryBuilder;

use Doctrine\DBAL\Result;
use TYPO3\CMS\Core\Database\Connection;

class UploadQueryBuilder extends BaseQueryBuilder
{
    public const DB_TABLE = 'tx_filetransfer_domain_model_upload';

    /**
     * findByAllExpired
     * @return \Doctrine\DBAL\Result
     */
    public function findAll(): Result
    {
        $queryBuilder = $this->connectionPool->getQueryBuilderForTable(self::DB_TABLE);
        return $queryBuilder
            ->select('*')
            ->from(self::DB_TABLE)
            ->executeQuery();
    }

    /**
     * FindBy properties
     * @param array $properties
     * @return \Doctrine\DBAL\Result
     */
    public function findBy(array $properties): Result
    {
        $queryBuilder = $this->connectionPool->getQueryBuilderForTable(self::DB_TABLE);
        $queryBuilder
            ->select('*')
            ->from(self::DB_TABLE);

        foreach ($properties as $name => $value) {
            if (is_array($value)) {
                $constraints[] = $queryBuilder->expr()->in($name, $value);
            } else {
                $constraints[] = $queryBuilder->expr()->eq($name, $value);
            }

        }

        $queryBuilder->where(...$constraints);

        return $queryBuilder->executeQuery();
    }

    /**
     * findByAllExpired
     * @return \Doctrine\DBAL\Result
     */
    public function findByAllExpired(): Result
    {
        $queryBuilder = $this->connectionPool->getQueryBuilderForTable(self::DB_TABLE);
        return $queryBuilder
            ->select('*')
            ->from(self::DB_TABLE)
            ->where(
                $queryBuilder->expr()->lt('validity_date', (new \DateTime())->getTimestamp())
            )->executeQuery();
    }

    /**
     * Delete a row from db table
     * @param array $row
     * @return int
     */
    public function remove(array $row): int
    {
        $queryBuilder = $this->connectionPool->getQueryBuilderForTable(self::DB_TABLE);
        return $queryBuilder
            ->delete(self::DB_TABLE)
            ->where(
                $queryBuilder->expr()->eq('uid', $queryBuilder->createNamedParameter($row['uid'], Connection::PARAM_INT))
            )
            ->executeStatement();
    }
}
