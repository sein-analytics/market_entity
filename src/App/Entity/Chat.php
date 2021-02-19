<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\PersistentCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="Chat")
 */
class Chat
{
    /**
     * @ORM\Id @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     * @var int
     **/
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\MarketUser", inversedBy="chats")
     * @var MarketUser
     */
    protected $user;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\MarketUser", inversedBy="chatRecipient")
     * @var MarketUser|null
     */
    protected $recipient;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\GroupChat", inversedBy="chats")
     * @var GroupChat|null
     */
    protected $group;

    /**
     * @ORM\Column(type="blob")
     * @var string
     */
    protected $message;

    /**
     * @ORM\Column(type="datetime", nullable=false)
     * @var \DateTime
     **/
    protected $messageDate;

    /**
     * @ORM\Column(type="json", nullable=true)
     * @var array | null
     **/
    protected $attachments;

    /**
     * @ORM\ManyToMany(targetEntity="\App\Entity\Chat")
     * @ORM\JoinTable(name="chat_replies",
     *      joinColumns={@ORM\JoinColumn(name="chat_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="response_id", referencedColumnName="id")}
     *     )
     * @var PersistentCollection|ArrayCollection
     */
    protected $chatReplies;

    public function __construct()
    {
        $this->chatReplies = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getId() { return $this->id; }

    /**
     * @return PersistentCollection|ArrayCollection
     */
    public function getChatReplies()  { return $this->chatReplies; }

    public function addChatReply(Chat $chat){
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


}