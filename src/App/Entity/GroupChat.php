<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
/**
 * @ORM\Entity
 * @ORM\Table(name="ChatGroup")
 */
class GroupChat
{
    /**
     * @ORM\Id @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     **/
    protected $id;

    /**
     * @ORM\GeneratedValue(strategy="UUID")
     * @ORM\Column(type="string", unique=true)
     * @var string
     */
    protected $uuid;

    /**
     * @ORM\Column(type="string", nullable=false)
     * @var string
     */
    protected $groupName;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\MarketUser", inversedBy="groupChats")
     * @var MarketUser
     */
    protected $user;

    /**
     * @ORM\Column(type="boolean", nullable=false, options={"default":"0"})
     * @var bool
     */
    protected $isPrivate;

    /**
     * @ORM\OneToMany(targetEntity="\App\Entity\Chat", mappedBy="group")
     * @var ArrayCollection
     */
    protected $chats;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\Community", inversedBy="groupChats")
     * @var Community|null
     */
    protected $community;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getUuid(): string
    {
        return $this->uuid;
    }

    /**
     * @return string
     */
    public function getGroupName(): string
    {
        return $this->groupName;
    }

    /**
     * @return MarketUser
     */
    public function getUser(): MarketUser
    {
        return $this->user;
    }

    /**
     * @return bool
     */
    public function isPrivate(): bool
    {
        return $this->isPrivate;
    }

    /**
     * @return ArrayCollection
     */
    public function getChats(): ArrayCollection
    {
        return $this->chats;
    }

    /**
     * @return Community|null
     */
    public function getCommunity(): ?Community
    {
        return $this->community;
    }




}