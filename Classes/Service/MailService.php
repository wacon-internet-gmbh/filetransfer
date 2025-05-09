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

use Symfony\Component\Mime\Address;
use TYPO3\CMS\Core\Mail\FluidEmail;
use TYPO3\CMS\Core\Mail\MailerInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Mvc\RequestInterface;
use TYPO3\CMS\Extbase\Mvc\Web\Routing\UriBuilder;
use Wacon\Filetransfer\Domain\Model\Upload;

class MailService
{
    /**
     * Mail settings
     * @var array
     */
    protected array $settings = [];

    /**
     * Current TYPO3 Request
     * @var RequestInterface
     */
    protected RequestInterface $request;

    /**
     * Current fe_user record
     * @var array
     */
    protected array $feuser = [];

    public function __construct(
        private readonly UriBuilder $uriBuilder,
    ) {}

    /**
     * Init the mail service
     * @param array $settings
     */
    public function init(array $settings, RequestInterface $request)
    {
        $this->settings = $settings;
        $this->request = $request;
    }

    /**
     * Send mail for new upload
     * @param \Wacon\Filetransfer\Domain\Model\Upload $upload
     */
    public function send(Upload $upload)
    {
        $email = new FluidEmail();
        $email
            ->setRequest($this->request)
            ->to($upload->getReceiverAddress())
            ->from(new Address($upload->getSenderAddress()))
            ->subject($upload->getSubject())
            ->format(FluidEmail::FORMAT_BOTH)
            ->setTemplate('Download')
            ->assign('signature', !empty($this->feuser) && !empty($this->feuser['mail_signature']) ? $this->feuser['mail_signature'] : $upload->getSignature())
            ->assign('upload', $upload)
            ->assign('downloadUri', $this->createDownloadUri($upload));
        GeneralUtility::makeInstance(MailerInterface::class)->send($email);
    }

    /**
     * Send mail to sender
     * @param \Wacon\Filetransfer\Domain\Model\Upload $upload
     */
    public function sendToSender(Upload $upload)
    {
        $email = new FluidEmail();
        $email
            ->setRequest($this->request)
            ->to($upload->getSenderAddress())
            ->from(new Address($upload->getSenderAddress()))
            ->subject($upload->getSubject())
            ->format(FluidEmail::FORMAT_BOTH)
            ->setTemplate('AdminDownloadInfo')
            ->assign('signature', $upload->getSignature())
            ->assign('upload', $upload);
        GeneralUtility::makeInstance(MailerInterface::class)->send($email);
    }

    /**
     * Create the download uri for given upload
     * @param \Wacon\Filetransfer\Domain\Model\Upload $upload
     * @return string
     */
    private function createDownloadUri(Upload $upload): string
    {
        return $this->uriBuilder
                ->reset()
                ->setRequest($this->request)
                ->setTargetPageUid((int)$this->settings['downloadPid'])
                ->setCreateAbsoluteUri(true)
                ->uriFor(
                    'downloadpage',
                    [
                        'token' => $upload->getToken(),
                    ],
                    'Download',
                    'filetransfer',
                    'download'
                );
    }

    /**
     * Get current fe_user record
     *
     * @return array
     */
    public function getFeuser(): array
    {
        return $this->feuser;
    }

    /**
     * Set current fe_user record
     *
     * @param array  $feuser
     *
     * @return self
     */
    public function setFeuser(array $feuser): self
    {
        $this->feuser = $feuser;

        return $this;
    }
}
