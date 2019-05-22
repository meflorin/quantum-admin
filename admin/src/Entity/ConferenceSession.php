<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ConferenceSession
 *
 * @ORM\Table(name="conference_session", uniqueConstraints={@ORM\UniqueConstraint(name="ref", columns={"ref"})}, indexes={@ORM\Index(name="fk_conference_session_room_room_id", columns={"room_id"}), @ORM\Index(name="fk_conference_session_user_owner_id", columns={"owner_id"})})
 * @ORM\Entity
 */
class ConferenceSession
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="ref", type="string", length=14, nullable=false)
     */
    private $ref;

    /**
     * @var string
     *
     * @ORM\Column(name="owner", type="string", length=50, nullable=false)
     */
    private $owner;

    /**
     * @var int
     *
     * @ORM\Column(name="fee", type="integer", nullable=false, options={"comment"="cents"})
     */
    private $fee;

    /**
     * @var int
     *
     * @ORM\Column(name="fee_wei", type="bigint", nullable=false, options={"comment"="wei"})
     */
    private $feeWei = '0';

    /**
     * @var float
     *
     * @ORM\Column(name="eth_usd", type="float", precision=10, scale=0, nullable=false, options={"comment"="conversion rate"})
     */
    private $ethUsd = '0';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_added", type="datetime", nullable=false)
     */
    private $dateAdded;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="is_open", type="boolean", nullable=true)
     */
    private $isOpen;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @var string|null
     *
     * @ORM\Column(name="description", type="text", length=65535, nullable=true)
     */
    private $description;

    /**
     * @var \Room
     *
     * @ORM\ManyToOne(targetEntity="Room")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="room_id", referencedColumnName="id")
     * })
     */
    private $room;

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="owner_id", referencedColumnName="id")
     * })
     */
    private $owner2;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRef(): ?string
    {
        return $this->ref;
    }

    public function setRef(string $ref): self
    {
        $this->ref = $ref;

        return $this;
    }

    public function getOwner(): ?string
    {
        return $this->owner;
    }

    public function setOwner(string $owner): self
    {
        $this->owner = $owner;

        return $this;
    }

    public function getFee(): ?int
    {
        return $this->fee;
    }

    public function setFee(int $fee): self
    {
        $this->fee = $fee;

        return $this;
    }

    public function getFeeWei(): ?int
    {
        return $this->feeWei;
    }

    public function setFeeWei(int $feeWei): self
    {
        $this->feeWei = $feeWei;

        return $this;
    }

    public function getEthUsd(): ?float
    {
        return $this->ethUsd;
    }

    public function setEthUsd(float $ethUsd): self
    {
        $this->ethUsd = $ethUsd;

        return $this;
    }

    public function getDateAdded(): ?\DateTimeInterface
    {
        return $this->dateAdded;
    }

    public function setDateAdded(\DateTimeInterface $dateAdded): self
    {
        $this->dateAdded = $dateAdded;

        return $this;
    }

    public function getIsOpen(): ?bool
    {
        return $this->isOpen;
    }

    public function setIsOpen(?bool $isOpen): self
    {
        $this->isOpen = $isOpen;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

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

    public function getRoom(): ?Room
    {
        return $this->room;
    }

    public function setRoom(?Room $room): self
    {
        $this->room = $room;

        return $this;
    }

    public function getOwner2(): ?User
    {
        return $this->owner2;
    }

    public function setOwner2(?User $owner2): self
    {
        $this->owner2 = $owner2;

        return $this;
    }

    public function getEthDollarConversion(): ?string
    {
        return round($this->getEthUsd(), 2) . ' $';
    }

    public function getHourRateDollar(): ?string
    {
        return number_format($this->getFee()/100, 2, '.', ' ') . ' $ / ' . $this->getFee() . ' cents';
    }

    public function getHourRateEth(): ?string
    {
        return round($this->getFeeWei()/10 ** 18, 6) . ' ETH / ' . $this->getFeeWei() . ' wei';
    }

}
