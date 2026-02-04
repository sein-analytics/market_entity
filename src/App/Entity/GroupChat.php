<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\PersistentCollection;

#[ORM\Table(name: 'ChatGroup')]
#[ORM\Entity(repositoryClass: \App\Repository\GroupChat::class)]
class GroupChat
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    #[ORM\Column(name: 'id', type: 'integer')]
    protected int $id;

    /**
     * @var string
     */
    #[ORM\Column(type: 'string', unique: true)]
    protected string $uuid;

    /**
     * @var string
     */
    #[ORM\Column(type: 'string', nullable: false, options: ['default' => 'group_chat'])]
    protected string $groupName;

    /**
     * @var ?string
     */
    #[ORM\Column(type: 'string', nullable: true)]
    protected ?string $imageUrl;

    /**
     * @var MarketUser
     */
    #[ORM\ManyToOne(targetEntity:  \App\Entity\MarketUser::class, inversedBy: 'groupChats')]
    protected $user;

    /**
     * @var int
     */
    #[ORM\Column(type: 'boolean', nullable: false, options: ['default' => '0'])]
    protected int  $isPrivate = 0;

    /**
     * @var PersistentCollection|ArrayCollection
     */
    #[ORM\OneToMany(targetEntity:  \App\Entity\Chat::class, mappedBy: 'group')]
    protected $chats;

    /**
     * @var Community|null
     */
    #[ORM\JoinColumn(name: 'community_id', referencedColumnName: 'id', nullable: true)]
    #[ORM\ManyToOne(targetEntity:  \App\Entity\Community::class, inversedBy: 'groupChats')]
    protected $community=null;

    /**
     * @var ChatTracker|null
     */
    #[ORM\JoinColumn(name: 'tracker_id', referencedColumnName: 'id', nullable: true)]
    #[ORM\OneToOne(targetEntity:  \App\Entity\ChatTracker::class, inversedBy: 'group')]
    protected $tracker=null;

    /**
     * @var PersistentCollection|ArrayCollection
     */
    #[ORM\JoinTable(name: 'chat_group_market_users')]
    #[ORM\ManyToMany(targetEntity:  \App\Entity\MarketUser::class, inversedBy: 'chatGroupMemberships')]
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