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

use TYPO3\CMS\Core\Resource\FileReference;
use TYPO3\CMS\Core\Resource\ResourceStorage;
use TYPO3\CMS\Core\Resource\StorageRepository;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;
use Wacon\Filetransfer\Exception\FileUploadException;

class FileUploadService
{
    /**
     * Settings from TypoScript related to file upload
     * @var array
     */
    protected array $settings;

    /**
     * All uploaded assets
     * @var ObjectStorage<FileReference>
     */
    protected ObjectStorage $assets;

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
        private readonly StorageRepository $storageRepository
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
        $folder = null;

        if (!$this->storage->hasFolder($this->settings['folder'])) {
            // if folder does not exist,
            // then we create it
            $folder = $this->storage->createFolder($this->settings['folder']);
        } else {
            $folder = $this->storage->getFolder($this->settings['folder']);
        }

        debug($folder);
    }

    /**
     * Does the actual upload, which means
     * 1. Move uploaded file with correct name into defined folder
     * 2. Make sure filename is unique
     * @param array $file ($_FILES, when uploaded single file)
     */
    public function uploadSingle(array $file)
    {
        debug($this->settings);
        debug($file);
    }

    /**
     * Get all uploaded assets
     *
     * @return  ObjectStorage<FileReference>
     */
    public function getAssets(): ObjectStorage
    {
        return $this->assets;
    }

    /**
     * Return the first uploaded asset, if any or null
     * @return \TYPO3\CMS\Core\Resource\FileReference|null
     */
    public function getFirstAsset(): ?FileReference
    {
        return $this->assets && $this->assets->count() > 0 ? $this->assets->offsetGet(0) : null;
    }

    /**
     * Set all uploaded assets
     *
     * @param  ObjectStorage<FileReference>  $assets  All uploaded assets
     *
     * @return  self
     */
    public function setAssets(ObjectStorage $assets): self
    {
        $this->assets = $assets;

        return $this;
    }


}
