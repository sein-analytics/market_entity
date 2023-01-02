<?php


namespace App\Entity;

//use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\PersistentCollection;

/**
 * \Doctrine\ORM\Mapping\Entity(repositoryClass="\App\Repository\Chat")
 * \Doctrine\ORM\Mapping\Table(name="Chat")
 */
class Chat extends AnnotationMappings
{
    /**
     * \Doctrine\ORM\Mapping\Id @ORM\Column(type="integer")
     * \Doctrine\ORM\Mapping\GeneratedValue(strategy="AUTO")
     * @var int
     **/
    protected int $id;

    /**
     * \Doctrine\ORM\Mapping\ManyToOne(targetEntity="\App\Entity\MarketUser", inversedBy="chats")
     * @var MarketUser
     */
    protected $user;

    /**
     * \Doctrine\ORM\Mapping\ManyToOne(targetEntity="\App\Entity\MarketUser", inversedBy="chatRecipient")
     * \Doctrine\ORM\Mapping\JoinColumn(name="recipient_id", referencedColumnName="id", nullable=true)
     * @var MarketUser|null
     */
    protected $recipient;

    /**
     * \Doctrine\ORM\Map\Doctrine\ORM\Mapping\ManyToOne(targetEntity="\App\Entity\MarketUser")
     * \Doctrine\ORM\Map\Doctrine\ORM\Mapping\JoinColumn(name="contact_id", referencedColumnName="id", nullable=true)
     * @var MarketUser
     */
    protected $contact;

    /**
     * \Doctrine\ORM\Mapping\ManyToOne(targetEntity="\App\Entity\GroupChat", inversedBy="chats")
     * \Doctrine\ORM\Mapping\JoinColumn(name="group_id", referencedColumnName="id", nullable=true)
     * @var GroupChat|null
     */
    protected $group;

    /**
     * \Doctrine\ORM\Mapping\Column(type="blob")
     * @var string
     */
    protected string $message;

    /**
     * \Doctrine\ORM\Mapping\Column(type="datetime", nullable=false)
     * @var \DateTime
     **/
    protected $messageDate;

    /**
     * \Doctrine\ORM\Mapping\Column(type="json", nullable=true)
     * @var array | null
     **/
    protected array|null $attachments;

    /**
     * \Doctrine\ORM\Mapping\ManyToMany(targetEntity="\App\Entity\Chat")
     * \Doctrine\ORM\Mapping\JoinTable(name="chat_replies",
     *      joinColumns={\Doctrine\ORM\Mapping\JoinColumn(name="chat_id", referencedColumnName="id")},
     *      inverseJoinColumns={\Doctrine\ORM\Mapping\JoinColumn(name="response_id", referencedColumnName="id")}
     *     )
     * @var PersistentCollection|ArrayCollection
     */
    protected $chatReplies;

    /**
     * \Doctrine\ORM\Mapping\ManyToOne(targetEntity="\App\Entity\ChatTracker", inversedBy="chats")
     * @var ChatTracker
     */
    protected $tracker;

    /**
     * \Doctrine\ORM\Mapping\ManyToOne(targetEntity="\App\Entity\ChatStatus", inversedBy="chats")
     * @var ChatStatus
     */
    protected $status;

    /**
     * \Doctrine\ORM\Mapping\Column(type="boolean", nullable=false, options={"default":"0"})
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