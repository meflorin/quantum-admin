<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * RoomUser
 *
 * @ORM\Table(name="room_user", uniqueConstraints={@ORM\UniqueConstraint(name="unique_user_id_room_id", columns={"room_id", "user_id"})}, indexes={@ORM\Index(name="fk_room_user_user_id", columns={"user_id"}), @ORM\Index(name="IDX_EE973C2D54177093", columns={"room_id"})})
 * @ORM\Entity
 */
class RoomUser
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
     * @var bool|null
     *
     * @ORM\Column(name="is_admin", type="boolean", nullable=true)
     */
    private $isAdmin = '0';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_added", type="datetime", nullable=false)
     */
    private $dateAdded;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="is_active", type="boolean", nullable=true, options={"default"="1"})
     */
    private $isActive = '1';

    /**
     * @var \Room
     *
     * @ORM\ManyToOne(targetEntity="Room", inversedBy="members")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="room_id", referencedColumnName="id")
     * })
     */
    private $room;

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User", inversedBy="rooms")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * })
     */
    private $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIsAdmin(): ?bool
    {
        return $this->isAdmin;
    }

    public function setIsAdmin(?bool $isAdmin): self
    {
        $this->isAdmin = $isAdmin;

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

    public function getIsActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(?bool $isActive): self
    {
        $this->isActive = $isActive;

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

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /*
    public function getAccount(): ?Room
    {
        return $this->account;
    }

    public function setAccount(?Room $account): self
    {
        $this->account = $account;

        return $this;
    }
    */

}

