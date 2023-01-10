<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 */

namespace App\Entity;

use App\Service\CreatePropertiesArrayTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\PersistentCollection;
use Doctrine\ORM\Mapping\ChangeTrackingPolicy;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="\App\Repository\Message")
 * @ORM\Table(name="Message")
 * @ORM\ChangeTrackingPolicy("NOTIFY")
 * @ORM\HasLifeCycleCallbacks()
 */
class Message extends DomainObject
{
    use CreatePropertiesArrayTrait;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     **/
    protected int $id;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\MarketUser", inversedBy="messages")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false)
     **/
    protected MarketUser $user;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\Deal", inversedBy="messages")
     * @ORM\JoinColumn(name="deal_id", referencedColumnName="id", nullable=true)
     */
    protected ?Deal $deal;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\Loan", inversedBy="issues")
     * @ORM\JoinColumn(name="loan_id", referencedColumnName="id", nullable=true)
     */
    protected ?Loan $loan;

    /**
     * @ORM\Column(type="datetime", nullable=false)
     */
    protected \DateTime $date;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var ?string
     */
    protected ?string $subject;

    /**
     * @ORM\ManyToMany(targetEntity="\App\Entity\Message")
     * @ORM\JoinTable(name="responses",
     *     joinColumns={@ORM\JoinColumn(name="message_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="response_id", referencedColumnName="id")}
     *     )
     */
    protected ArrayCollection|PersistentCollection|null $responses;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\MessageType", inversedBy="messages")
     * @ORM\JoinColumn(name="type_id", referencedColumnName="id", nullable=false)
     */
    protected MessageType $type;

    /**
     * @ORM\ManyToMany(targetEntity="\App\Entity\MarketUser", inversedBy="receivedMessages")
     * @var PersistentCollection|ArrayCollection|null
     */
    protected $recipients;

    /**
     * @ORM\Column(type="text", nullable=false)
     */
    protected string $message='';

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\MessageOriginator", inversedBy="messages")
     * @ORM\JoinColumn(name="originator_id", referencedColumnName="id", nullable=false)
     */
    protected MessageOriginator $originator;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\MessageStatus", inversedBy="messages")
     * @ORM\JoinColumn(name="status_id", referencedColumnName="id", nullable=true)
     */
    protected ?MessageStatus $status;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\MessagePriority", inversedBy="messages")
     * @ORM\JoinColumn(name="priority_id", referencedColumnName="id", nullable=true)
     */
    protected ?MessagePriority $priority;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\MessageAction", inversedBy="messages")
     * @ORM\JoinColumn(name="action_id", referencedColumnName="id", nullable=true)
     */
    protected ?MessageAction $action;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected ?string $sendStatus;

    /**
     * @ORM\Column(type="json", nullable=true)
     */
    protected array|string $msgRecipientIds;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\DueDiligenceIssue", inversedBy="messages")
     * @ORM\JoinColumn(name="issue_id", referencedColumnName="id", nullable=true)
     */
    protected $issue;

    public function __construct()
    {
        $this->responses = new ArrayCollection();
        $this->recipients = new ArrayCollection();
        parent::__construct();
    }

    public function addRecipient(MarketUser $user)
    {
        $this->recipients->add($user);
    }

    public function addResponse(Message $message)
    {
        $this->responses->add($message);
    }

    /**
     * @return int
     */
    public function getId():int
    {
        return $this->id;
    }

    /**
     * @return MarketUser
     */
    public function getUser():MarketUser { return $this->user; }

    /**
     * @param MarketUser $user
     */
    public function setUser(MarketUser $user):void
    {
        $this->implementChange($this,'user', $this->user, $user);
    }

    /**
     * @return MessageType
     */
    public function getType() : MessageType { return $this->type; }

    /**
     * @param MessageType $type
     */
    public function setType(MessageType $type)
    {
        $this->implementChange($this,'type', $this->type, $type);
    }

    /**
     * @return mixed
     */
    public function getMessage() : string { return $this->message; }

    /**
     * @param mixed $message
     */
    public function setMessage(string $message):void
    {
        $this->implementChange($this,'message', $this->message, $message);
    }

    /**
     * @return \DateTime
     */
    public function getDate():\DateTime { return $this->date; }

    /**
     * @param mixed $date
     */
    public function setDate(\DateTime $date):void
    {
        $this->implementChange($this,'date', $this->date, $date);
    }

    /**
     * @return ?string
     */
    public function getSubject() :?string { return $this->subject; }

    /**
     * @param string $subject
     */
    public function setSubject(string $subject):void
    {
        $this->implementChange($this,'subject', $this->subject, $subject);
    }

    /**
     * @return ArrayCollection|PersistentCollection|null
     */
    public function getResponses() : ArrayCollection|PersistentCollection|null { return $this->responses; }

    /**
     * @return ?Deal
     */
    public function getDeal():?Deal  { return $this->deal; }

    /**
     * @param mixed $deal
     */
    public function setDeal(Deal $deal):void
    {
        $this->implementChange($this,'deal', $this->deal, $deal);
    }

    /**
     * @return ?Loan
     */
    public function getLoan():?Loan { return $this->loan; }

    /**
     * @param mixed $loan
     */
    public function setLoan(Loan $loan):void
    {
        $this->implementChange($this,'loan', $this->loan, $loan);
    }

    /**
     * @return MessageOriginator
     */
    public function getOriginator() : MessageOriginator { return $this->originator; }

    /**
     * @param MessageOriginator $originator
     */
    public function setOriginator(MessageOriginator $originator)
    {
        $this->implementChange($this,'originator', $this->originator, $originator);
    }

    /**
     * @return DueDiligenceIssue|null
     */
    public function getIssue():?DueDiligenceIssue { return $this->issue; }

    /**
     * @param DueDiligenceIssue $issue
     */
    public function setIssue(DueDiligenceIssue $issue)
    {
        $this->implementChange($this,'issue', $this->issue, $issue);
    }

    /**
     * @return PersistentCollection|ArrayCollection|null
     */
    public function getRecipients() : PersistentCollection|ArrayCollection|null
    { return $this->recipients; }

    /**
     * @return MessageStatus
     */
    public function getStatus(): MessageStatus { return $this->status; }

    /**
     * @param MessageStatus $status
     */
    public function setStatus(MessageStatus $status)
    {
        $this->implementChange($this,'status', $this->status, $status);
    }

    /**
     * @return MessagePriority
     */
    public function getPriority(): MessagePriority { return $this->priority; }

    /**
     * @param MessagePriority $priority
     */
    public function setPriority(MessagePriority $priority)
    {
        $this->implementChange($this,'priority', $this->priority, $priority);
    }

    /**
     * @return MessageAction
     */
    public function getAction(): MessageAction { return $this->action; }

    /**
     * @param MessageAction $action
     */
    public function setAction(MessageAction $action)
    {
        $this->implementChange($this,'action', $this->action, $action);
    }

    /**
     * @return string
     */
    public function getSendStatus(): string { return $this->sendStatus; }

    /**
     * @param string $sendStatus
     */
    public function setSendStatus(string $sendStatus)
    {
        $this->implementChange($this,'sendStatus', $this->sendStatus, $sendStatus);
    }


}