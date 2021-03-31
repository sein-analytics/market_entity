<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\PersistentCollection;

/**
 * @ORM\Entity(repositoryClass="\App\Repository\GroupChat")
 * @ORM\Table(name="ChatGroup")
 */
class GroupChat
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     *
     **/
    protected $id;

    /**
     * @ORM\GeneratedValue(strategy="UUID")
     * @ORM\Column(type="string", unique=true)
     * @var string
     */
    protected $uuid;

    /**
     * @ORM\Column(type="string", nullable=false, options={"default":"group_chat"})
     * @var string
     */
    protected $groupName;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var string
     */
    protected $imageUrl;

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
     * @var PersistentCollection|ArrayCollection
     */
    protected $chats;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\Community", inversedBy="groupChats")
     * @var Community|null
     */
    protected $community;

    /**
     * @ORM\OneToOne (targetEntity="\App\Entity\ChatTracker", inversedBy="group")
     * @var ChatTracker
     */
    protected $tracker;

    /**
     * @ORM\ManyToMany(targetEntity="\App\Entity\MarketUser", inversedBy="chatGroupMemberships")
     * @ORM\JoinTable(name="chat_group_market_users")
     * @var PersistentCollection|ArrayCollection
     */
    protected $members;

    public function __construct()
    {
        $this->members = new ArrayCollection();
        $this->chats = new ArrayCollection();
    }

    public function addToGroup($groupMember)
    {
        if ($groupMember instanceof MarketUser)
            $this->getMembers()->add($groupMember);
    }

    public function addChat(Chat $chat){
        $this->getChats()->add($chat);
    }

    /**
     * @return int
     */
    public function getId():int { return $this->id; }

    /**
     * @return string
     */
    public function getUuid(): string { return $this->uuid; }

    /**
     * @return string
     */
    public function getGroupName(): string { return $this->groupName; }

    /**
     * @return string
     */
    public function getImageUrl(): string { return $this->imageUrl; }

    /**
     * @return MarketUser
     */
    public function getUser(): MarketUser { return $this->user; }

    /**
     * @return bool
     */
    public function isPrivate(): bool { return $this->isPrivate; }

    /**
     * @return PersistentCollection|ArrayCollection
     */
    public function getChats() { return $this->chats; }

    /**
     * @return Community|null
     */
    public function getCommunity(): ?Community { return $this->community; }

    /**
     * @return PersistentCollection|ArrayCollection
     */
    public function getMembers() { return $this->members; }


    /**
     * @return ChatTracker
     */
    public function getTracker(): ChatTracker { return $this->tracker; }

    /**
     * @param string $uuid
     */
    public function setUuid(string $uuid): void { $this->uuid = $uuid; }

    /**
     * @param string $groupName
     */
    public function setGroupName(string $groupName): void { $this->groupName = $groupName; }

    /**
     * @param string $imageUrl
     */
    public function setImageUrl(string $imageUrl): void { $this->imageUrl = $imageUrl; }

    /**
     * @param MarketUser $user
     */
    public function setUser(MarketUser $user): void { $this->user = $user; }

    /**
     * @param bool $isPrivate
     */
    public function setIsPrivate(bool $isPrivate): void { $this->isPrivate = $isPrivate; }

    /**
     * @param Community|null $community
     */
    public function setCommunity(?Community $community): void { $this->community = $community; }



}