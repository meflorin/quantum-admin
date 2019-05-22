<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Moderation
 *
 * @ORM\Table(name="moderation", indexes={@ORM\Index(name="moderation_user_id_fk", columns={"user_id"})})
 * @ORM\Entity
 */
class Moderation
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
     * @var string
     *
     * @ORM\Column(name="action_by", type="string", length=42, nullable=false)
     */
    private $actionBy;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=false, options={"default"="CURRENT_TIMESTAMP"})
     */
    private $createdAt = 'CURRENT_TIMESTAMP';

    /**
     * @var string
     *
     * @ORM\Column(name="action", type="string", length=255, nullable=false)
     */
    private $action;

    /**
     * @var integer
     *
     * @ORM\Column(name="user_id", type="bigint", nullable=false, options={"unsigned"=true})
     */
    public $userId;

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User", inversedBy="moderation")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * })
     */
    private $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getActionBy(): ?string
    {
        return $this->actionBy;
    }

    public function setActionBy(string $actionBy): self
    {
        $this->actionBy = $actionBy;

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

    public function getAction(): ?string
    {
        return $this->action;
    }

    public function setAction(string $action): self
    {
        $this->action = $action;

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

    public function getUserId(): ?int
    {
        return $this->userId;
    }


    public function setUserId($userId): self
    {

        $this->userId = (int) $userId;

        return $this;
    }
}
