<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ConferenceSessionUser
 *
 * @ORM\Table(name="conference_session_user")
 * @ORM\Entity
 */
class ConferenceSessionUser
{
    /**
     * @var string
     *
     * @ORM\Column(name="conference_session_id", type="string", length=14, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $conferenceSessionId;

    /**
     * @var int
     *
     * @ORM\Column(name="user_id", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $userId;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="is_kp", type="boolean", nullable=true)
     */
    private $isKp = '0';

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="data_start", type="datetime", nullable=true)
     */
    private $dataStart;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="data_end", type="datetime", nullable=true)
     */
    private $dataEnd;

    /**
     * @var int|null
     *
     * @ORM\Column(name="duration", type="bigint", nullable=true)
     */
    private $duration;

    /**
     * @var int|null
     *
     * @ORM\Column(name="cost_eth", type="bigint", nullable=true, options={"comment"="wei"})
     */
    private $costEth = '0';

    /**
     * @var float|null
     *
     * @ORM\Column(name="cost_usd", type="float", precision=10, scale=0, nullable=true, options={"comment"="dollar"})
     */
    private $costUsd = '0';

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User", inversedBy="conference")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * })
     */
    private $user;

    public function getConferenceSessionId(): ?string
    {
        return $this->conferenceSessionId;
    }

    public function getUserId(): ?int
    {
        return $this->userId;
    }

    public function getIsKp(): ?bool
    {
        return $this->isKp;
    }

    public function setIsKp(?bool $isKp): self
    {
        $this->isKp = $isKp;

        return $this;
    }

    public function getDataStart(): ?\DateTimeInterface
    {
        return $this->dataStart;
    }

    public function setDataStart(?\DateTimeInterface $dataStart): self
    {
        $this->dataStart = $dataStart;

        return $this;
    }

    public function getDataEnd(): ?\DateTimeInterface
    {
        return $this->dataEnd;
    }

    public function setDataEnd(?\DateTimeInterface $dataEnd): self
    {
        $this->dataEnd = $dataEnd;

        return $this;
    }

    public function getDuration(): ?int
    {
        return $this->duration;
    }

    public function setDuration(?int $duration): self
    {
        $this->duration = $duration;

        return $this;
    }

    public function getCostEth(): ?int
    {
        return $this->costEth;
    }

    public function setCostEth(?int $costEth): self
    {
        $this->costEth = $costEth;

        return $this;
    }

    public function getCostUsd(): ?float
    {
        return $this->costUsd;
    }

    public function setCostUsd(?float $costUsd): self
    {
        $this->costUsd = $costUsd;

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
}
