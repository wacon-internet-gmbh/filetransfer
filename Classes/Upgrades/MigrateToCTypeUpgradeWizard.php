<?php

declare(strict_types=1);

namespace Wacon\Filetransfer\Upgrades;

use TYPO3\CMS\Core\Attribute\UpgradeWizard;
use TYPO3\CMS\Core\Database\Connection;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Upgrades\DatabaseUpdatedPrerequisite;
use TYPO3\CMS\Core\Upgrades\UpgradeWizardInterface;

#[UpgradeWizard('filetransfer_migrateToCTypeUpgradeWizard')]
final class MigrateToCTypeUpgradeWizard implements UpgradeWizardInterface
{
    public function __construct(
        private readonly ConnectionPool $connectionPool
    ) {}

    /**
     * Return the speaking name of this wizard
     */
    public function getTitle(): string
    {
        return 'Filetransfer: Migrate list_type plugins to CType';
    }

    /**
     * Return the description for this wizard
     */
    public function getDescription(): string
    {
        return 'Change db value list_type to CType for filetransfer plugins';
    }

    /**
     * Execute the update
     *
     * Called when a wizard reports that an update is necessary
     *
     * The boolean indicates whether the update was successful
     */
    public function executeUpdate(): bool
    {
        $queryBuilder = $this->connectionPool->getQueryBuilderForTable('tt_content');
        $queryBuilder
            ->update('tt_content')
            ->where(
                $queryBuilder->expr()->like('list_type', $queryBuilder->createNamedParameter($queryBuilder->escapeLikeWildcards('filetransfer') . '_%', Connection::PARAM_STR)),
                $queryBuilder->expr()->eq('CType', $queryBuilder->createNamedParameter('list')),
            )
            ->set('CType', $queryBuilder->quoteIdentifier('list_type'), false)
            ->executeStatement();

        return true;
    }

    /**
     * Is an update necessary?
     *
     * Is used to determine whether a wizard needs to be run.
     * Check if data for migration exists.
     *
     * @return bool Whether an update is required (TRUE) or not (FALSE)
     */
    public function updateNecessary(): bool
    {
        // check if list_type column exists
        if ($this->listTypeColumnExists() === false) {
            return false;
        }

        if ($this->oldPluginsExist() === true) {
            return true;
        }

        return false;
    }

    /**
     * Returns an array of class names of prerequisite classes
     *
     * This way a wizard can define dependencies like "database up-to-date" or
     * "reference index updated"
     *
     * @return string[]
     */
    public function getPrerequisites(): array
    {
        return [
            DatabaseUpdatedPrerequisite::class,
        ];
    }

    private function listTypeColumnExists(): bool
    {
        $queryBuilder = $this->connectionPool->getQueryBuilderForTable('tt_content');
        $queryBuilder->getRestrictions()->removeAll();
        $schemaManager = $queryBuilder->getConnection()->createSchemaManager();
        $columns = $schemaManager->listTableColumns('tt_content');
        return array_key_exists('list_type', $columns);
    }

    /**
     * Check if there are old plugins
     * @return bool
     */
    private function oldPluginsExist(): bool
    {
        $queryBuilder = $this->connectionPool->getQueryBuilderForTable('tt_content');
        $queryBuilder->getRestrictions()->removeAll();
        return (bool)$queryBuilder
            ->count('uid')
            ->from('tt_content')
            ->where(
                $queryBuilder->expr()->like('list_type', $queryBuilder->createNamedParameter($queryBuilder->escapeLikeWildcards('filetransfer') . '_%', Connection::PARAM_STR)),
                $queryBuilder->expr()->eq('CType', $queryBuilder->createNamedParameter('list')),
            )
            ->executeQuery()
            ->fetchOne();
    }
}
