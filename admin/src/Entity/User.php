<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * User
 *
 * @ORM\Table(name="user", uniqueConstraints={@ORM\UniqueConstraint(name="unique_ethaddr", columns={"eth_address"})})
 * @ORM\Entity
 */
class User
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="bigint", nullable=false, options={"unsigned"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string|null
     *
     * @ORM\Column(name="fullname", type="string", length=100, nullable=true)
     */
    private $fullname;


    /**
     * @var string|null
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=true)
     */
    private $email;

    /**
     * @var string|null
     *
     * @ORM\Column(name="eth_address", type="string", length=42, nullable=true)
     */
    private $ethAddress;

    /**
     * @var string|null
     *
     * @ORM\Column(name="public_key", type="string", length=255, nullable=true)
     */
    private $publicKey;

    /**
     * @var string
     *
     * @ORM\Column(name="registered_from", type="string", length=32, nullable=false)
     */
    private $registeredFrom;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="last_login", type="datetime", nullable=true)
     */
    private $lastLogin;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     */
    private $createdAt;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="is_suspended", type="boolean", nullable=true)
     */
    private $isSuspended = '0';

    /**
     * @var string|null
     *
     * @ORM\Column(name="access_token", type="string", length=36, nullable=true)
     */
    private $accessToken;

    /**
     * @var string|null
     *
     * @ORM\Column(name="last_session_id", type="string", length=32, nullable=true, options={"fixed"=true})
     */
    private $lastSessionId;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="is_banned", type="boolean", nullable=true)
     */
    private $isBanned = '0';

    /**
     * @var bool|null
     *
     * @ORM\Column(name="is_photo_valid", type="boolean", nullable=true, options={"default"="1"})
     */
    private $isPhotoValid = '1';

    /**
     * @var string|null
     *
     * @ORM\Column(name="avatar_url", type="string", length=256, nullable=true)
     */
    private $avatarUrl;

    /**
     * @var string|null
     *
     * @ORM\Column(name="country_code", type="string", length=10, nullable=true)
     */
    private $countryCode;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="birth_date", type="date", nullable=false)
     */
    private $birthDate;

    /**
     * @var \Moderation
     *
     * @ORM\OneToMany(targetEntity="Moderation", mappedBy="user")
     * @ORM\OrderBy({"createdAt" = "DESC"})
     */
    private $moderation;

    /**
     * @var \ConferenceSessionUser
     *
     * @ORM\OneToMany(targetEntity="ConferenceSessionUser", mappedBy="user")
     */
    private $conference;

    /**
     * @var \RoomUser
     *
     * @ORM\OneToMany(targetEntity="RoomUser", mappedBy="user")
     */
    private $rooms;

    public function __construct() {
        $this->moderation = new ArrayCollection();
        $this->conference = new ArrayCollection();
        $this->rooms = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFullname(): ?string
    {
        return $this->fullname;
    }

    public function setFullname(?string $fullname): self
    {
        $this->fullname = $fullname;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getEthAddress(): ?string
    {
        return $this->ethAddress;
    }

    public function setEthAddress(?string $ethAddress): self
    {
        $this->ethAddress = $ethAddress;

        return $this;
    }

    public function getPublicKey(): ?string
    {
        return $this->publicKey;
    }

    public function setPublicKey(?string $publicKey): self
    {
        $this->publicKey = $publicKey;

        return $this;
    }

    public function getRegisteredFrom(): ?string
    {
        return $this->registeredFrom;
    }

    public function setRegisteredFrom(string $registeredFrom): self
    {
        $this->registeredFrom = $registeredFrom;

        return $this;
    }

    public function getLastLogin(): ?\DateTimeInterface
    {
        return $this->lastLogin;
    }

    public function setLastLogin(?\DateTimeInterface $lastLogin): self
    {
        $this->lastLogin = $lastLogin;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }


    public function getIsSuspended(): ?bool
    {
        return $this->isSuspended;
    }

    public function setIsSuspended(?bool $isSuspended): self
    {
        $this->isSuspended = $isSuspended;

        return $this;
    }

    public function getAccessToken(): ?string
    {
        return $this->accessToken;
    }

    public function setAccessToken(?string $accessToken): self
    {
        $this->accessToken = $accessToken;

        return $this;
    }

    public function getLastSessionId(): ?string
    {
        return $this->lastSessionId;
    }

    public function setLastSessionId(?string $lastSessionId): self
    {
        $this->lastSessionId = $lastSessionId;

        return $this;
    }

    public function getIsBanned(): ?bool
    {
        return $this->isBanned;
    }

    public function setIsBanned(?bool $isBanned): self
    {
        $this->isBanned = $isBanned;

        return $this;
    }

    public function getIsPhotoValid(): ?bool
    {
        return $this->isPhotoValid;
    }

    public function setIsPhotoValid(?bool $isPhotoValid): self
    {
        $this->isPhotoValid = $isPhotoValid;

        return $this;
    }

    public function getAvatarUrl(): ?string
    {
        return $this->avatarUrl;
    }

    public function setAvatarUrl(?string $avatarUrl): self
    {
        $this->avatarUrl = $avatarUrl;

        return $this;
    }

    public function getCountryCode(): ?string
    {
        return $this->countryCode;
    }

    public function setCountryCode(?string $countryCode): self
    {
        $this->countryCode = $countryCode;

        return $this;
    }

    public function getBirthDate(): ?\DateTimeInterface
    {
        return $this->birthDate;
    }

    public function setBirthDate(\DateTimeInterface $birthDate): self
    {
        $this->birthDate = $birthDate;

        return $this;
    }

    public function getModeration()
    {
        return $this->moderation;
    }

    public function getConference()
    {
        return $this->conference;
    }

    public function getRooms()
    {
        return $this->rooms;
    }


}
