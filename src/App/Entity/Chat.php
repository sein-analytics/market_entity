<?php


namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\PersistentCollection;

#[ORM\Table(name: 'Chat')]
#[ORM\Entity(repositoryClass: \App\Repository\Chat::class)]
class Chat 
{
    /**
     * @var int
     **/
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    protected int $id;

    /**
     * @var MarketUser
     */
    #[ORM\ManyToOne(targetEntity:  MarketUser::class, inversedBy: 'chats')]
    protected $user;

    /**
     * @var MarketUser|null
     */
    #[ORM\JoinColumn(name: 'recipient_id', referencedColumnName: 'id', nullable: true)]
    #[ORM\ManyToOne(targetEntity:  MarketUser::class, inversedBy: 'chatRecipient')]
    protected $recipient;

    /**
     * @var MarketUser
     */
    #[ORM\JoinColumn(name: 'contact_id', referencedColumnName: 'id', nullable: true)]
    #[ORM\ManyToOne(targetEntity:  MarketUser::class)]
    protected $contact;

    /**
     * @var GroupChat|null
     */
    #[ORM\JoinColumn(name: 'group_id', referencedColumnName: 'id', nullable: true)]
    #[ORM\ManyToOne(targetEntity:  GroupChat::class, inversedBy: 'chats')]
    protected $group;

    /**
     * @var string
     */
    #[ORM\Column(type: 'blob', nullable: true)]
    protected string $message;

    /**
     * @var DateTime
     **/
    #[ORM\Column(type: 'datetime', nullable: false)]
    protected $messageDate;

    /**
     * @var array | null
     **/
    #[ORM\Column(type: 'json', nullable: true)]
    protected array|null $attachments;

    /**
     * @var PersistentCollection|ArrayCollection
     */
    #[ORM\JoinTable(name: 'chat_replies')]
    #[ORM\JoinColumn(name: 'chat_id', referencedColumnName: 'id')]
    #[ORM\InverseJoinColumn(name: 'response_id', referencedColumnName: 'id')]
    #[ORM\ManyToMany(targetEntity:  Chat::class)]
    protected $chatReplies;

    /**
     * @var ChatTracker
     */
    #[ORM\ManyToOne(targetEntity:  ChatTracker::class, inversedBy: 'chats')]
    protected $tracker;

    /**
     * @var ChatStatus
     */
    #[ORM\ManyToOne(targetEntity:  ChatStatus::class, inversedBy: 'chats')]
    protected $status;

    /**
     * @var bool
     */
    #[ORM\Column(type: 'boolean', nullable: false, options: ['default' => '0'])]
    protected bool $isGroup;

    public function __construct()
    {
        $this->chatReplies = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId():int { return $this->id; }

    /**
     * @return PersistentCollection|ArrayCollection
     */
    public function getChatReplies():PersistentCollection|ArrayCollection  { return $this->chatReplies; }

    public function addChatReply(Chat $chat):void {
        $this->chatReplies->add($chat);
    }
    /**
     * @return MarketUser
     */
    public function getUser(): MarketUser { return $this->user; }

    /**
     * @param MarketUser $user
     */
    public function setUser(MarketUser $user): void { $this->user = $user; }

    /**
     * @return MarketUser|null
     */
    public function getRecipient(): ?MarketUser { return $this->recipient; }

    /**
     * @param MarketUser $recipient
     */
    public function setRecipient(MarketUser $recipient): void { $this->recipient = $recipient; }

    /**
     * @return MarketUser
     */
    public function getContact(): MarketUser { return $this->contact; }

    /**
     * @param MarketUser $contact
     */
    public function setContact(MarketUser $contact): void { $this->contact = $contact; }

    /**
     * @return GroupChat|null
     */
    public function getGroup(): ?GroupChat { return $this->group; }

    /**
     * @param GroupChat $group
     */
    public function setGroup(GroupChat $group): void { $this->group = $group; }

    /**
     * @return string
     */
    public function getMessage(): string { return $this->message; }

    /**
     * @param string $message
     */
    public function setMessage(string $message): void { $this->message = $message; }

    /**
     * @return DateTime
     */
    public function getMessageDate(): DateTime { return $this->messageDate; }

    /**
     * @return array|null
     */
    public function getAttachments(): ? array { return $this->attachments; }

    /**
     * @return ChatTracker
     */
    public function getChatId(): ChatTracker { return $this->tracker; }

    /**
     * @return ChatTracker
     */
    public function getTracker(): ChatTracker { return $this->tracker; }

    /**
     * @param ChatTracker $tracker
     */
    public function setTracker(ChatTracker $tracker): void { $this->tracker = $tracker; }

    /**
     * @return ChatStatus
     */
    public function getStatus(): ChatStatus { return $this->status; }

    /**
     * @param ChatStatus $status
     */
    public function setStatus(ChatStatus $status): void { $this->status = $status; }

    /**
     * @return bool
     */
    public function isGroup(): bool { return $this->isGroup; }

    /**
     * @param bool $isGroup
     */
    public function setIsGroup(bool $isGroup): void { $this->isGroup = $isGroup; }


}