<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 */

namespace App\Entity;

use App\Service\CreatePropertiesArrayTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\PersistentCollection;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\OneToOne;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\ManyToMany;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\JoinColumns;
use Doctrine\ORM\Mapping\JoinTable;
use Doctrine\ORM\Mapping\GeneratedValue;

use Doctrine\ORM\Mapping\DiscriminatorColumn;
use Doctrine\ORM\Mapping\DiscriminatorMap;

use Doctrine\ORM\Mapping\Index;
use Doctrine\ORM\Mapping\ChangeTrackingPolicy;

use Doctrine\ORM\Mapping as ORM;

/**
 * \Doctrine\ORM\Mapping\Entity(repositoryClass="\App\Repository\Message")
 * \Doctrine\ORM\Mapping\Table(name="Message")
 * \Doctrine\ORM\Mapping\ChangeTrackingPolicy("NOTIFY")
 * \Doctrine\ORM\Mapping\HasLifeCycleCallbacks
 */
class Message extends DomainObject
{
    use CreatePropertiesArrayTrait;

    /**
     * \Doctrine\ORM\Mapping\Id
     * \Doctrine\ORM\Mapping\Column(type="integer")
     * \Doctrine\ORM\Mapping\GeneratedValue
     **/
    protected int $id;

    /**
     * \Doctrine\ORM\Mapping\ManyToOne(targetEntity="\App\Entity\MarketUser", inversedBy="messages")
     * \Doctrine\ORM\Mapping\JoinColumn(name="user_id", referencedColumnName="id", nullable=false)
     **/
    protected MarketUser $user;

    /**
     * \Doctrine\ORM\Mapping\ManyToOne(targetEntity="\App\Entity\Deal", inversedBy="messages")
     * \Doctrine\ORM\Mapping\JoinColumn(name="deal_id", referencedColumnName="id", nullable=true)
     */
    protected ?Deal $deal;

    /**
     * \Doctrine\ORM\Mapping\ManyToOne(targetEntity="\App\Entity\Loan", inversedBy="issues")
     * \Doctrine\ORM\Mapping\JoinColumn(name="loan_id", referencedColumnName="id", nullable=true)
     */
    protected ?Loan $loan;

    /**
     * \Doctrine\ORM\Mapping\Column(type="datetime", nullable=false)
     */
    protected \DateTime $date;

    /**
     * \Doctrine\ORM\Mapping\Column(type="string", nullable=true)
     * @var ?string
     */
    protected ?string $subject;

    /**
     * \Doctrine\ORM\Mapping\ManyToMany(targetEntity="\App\Entity\Message")
     * \Doctrine\ORM\Mapping\JoinTable(name="responses",
     *     joinColumns={\Doctrine\ORM\Mapping\JoinColumn(name="message_id", referencedColumnName="id")},
     *     inverseJoinColumns={\Doctrine\ORM\Mapping\JoinColumn(name="response_id", referencedColumnName="id")}
     *     )
     */
    protected ArrayCollection|PersistentCollection|null $responses;

    /**
     * \Doctrine\ORM\Mapping\ManyToOne(targetEntity="\App\Entity\MessageType", inversedBy="messages")
     * \Doctrine\ORM\Mapping\JoinColumn(name="type_id", referencedColumnName="id", nullable=false)
     */
    protected MessageType $type;

    /**
     * \Doctrine\ORM\Mapping\ManyToMany(targetEntity="\App\Entity\MarketUser", inversedBy="receivedMessages")
     * @var PersistentCollection|ArrayCollection|null
     */
    protected $recipients;

    /**
     * \Doctrine\ORM\Mapping\Column(type="text", nullable=false)
     */
    protected string $message='';

    /**
     * \Doctrine\ORM\Mapping\ManyToOne(targetEntity="\App\Entity\MessageOriginator", inversedBy="messages")
     * \Doctrine\ORM\Mapping\JoinColumn(name="originator_id", referencedColumnName="id", nullable=false)
     */
    protected MessageOriginator $originator;

    /**
     * \Doctrine\ORM\Mapping\ManyToOne(targetEntity="\App\Entity\MessageStatus", inversedBy="messages")
     * \Doctrine\ORM\Mapping\JoinColumn(name="status_id", referencedColumnName="id", nullable=true)
     */
    protected ?MessageStatus $status;

    /**
     * \Doctrine\ORM\Mapping\ManyToOne(targetEntity="\App\Entity\MessagePriority", inversedBy="messages")
     * \Doctrine\ORM\Mapping\JoinColumn(name="priority_id", referencedColumnName="id", nullable=true)
     */
    protected ?MessagePriority $priority;

    /**
     * \Doctrine\ORM\Mapping\ManyToOne(targetEntity="\App\Entity\MessageAction", inversedBy="messages")
     * \Doctrine\ORM\Mapping\JoinColumn(name="action_id", referencedColumnName="id", nullable=true)
     */
    protected ?MessageAction $action;

    /**
     * \Doctrine\ORM\Mapping\Column(type="string", nullable=true)
     */
    protected ?string $sendStatus;

    /**
     * \Doctrine\ORM\Mapping\Column(type="json", nullable=true)
     */
    protected array|string $msgRecipientIds;

    /**
     * \Doctrine\ORM\Mapping\ManyToOne(targetEntity="\App\Entity\DueDiligenceIssue", inversedBy="messages")
     * \Doctrine\ORM\Mapping\JoinColumn(name="issue_id", referencedColumnName="id", nullable=true)
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