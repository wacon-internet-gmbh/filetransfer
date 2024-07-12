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

use TYPO3\CMS\Core\Resource\File;
use TYPO3\CMS\Core\Resource\ResourceStorage;
use TYPO3\CMS\Core\Resource\StorageRepository;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;
use Wacon\Filetransfer\Exception\FileUploadException;
use TYPO3\CMS\Core\Resource\Folder;
use TYPO3\CMS\Core\Crypto\Random;
use TYPO3\CMS\Extbase\Security\Cryptography\HashService;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use Wacon\Filetransfer\Domain\Model\Upload;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Database\Connection;

class FileUploadService
{
    /**
     * Settings from TypoScript related to file upload
     * @var array
     */
    protected array $settings;

    /**
     * All uploaded assets
     * @var ObjectStorage<File>
     */
    protected ObjectStorage $assets;

    /**
     * Target folder
     * @var Folder
     */
    protected ?Folder $folder;

    /**
     * Target storage
     * @var ResourceStorage
     */
    protected ResourceStorage $storage;

    /**
     * Summary of __construct
     * @param array $settings
     * @param \TYPO3\CMS\Core\Resource\StorageRepository $storageRepository
     * @throws FileUploadException
     */
    public function __construct(
        private readonly StorageRepository $storageRepository,
        private readonly Random $random,
        private readonly HashService $hashService,
        private readonly ConnectionPool $connectionPool
    ) {}

    /**
     * Init the storage, which means
     * 1. Check if storage exists
     * 2. Create target folder if needed
     * @throws FileUploadException
     */
    public function init(array $settings)
    {
        $this->settings = $settings;
        $this->assets = new ObjectStorage();

        // Fetch storage
        if (empty($this->settings['storage'])) {
            $this->storage = $this->storageRepository->getDefaultStorage();
        } else {
            $this->storage = $this->storageRepository->getStorageObject((int)$this->settings['storage']);
        }

        if (!$this->storage) {
            throw new FileUploadException('form.upload.fileuploadservice.storage_notfound');
        }

        // make sure target folder exists
        $this->folder = null;

        if (!$this->storage->hasFolder($this->settings['folder'])) {
            // if folder does not exist,
            // then we create it
            $this->folder = $this->storage->createFolder($this->settings['folder']);
        } else {
            $this->folder = $this->storage->getFolder($this->settings['folder']);
        }

        if (!$this->folder) {
            throw new FileUploadException('form.upload.fileuploadservice.folder_notfound');
        }
    }

    /**
     * Does the actual upload, which means
     * 1. Move uploaded file with correct name into defined folder
     * 2. Make sure filename is unique
     * @param array $file ($_FILES, when uploaded single file)
     */
    public function uploadSingle(array $file)
    {
        $newFile = $this->storage->addFile(
            $file['tmp_name'],
            $this->folder,
            $this->createUniqueFileName($file['name'])
        );

        $this->assets->attach($newFile);
    }

    /**
     * Create a sys_file_reference from a file to Upload
     * @param Upload $upload
     * @param File $file
     * @param array $data
     * @return void
     */
    public function createSysFileReference(Upload $upload, File $file, array $data = [])
    {
        // First we set asset to one, because we have one file
        $dbTable = 'tx_filetransfer_domain_model_upload';
        $queryBuilder = $this->connectionPool
            ->getQueryBuilderForTable($dbTable);
        $queryBuilder
            ->update($dbTable)
            ->where(
                $queryBuilder->expr()->eq('asset', $queryBuilder->createNamedParameter($upload->getUid(), Connection::PARAM_INT))
            )->set('asset', 1)
            ->executeStatement();

        // then we create sys_file_reference entry
        $dbTable = 'sys_file_reference';
        $queryBuilder = $this->connectionPool
            ->getQueryBuilderForTable($dbTable);
        $queryBuilder
            ->insert($dbTable)
            ->values(array_merge([
                'uid_local' => $file->getUid(),
                'tablenames' => 'tx_filetransfer_domain_model_upload',
                'uid_foreign' => $upload->getUid(),
                'fieldname' => 'asset',
                'pid' => $upload->getPid(),
            ], $data))
            ->executeStatement();
    }

    /**
     * Get all uploaded assets
     *
     * @return  ObjectStorage<File>
     */
    public function getAssets(): ObjectStorage
    {
        return $this->assets;
    }

    /**
     * Return the first uploaded asset, if any or null
     * @return \TYPO3\CMS\Core\Resource\File|null
     */
    public function getFirstAsset(): ?File
    {
        return $this->assets && $this->assets->count() > 0 ? $this->assets->offsetGet(0) : null;
    }

    /**
     * Set all uploaded assets
     *
     * @param  ObjectStorage<File>  $assets  All uploaded assets
     *
     * @return  self
     */
    public function setAssets(ObjectStorage $assets): self
    {
        $this->assets = $assets;

        return $this;
    }

    /**
     * Create an unique filename which is unique and safe (impossible to guess)
     * @param string $name
     * @return string
     */
    protected function createUniqueFileName($name): string
    {
        $randomString = $this->random->generateRandomHexString(16);

        return GeneralUtility::hmac($this->hashService->generateHmac($randomString), $name);
    }
}
