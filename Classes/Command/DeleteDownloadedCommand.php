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
use TYPO3\CMS\Core\Utility\GeneralUtility;
use Wacon\Filetransfer\Domain\Repository\UploadRepository;

class DeleteDownloadedCommand extends Command
{
    public function __construct(
        private readonly UploadRepository $uploadRepository
    ) {
        parent::__construct();
    }

    /**
     * Configure the command by defining the name, options and arguments
     */
    protected function configure()
    {
        $this->setDescription('Delete all uploads with download_limit equals zero.');
        $this->addArgument(
            'pids',
            InputArgument::REQUIRED,
            'Page ids where the upload data is stored.'
        );
    }

    /**
     * Executes the command to delete all uploads with download_limit = 0
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $amountOfFiles = 0;

        $this->initRepositories(GeneralUtility::intExplode(',', $input->getArgument('pids'), true));
        $uploads = $this->uploadRepository->findBy(['download_limit' => 0]);
        $amountOfFiles = count($uploads);

        foreach ($uploads as $upload) {
             /**
             * @var Upload $upload
             */
            // Delete file
            $asset = $upload->getAsset();

            if ($asset) {
                $asset->getOriginalResource()->getOriginalFile()->delete();
            }

            // Delete record
            $this->uploadRepository->remove($upload);
        }

        if ($amountOfFiles > 0) {
            $this->uploadRepository->commit();
        }

        // Render answer
        $io = new SymfonyStyle($input, $output);
        $io->title($this->getDescription());
        $io->writeln($amountOfFiles . ' has been deleted.');
        return 0;
    }

    /**
     * Init repositories
     * @param array $pids
     */
    private function initRepositories(array $pids)
    {
        $querySettings = $this->uploadRepository->createQuery()->getQuerySettings();
        $querySettings->setStoragePageIds($pids);
        $this->uploadRepository->setDefaultQuerySettings($querySettings);
    }
}
