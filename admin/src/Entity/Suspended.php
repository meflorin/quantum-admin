<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Suspended
 *
 * @ORM\Table(name="suspended", uniqueConstraints={@ORM\UniqueConstraint(name="unique_ethaddr", columns={"eth_address"})})
 * @ORM\Entity
 */
class Suspended
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
     * @ORM\Column(name="eth_address", type="string", length=42, nullable=true)
     */
    private $ethAddress;

    /**
     * @var string|null
     *
     * @ORM\Column(name="action_by", type="string", length=42, nullable=true)
     */
    private $actionBy;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="is_pending", type="boolean", nullable=true)
     */
    private $isPending = '0';

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=true, options={"default"="CURRENT_TIMESTAMP"})
     */
    private $createdAt = 'CURRENT_TIMESTAMP';

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     */
    private $updatedAt;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getActionBy(): ?string
    {
        return $this->actionBy;
    }

    public function setActionBy(?string $actionBy): self
    {
        $this->actionBy = $actionBy;

        return $this;
    }

    public function getIsPending(): ?bool
    {
        return $this->isPending;
    }

    public function setIsPending(?bool $isPending): self
    {
        $this->isPending = $isPending;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }


}
