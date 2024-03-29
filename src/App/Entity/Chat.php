<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\PersistentCollection;

/**
 * @ORM\Entity(repositoryClass="\App\Repository\Chat")
 * @ORM\Table(name="Chat")
 */
class Chat 
{
    /**
     * @ORM\Id 
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @var int
     **/
    protected int $id;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\MarketUser", inversedBy="chats")
     * @var MarketUser
     */
    protected $user;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\MarketUser", inversedBy="chatRecipient")
     * @ORM\JoinColumn(name="recipient_id", referencedColumnName="id", nullable=true)
     * @var MarketUser|null
     */
    protected $recipient;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\MarketUser")
     * @ORM\JoinColumn(name="contact_id", referencedColumnName="id", nullable=true)
     * @var MarketUser
     */
    protected $contact;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\GroupChat", inversedBy="chats")
     * @ORM\JoinColumn(name="group_id", referencedColumnName="id", nullable=true)
     * @var GroupChat|null
     */
    protected $group;

    /**
     * @ORM\Column(type="blob", nullable=true)
     * @var string
     */
    protected string $message;

    /**
     * @ORM\Column(type="datetime", nullable=false)
     * @var \DateTime
     **/
    protected $messageDate;

    /**
     * @ORM\Column(type="json", nullable=true)
     * @var array | null
     **/
    protected array|null $attachments;

    /**
     * @ORM\ManyToMany(targetEntity="\App\Entity\Chat")
     * @ORM\JoinTable(name="chat_replies",
     *      joinColumns={@ORM\JoinColumn(name="chat_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="response_id", referencedColumnName="id")}
     *     )
     * @var PersistentCollection|ArrayCollection
     */
    protected $chatReplies;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\ChatTracker", inversedBy="chats")
     * @var ChatTracker
     */
    protected $tracker;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\ChatStatus", inversedBy="chats")
     * @var ChatStatus
     */
    protected $status;

    /**
     * @ORM\Column(type="boolean", nullable=false, options={"default":"0"})
     * @var bool
     */
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
     * @return \DateTime
     */
    public function getMessageDate(): \DateTime { return $this->messageDate; }

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