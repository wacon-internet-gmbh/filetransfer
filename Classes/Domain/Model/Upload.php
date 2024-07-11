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

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Core\Resource\FileReference;

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
     * Amount of times the asset is downloaded
     * @var int
     */
    protected int $downloaded = 0;

    /**
     * The asset to download. It is always a single zip file
     * @var FileReference
     */
    protected FileReference $asset;

    /**
     *  Date until the download is valid
     * @var \DateTime
     */
    protected \DateTime $validityDate = null;

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
     * Get amount of times the asset is downloaded
     *
     * @return  int
     */
    public function getDownloaded(): int
    {
        return $this->downloaded;
    }

    /**
     * Set amount of times the asset is downloaded
     *
     * @param  int  $downloaded  Amount of times the asset is downloaded
     *
     * @return  self
     */
    public function setDownloaded(int $downloaded): self
    {
        $this->downloaded = $downloaded;

        return $this;
    }

    /**
     * Get the asset to download. It is always a single zip file
     *
     * @return  FileReference
     */
    public function getAsset(): FileReference
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
}
