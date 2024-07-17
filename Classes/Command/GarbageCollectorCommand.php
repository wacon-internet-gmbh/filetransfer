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
use Wacon\Filetransfer\Domain\Repository\UploadRepository;

class GarbageCollectorCommand extends Command
{
    public function __construct(
        private readonly StorageRepository $storageRepository,
        private readonly FileRepository $fileRepository,
        private readonly UploadRepository $uploadRepository
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
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $amountOfFiles = 0;
        $pids = GeneralUtility::intExplode(',', $input->getArgument('pids'), true);
        $this->initRepositories();
        $uploads = $this->uploadRepository->findAll();

        foreach ($pids as $pid) {
            $storage = $this->storageRepository->getStorageObject((int)$pid);

            if ($storage) {
                $folder = $storage->getFolder($input->getArgument('folder'));

                if (!$folder) {
                    return false;
                }

                $files = $storage->getFilesInFolder($storage->getFolder($input->getArgument('folder')));

                foreach ($files as $file) {
                    /**
                     * @var File $file
                     */
                    $deleteFile = true;

                    foreach ($uploads as $upload) {
                        if ($upload->getAsset() && $upload->getAsset()->getOriginalFile()->getUid() == $file->getUid()) {
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
     * Init repositories
     */
    private function initRepositories()
    {
        $querySettings = $this->uploadRepository->createQuery()->getQuerySettings();
        $querySettings->setRespectStoragePage(false);
        $this->uploadRepository->setDefaultQuerySettings($querySettings);
    }
}
