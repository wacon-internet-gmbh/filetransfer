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
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use Wacon\Filetransfer\Domain\Model\Upload;
use TYPO3\CMS\Core\Page\PageRenderer;
use TYPO3\CMS\Core\Page\JavaScriptModuleInstruction;

final class UploadController extends ActionController
{
    public function __construct(private readonly PageRenderer $pageRenderer)
    {}

    /**
     * Show the upoad form
     * @return ResponseInterface
     */
    public function formAction(): ResponseInterface
    {
        $this->pageRenderer->getJavaScriptRenderer()->addJavaScriptModuleInstruction(
            JavaScriptModuleInstruction::create('@wacon/filetransfer/Fileupload.js')
        );

        $this->view->assign('contentObjectData', $this->request->getAttribute('currentContentObject')->data);
        return $this->htmlResponse();
    }

    /**
     * Show the upoad form
     * @param Upload $upload
     * @return ResponseInterface
     */
    public function uploadAction(Upload $upload): ResponseInterface
    {
        debug($upload);
        return $this->htmlResponse();
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
