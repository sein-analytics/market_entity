<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 */

namespace App\Entity;

use App\Service\CreatePropertiesArrayTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\NotifyPropertyChanged;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\ChangeTrackingPolicy;
use Doctrine\ORM\PersistentCollection;

/**
 * @ORM\Entity(repositoryClass="\App\Repository\Message")
 * @ORM\Table(name="Message")
 * @ChangeTrackingPolicy("NOTIFY")
 * @ORM\HasLifeCycleCallbacks
 */
class Message extends DomainObject
{
    use CreatePropertiesArrayTrait;

    /**
     * @ORM\Id @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     **/
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\MarketUser", inversedBy="messages")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false)
     * @var MarketUser
     **/
    protected $user;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\Deal", inversedBy="messages")
     * @ORM\JoinColumn(name="deal_id", referencedColumnName="id", nullable=true)
     * @var Deal
     */
    protected $deal;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\Loan", inversedBy="issues")
     * @ORM\JoinColumn(name="loan_id", referencedColumnName="id", nullable=true)
     * @var Loan
     */
    protected $loan;

    /**
     * @ORM\Column(type="datetime", nullable=false)
     * @var \DateTime
     */
    protected $date;

    /**
     * @ORM\Column(type="string", nullable=false)
     * @var string
     */
    protected $subject;

    /**
     * @ORM\ManyToMany(targetEntity="\App\Entity\Message")
     * @ORM\JoinTable(name="responses",
     *     joinColumns={@ORM\JoinColumn(name="message_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="response_id", referencedColumnName="id")}
     *     )
     * @var PersistentCollection|null
     */
    protected $responses;

    /**
     * @ORM\ManyToMany(targetEntity="\App\Entity\MarketUser", inversedBy="receivedMessages")
     * @var PersistentCollection
     */
    protected $recipients;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\MessageType", inversedBy="messages")
     * @ORM\JoinColumn(name="type_id", referencedColumnName="id", nullable=false)
     * @var MessageType
     */
    protected $type;

    /**
     * @ORM\Column(type="text", nullable=false)
     * @var string
     */
    protected $message;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\MessageOriginator", inversedBy="messages")
     * @ORM\JoinColumn(name="originator_id", referencedColumnName="id", nullable=false)
     * @var MessageOriginator
     */
    protected $originator;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\MessageStatus", inversedBy="messages")
     * @ORM\JoinColumn(name="status_id", referencedColumnName="id", nullable=true)
     * @var MessageStatus
     */
    protected $status;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\MessagePriority", inversedBy="messages")
     * @ORM\JoinColumn(name="priority_id", referencedColumnName="id", nullable=true)
     * @var MessagePriority
     */
    protected $priority;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\MessageAction", inversedBy="messages")
     * @ORM\JoinColumn(name="action_id", referencedColumnName="id", nullable=true)
     * @var MessageAction
     */
    protected $action;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var string
     */
    protected $sendStatus;

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
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return MarketUser
     */
    public function getUser(){ return $this->user; }

    /**
     * @param MarketUser $user
     */
    public function setUser(MarketUser $user)
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
    public function setMessage(string $message)
    {
        $this->implementChange($this,'message', $this->message, $message);
    }

    /**
     * @return \DateTime
     */
    public function getDate() { return $this->date; }

    /**
     * @param mixed $date
     */
    public function setDate(\DateTime $date)
    {
        $this->implementChange($this,'date', $this->date, $date);
    }

    /**
     * @return string
     */
    public function getSubject() :string { return $this->subject; }

    /**
     * @param string $subject
     */
    public function setSubject(string $subject)
    {
        $this->implementChange($this,'subject', $this->subject, $subject);
    }

    /**
     * @return PersistentCollection|null
     */
    public function getResponses() : ?PersistentCollection { return $this->responses; }

    /**
     * @return Deal
     */
    public function getDeal()  { return $this->deal; }

    /**
     * @param mixed $deal
     */
    public function setDeal(Deal $deal)
    {
        $this->implementChange($this,'deal', $this->deal, $deal);
    }

    /**
     * @return Loan
     */
    public function getLoan() { return $this->loan; }

    /**
     * @param mixed $loan
     */
    public function setLoan(Loan $loan)
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
    public function getIssue() { return $this->issue; }

    /**
     * @param DueDiligenceIssue $issue
     */
    public function setIssue(DueDiligenceIssue $issue)
    {
        $this->implementChange($this,'issue', $this->issue, $issue);
    }

    /**
     * @return PersistentCollection
     */
    public function getRecipients() : PersistentCollection { return $this->recipients; }

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