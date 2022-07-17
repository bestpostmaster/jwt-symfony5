<?php

namespace App\Entity;

use App\Repository\HostedFileRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=HostedFileRepository::class)
 */
class HostedFile
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $path;

    /**
     * @ORM\Column(type="datetime")
     */
    private $uploadDate;

    /**
     * @ORM\ManyToOne(targetEntity=User::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $virtualDirectory;

    /**
     * @ORM\Column(type="bigint")
     */
    private $size;

    /**
     * @ORM\Column(type="boolean")
     */
    private $scaned;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="bigint")
     */
    private $downloadCounter;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $url;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $uploadLocalisation;

    /**
     * @ORM\Column(type="boolean")
     */
    private $copyrightIssue;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $conversionsAvailable;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPath(): ?string
    {
        return $this->path;
    }

    public function setPath(string $path): self
    {
        $this->path = $path;

        return $this;
    }

    public function getUploadDate(): ?\DateTimeInterface
    {
        return $this->uploadDate;
    }

    public function setUploadDate(\DateTimeInterface $uploadDate): self
    {
        $this->uploadDate = $uploadDate;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getVirtualDirectory(): ?string
    {
        return $this->virtualDirectory;
    }

    public function setVirtualDirectory(string $virtualDirectory): self
    {
        $this->virtualDirectory = $virtualDirectory;

        return $this;
    }

    public function getSize(): ?string
    {
        return $this->size;
    }

    public function setSize(string $size): self
    {
        $this->size = $size;

        return $this;
    }

    public function getScaned(): ?bool
    {
        return $this->scaned;
    }

    public function setScaned(bool $scaned): self
    {
        $this->scaned = $scaned;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getDownloadCounter(): ?string
    {
        return $this->downloadCounter;
    }

    public function setDownloadCounter(string $downloadCounter): self
    {
        $this->downloadCounter = $downloadCounter;

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function getUploadLocalisation(): ?string
    {
        return $this->uploadLocalisation;
    }

    public function setUploadLocalisation(?string $uploadLocalisation): self
    {
        $this->uploadLocalisation = $uploadLocalisation;

        return $this;
    }

    public function getCopyrightIssue(): ?bool
    {
        return $this->copyrightIssue;
    }

    public function setCopyrightIssue(bool $copyrightIssue): self
    {
        $this->copyrightIssue = $copyrightIssue;

        return $this;
    }

    public function getConversionsAvailable(): ?string
    {
        return $this->conversionsAvailable;
    }

    public function setConversionsAvailable(?string $conversionsAvailable): self
    {
        $this->conversionsAvailable = $conversionsAvailable;

        return $this;
    }
}
