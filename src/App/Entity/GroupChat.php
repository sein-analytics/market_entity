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
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(name="id", type="integer")
     *
     **/
    protected int $id;

    /**
     * @ORM\Column(type="string", unique=true)
     * @var string
     */
    protected string $uuid;

    /**
     * @ORM\Column(type="string", nullable=false, options={"default":"group_chat"})
     * @var string
     */
    protected string $groupName;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var ?string
     */
    protected ?string $imageUrl;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\MarketUser", inversedBy="groupChats")
     * @var MarketUser
     */
    protected $user;

    /**
     * @ORM\Column(type="boolean", nullable=false, options={"default":"0"})
     * @var int
     */
    protected int  $isPrivate = 0;

    /**
     * @ORM\OneToMany(targetEntity="\App\Entity\Chat", mappedBy="group")
     * @var PersistentCollection|ArrayCollection
     */
    protected $chats;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\Community", inversedBy="groupChats")
     * @ORM\JoinColumn(name="community_id", referencedColumnName="id", nullable=true)
     * @var Community|null
     */
    protected $community=null;

    /**
     * @ORM\OneToOne (targetEntity="\App\Entity\ChatTracker", inversedBy="group")
     * @ORM\JoinColumn(name="tracker_id", referencedColumnName="id", nullable=true)
     * @var ChatTracker|null
     */
    protected $tracker=null;

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
     * @return ?string
     */
    public function getImageUrl(): ?string { return $this->imageUrl; }

    /**
     * @return MarketUser
     */
    public function getUser(): MarketUser { return $this->user; }

    /**
     * @return ?int
     */
    public function isPrivate(): ?int { return $this->isPrivate; }

    /**
     * @return PersistentCollection|ArrayCollection
     */
    public function getChats():PersistentCollection|ArrayCollection { return $this->chats; }

    /**
     * @return Community|null
     */
    public function getCommunity(): ?Community { return $this->community; }

    /**
     * @return PersistentCollection|ArrayCollection
     */
    public function getMembers():PersistentCollection|ArrayCollection { return $this->members; }


    /**
     * @return ?ChatTracker
     */
    public function getTracker(): ?ChatTracker { return $this->tracker; }

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
     * @param int $isPrivate
     */
    public function setIsPrivate(int $isPrivate): void { $this->isPrivate = $isPrivate; }

    /**
     * @param Community|null $community
     */
    public function setCommunity(?Community $community): void { $this->community = $community; }

    /**
     * @param ChatTracker|null $tracker
     */
    public function setTracker(?ChatTracker $tracker): void { $this->tracker = $tracker; }


}