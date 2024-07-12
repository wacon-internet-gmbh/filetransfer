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
use TYPO3\CMS\Core\Page\JavaScriptModuleInstruction;
use TYPO3\CMS\Core\Page\PageRenderer;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use Wacon\Filetransfer\Domain\Model\Upload;
use TYPO3\CMS\Core\Core\Environment;
use Wacon\Filetransfer\Service\FileUploadService;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use Wacon\Filetransfer\Exception\FileUploadException;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;

final class UploadController extends ActionController
{
    protected string $extensionKey = 'filetransfer';

    public function __construct(private readonly PageRenderer $pageRenderer) {}

    /**
     * Before any action function is called
     * @return void
     */
    public function initializeAction()
    {
        /* if ($this->request->hasAttribute('upload')) {
            $this->arguments->getArgument('upload')
                ->getPropertyMappingConfiguration()
                ->setTargetTypeForSubProperty('validityDuration', 'int');
        } */
    }

    /**
     * Show the upoad form
     * @param Upload $upload
     * @return ResponseInterface
     */
    public function formAction(Upload $upload = null): ResponseInterface
    {
        if (!$upload) {
            $upload = new Upload();
        }

        if ($this->request->hasArgument('testmode') && $this->request->getArgument('testmode') == '1') {
            $upload->setTestData();
        }

        $this->pageRenderer->getJavaScriptRenderer()->addJavaScriptModuleInstruction(
            JavaScriptModuleInstruction::create('@wacon/filetransfer/Fileupload.js')
        );


        $this->view->assign('upload', $upload);
        $this->view->assign('contentObjectData', $this->request->getAttribute('currentContentObject')->data);
        $this->view->assign('testMode', Environment::getContext()->isDevelopment());
        return $this->htmlResponse();
    }

    /**
     * Show the upoad form
     * @param Upload $upload
     * @param array $asset
     * @return ResponseInterface
     * @throws FileUploadException
     */
    public function uploadAction(Upload $upload, array $asset): ResponseInterface
    {
        try {
            $fileUploadService = GeneralUtility::makeInstance(FileUploadService::class);
            $fileUploadService->init($this->settings['upload']);
            $fileUploadService->uploadSingle($asset);
            $asset = $fileUploadService->getFirstAsset();

            if (!$asset) {
                throw new FileUploadException(LocalizationUtility::translate('form.upload.fileuploadservice.upload_failed', $this->extensionKey));
            }

            $upload->setAsset($asset);
        }catch(FileUploadException $e) {
            $translatedMessage = LocalizationUtility::translate($e->getMessage(), $this->extensionKey);

            // We need to do this, because I only set translation keys inside the FileUploadService
            if ($translatedMessage) {
                $e->setMessage($translatedMessage);
            }

            $this->view->assign('error', $e);
            return $this->htmlResponse();
        }

        return $this->redirect('success');
    }

    /**
     * Show the success message
     * @return ResponseInterface
     */
    public function successAction(): ResponseInterface
    {
        return $this->htmlResponse();
    }

    /**
     * Show the success message
     * @return ResponseInterface
     */
    public function downloadAction(): ResponseInterface
    {
        return $this->htmlResponse();
    }
}
