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

namespace Wacon\Filetransfer\Domain\Model;

use TYPO3\CMS\Extbase\Annotation\ORM\Cascade;
use TYPO3\CMS\Extbase\Domain\Model\FileReference;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

class Upload extends AbstractEntity
{
    /**
     * Subject of the E-Mail
     * @var string
     */
    protected string $subject = '';

    /**
     * Message of the E-Mail
     * @var string
     */
    protected string $message = '';

    /**
     * Token for the security link to download
     * @var string
     */
    protected string $token = '';

    /**
     * Amount of times the asset can be downloaded
     * @var int
     */
    protected int $downloadLimit = 1;

    /**
     * The asset to download. It is always a single zip file
     * @var FileReference
     */
    #[Cascade(['value' => 'remove'])]
    protected ?FileReference $asset = null;

    /**
     *  Date until the download is valid
     * @var \DateTime
     */
    protected ?\DateTime $validityDate = null;

    /**
     * Amount of days the download link is valid
     * @var int
     */
    protected int $validityDurationInDays = 3;

    /**
     * E-Mail Adress from the sender
     * @var string
     */
    protected string $senderAddress = '';

    /**
     * E-Mail Adress from the receiver
     * @var string
     */
    protected string $receiverAddress = '';

    /**
     * Get subject of the E-Mail
     *
     * @return  string
     */
    public function getSubject(): string
    {
        return $this->subject;
    }

    /**
     * Set subject of the E-Mail
     *
     * @param  string  $subject  Subject of the E-Mail
     *
     * @return  self
     */
    public function setSubject(string $subject): self
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * Get message of the E-Mail
     *
     * @return  string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * Set message of the E-Mail
     *
     * @param  string  $message  Message of the E-Mail
     *
     * @return  self
     */
    public function setMessage(string $message): self
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Get token for the security link to download
     *
     * @return  string
     */
    public function getToken(): string
    {
        return $this->token;
    }

    /**
     * Set token for the security link to download
     *
     * @param  string  $token  Token for the security link to download
     *
     * @return  self
     */
    public function setToken(string $token): self
    {
        $this->token = $token;

        return $this;
    }

    /**
     * Get amount of times the asset can be downloaded
     *
     * @return  int
     */
    public function getDownloadLimit(): int
    {
        return $this->downloadLimit;
    }

    /**
     * Set amount of times the asset can be downloaded
     *
     * @param  int  $downloaded  Amount of times the asset is downloaded
     *
     * @return  self
     */
    public function setDownloadLimit(int $downloadLimit): self
    {
        $this->downloadLimit = $downloadLimit;

        return $this;
    }

    /**
     * Decrement download limit
     */
    public function decrementDownloadLimit()
    {
        $this->downloadLimit--;

        if ($this->downloadLimit < 0) {
            $this->downloadLimit = 0;
        }
    }

    /**
     * Get the asset to download. It is always a single zip file
     *
     * @return  FileReference
     */
    public function getAsset(): ?FileReference
    {
        return $this->asset;
    }

    /**
     * Set the asset to download. It is always a single zip file
     *
     * @param  FileReference  $asset  The asset to download. It is always a single zip file
     *
     * @return  self
     */
    public function setAsset(FileReference $asset): self
    {
        $this->asset = $asset;

        return $this;
    }

    /**
     * Get date until the download is valid
     *
     * @return  \DateTime
     */
    public function getValidityDate(): \DateTime
    {
        return $this->validityDate;
    }

    /**
     * Set date until the download is valid
     *
     * @param  \DateTime  $validityDate  Date until the download is valid
     *
     * @return  self
     */
    public function setValidityDate(\DateTime $validityDate = null): self
    {
        $this->validityDate = $validityDate;

        return $this;
    }

    /**
     * Calculate and set the validity date based on validityDurcationInDays
     */
    public function calculateAndSetValidityDate()
    {
        $this->validityDate = new \DateTime();
        $this->validityDate->add(\DateInterval::createFromDateString(((string)$this->validityDurationInDays) . ' day'));
    }

    /**
     * Get e-Mail Adress from the sender
     *
     * @return  string
     */
    public function getSenderAddress(): string
    {
        return $this->senderAddress;
    }

    /**
     * Set e-Mail Adress from the sender
     *
     * @param  string  $senderAddress  E-Mail Adress from the sender
     *
     * @return  self
     */
    public function setSenderAddress(string $senderAddress): self
    {
        $this->senderAddress = $senderAddress;

        return $this;
    }

    /**
     * Get e-Mail Adress from the receiver
     *
     * @return  string
     */
    public function getReceiverAddress(): string
    {
        return $this->receiverAddress;
    }

    /**
     * Set e-Mail Adress from the receiver
     *
     * @param  string  $receiverAddress  E-Mail Adress from the receiver
     *
     * @return  self
     */
    public function setReceiverAddress(string $receiverAddress): self
    {
        $this->receiverAddress = $receiverAddress;

        return $this;
    }

    /**
     * Get amount of days the download link is valid
     *
     * @return  int
     */
    public function getValidityDurationInDays(): int
    {
        return $this->validityDurationInDays;
    }

    /**
     * Set amount of days the download link is valid
     *
     * @param  int  $validityDurationInDays  Amount of days the download link is valid
     *
     * @return  self
     */
    public function setValidityDurationInDays(int $validityDurationInDays): self
    {
        $this->validityDurationInDays = $validityDurationInDays;

        return $this;
    }

    public function setTestData()
    {
        $this->senderAddress = 'kevin.lee@wacon.de';
        $this->receiverAddress = 'slavlee@gmx.de';
        $this->subject = 'Lorem Ipsum Subject';
        $this->message = 'Lorem Ipsum Message';
        $this->validityDurationInDays = 3;
        $this->downloadLimit = 1;
    }
}
