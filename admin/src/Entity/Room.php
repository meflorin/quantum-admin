<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Criteria;

/**
 * Room
 *
 * @ORM\Table(name="room")
 * @ORM\Entity
 */
class Room
{
    const ADMIN_SUSPENDED = 'HAS SUSPEND REQUEST';
    const ADMIN_BANNED = 'BANNED';
    const ADMIN_OK = 'OK';
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     *
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @var int|null
     *
     * @ORM\Column(name="type", type="integer", nullable=true, options={"default"="1","comment"="1: one to one with a user from contact list; 2: group; 3: video session"})
     */
    private $type = '1';

    /**
     * @var int|null
     *
     * @ORM\Column(name="encrypted", type="integer", nullable=true, options={"comment"="0: no; 1: yes"})
     */
    private $encrypted = '0';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_added", type="datetime", nullable=false)
     */
    private $dateAdded;

    /**
     * @var string|null
     *
     * @ORM\Column(name="description", type="text", length=65535, nullable=true)
     */
    private $description;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="discoverable", type="boolean", nullable=true, options={"comment"="for private groups, 0 - not discoverable 1- discoverable"})
     */
    private $discoverable = '0';

    /**
     * @var \RoomUser
     *
     * @ORM\OneToMany(targetEntity="RoomUser", mappedBy="room")
     * @ORM\OrderBy({"isAdmin"="DESC"})
     */
    private $members;

    public function __construct()
    {
        $this->members = new ArrayCollection();;
    }

    public function getMembers()
    {
        return $this->members;
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getType(): ?int
    {
        return $this->type;
    }

    public function setType(?int $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getEncrypted(): ?int
    {
        return $this->encrypted;
    }

    public function setEncrypted(?int $encrypted): self
    {
        $this->encrypted = $encrypted;

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getDiscoverable(): ?bool
    {
        return $this->discoverable;
    }

    public function setDiscoverable(?bool $discoverable): self
    {
        $this->discoverable = $discoverable;

        return $this;
    }

    public function getAdmin()
    {
        $admin = null;
        $roomMembers = $this->members->getValues();

        if(is_array($roomMembers) && count($roomMembers) > 0 && $roomMembers[0]->getIsAdmin()) {
            $admin = $roomMembers[0]->getUser()->getEmail();
        }

        return $admin;
        //dump($this->entries->getValues());
        //$criteria = Criteria::create()->where(Criteria::expr()->eq('is_admin', true));
        //var_dump($criteria);die;
        //$x = $this->entries->matching($criteria);
        //return $this->entries->matching($criteria);
    }

    public function getAdminStatus()
    {
        $adminStatus = '';
        $roomMembers = $this->members->getValues();

        if(is_array($roomMembers) && count($roomMembers) > 0 && $roomMembers[0]->getIsAdmin()) {

            $adminStatus .= $roomMembers[0]->getUser()->getIsSuspended() ? self::ADMIN_SUSPENDED . ' ! ' : '';
            $adminStatus .= $roomMembers[0]->getUser()->getIsBanned() ? self::ADMIN_BANNED . ' ! ' : '';
        }

        if (strlen($adminStatus) == 0) {
            return self::ADMIN_OK;
        }

        return $adminStatus;
    }

    public function getNbRoomMembers()
    {
        return count($this->members->getValues());
    }
}
