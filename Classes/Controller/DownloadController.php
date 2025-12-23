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

namespace Wacon\Filetransfer\Controller;

use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Core\Http\ImmediateResponseException;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use Wacon\Filetransfer\Domain\Repository\UploadRepository;
use Wacon\Filetransfer\Service\MailService;

final class DownloadController extends ActionController
{
    public function __construct(
        private readonly UploadRepository $uploadRepository
    ) {}

    /**
     * Show the success message
     * @param string $token
     * @return never|ResponseInterface
     * @throws ImmediateResponseException
     */
    public function downloadpageAction($token)
    {
        $download = $this->uploadRepository->findBy(['token' => $token])->current();

        if (!$download || $download->getDownloadLimit() <= 0) {
            return $this->redirect('expired');
        }

        // render download page
        $this->view->assign('downloadLink', $this->uriBuilder
        ->reset()
        ->setCreateAbsoluteUri(true)
        ->setNoCache(true)
        ->uriFor(
            'download',
            [
                'token' => $download->getToken(),
            ],
            'Download',
            'filetransfer',
            'download'
        ));

        return $this->htmlResponse();
    }

    /**
     * Show the success message
     * @param string $token
     * @return never|ResponseInterface
     * @throws ImmediateResponseException
     */
    public function downloadAction($token)
    {
        $download = $this->uploadRepository->findBy(['token' => $token])->current();

        if (!$download || $download->getDownloadLimit() <= 0) {
            return $this->redirect('expired');
        }

        // Mark asset as downloaded
        $download->decrementDownloadLimit();
        $this->uploadRepository->update($download);
        $this->uploadRepository->commit();

        // Send infomail to sender
        try {
            $mailService = GeneralUtility::makeInstance(MailService::class);
            $mailService->init($this->settings, $this->request);
            $mailService->sendToSender($download);
        } catch (\Exception $e) {
            // nothing
        }

        // Download asset
        $resourceFile = $download->getAsset()->getOriginalResource();
        $response = $resourceFile->getStorage()->streamFile($resourceFile->getOriginalFile(), true, $resourceFile->getTitle(), $resourceFile->getMimeType());
        throw new ImmediateResponseException(
            $response->withHeader('Cache-Control', 'no-cache, no-store')
        );
    }

    /**
     * Action to show error, if there was an download error
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function errorAction(): ResponseInterface
    {
        return $this->htmlResponse();
    }

    /**
     * Action to show expired info
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function expiredAction(): ResponseInterface
    {
        return $this->htmlResponse();
    }
}
