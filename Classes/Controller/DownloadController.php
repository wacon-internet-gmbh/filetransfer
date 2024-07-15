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

use TYPO3\CMS\Core\Http\ImmediateResponseException;
use Wacon\Filetransfer\Domain\Repository\UploadRepository;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

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
    public function downloadAction($token)
    {
        $download = $this->uploadRepository->findByToken($token)->current();

        if (!$download || $download->getDownloadLimit() <= 0) {
            return $this->redirect('expired');
        }

        // Mark asset as downloaded
        $download->decrementDownloadLimit();
        $this->uploadRepository->update($download);
        $this->uploadRepository->commit();

        // Download asset
        $resourceFile = $download->getAsset()->getOriginalResource();
        $response = $resourceFile->getStorage()->streamFile($resourceFile->getOriginalFile(), true, $resourceFile->getTitle(), $resourceFile->getMimeType());
        throw new ImmediateResponseException($response);
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
