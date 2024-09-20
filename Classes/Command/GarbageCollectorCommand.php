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

namespace Wacon\Filetransfer\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use TYPO3\CMS\Core\Resource\File;
use TYPO3\CMS\Core\Resource\FileRepository;
use TYPO3\CMS\Core\Resource\StorageRepository;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use Wacon\Filetransfer\Domain\QueryBuilder\UploadQueryBuilder;

class GarbageCollectorCommand extends Command
{
    public function __construct(
        private readonly StorageRepository $storageRepository,
        private readonly FileRepository $fileRepository,
        private readonly UploadQueryBuilder $uploadQueryBuilder
    ) {
        parent::__construct();
    }

    /**
     * Configure the command by defining the name, options and arguments
     */
    protected function configure()
    {
        $this->setDescription('Delete all files that have no relation to a upload.');
        $this->addArgument(
            'pids',
            InputArgument::REQUIRED,
            'File Storage IDs'
        );
        $this->addArgument(
            'folder',
            InputArgument::REQUIRED,
            'Subfolder inside the given Storages'
        );
    }

    /**
     * Executes the command to delete all uploads where validity_date is in the past
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $amountOfFiles = 0;
        $pids = GeneralUtility::intExplode(',', $input->getArgument('pids'), true);
        $uploads = $this->uploadQueryBuilder->findAll()->fetchAllAssociative();

        foreach ($pids as $pid) {
            $storage = $this->storageRepository->getStorageObject((int)$pid);

            if ($storage) {
                $folder = $storage->getFolder($input->getArgument('folder'));

                if (!$folder) {
                    return 0;
                }

                $files = $storage->getFilesInFolder($storage->getFolder($input->getArgument('folder')));

                foreach ($files as $file) {
                    /**
                     * @var File $file
                     */
                    $deleteFile = true;

                    foreach ($uploads as $upload) {
                        $asset = $this->getAsset($upload);
                        if ($asset && $asset->getOriginalFile()->getUid() == $file->getUid()) {
                            $deleteFile = false;
                            break;
                        }
                    }

                    if ($deleteFile) {
                        $storage->deleteFile($file);
                    }
                }
            }
        }

        // Render answer
        $io = new SymfonyStyle($input, $output);
        $io->title($this->getDescription());
        $io->writeln($amountOfFiles . ' has been deleted.');
        return 0;
    }

    /**
     * Get asset
     * @param array $upload
     * @return \TYPO3\CMS\Core\Resource\FileReference|bool
     */
    private function getAsset(array $upload)
    {
        $assets = $this->fileRepository->findByRelation(UploadQueryBuilder::DB_TABLE, 'asset', $upload['uid']);

        return is_array($assets) ? current($assets) : $assets;
    }
}
