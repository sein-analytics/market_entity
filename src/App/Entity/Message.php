<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 */

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\ChangeTrackingPolicy;

/**
 * @ORM\Entity
 * @ORM\Table(name="Message")
 * @ChangeTrackingPolicy("NOTIFY")
 * @ORM\HasLifeCycleCallbacks
 */
class Message
{
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
     * @var ArrayCollection
     */
    protected $responses;

    /**
     * @ORM\ManyToMany(targetEntity="\App\Entity\Message")
     * @ORM\JoinTable(name="market_responses",
     *     joinColumns={@ORM\JoinColumn(name="message_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="response_id", referencedColumnName="id")}
     *     )
     * @var ArrayCollection
     */
    protected $marketResponses;

    /**
     * @ORM\ManyToMany(targetEntity="\App\Entity\MarketUser", inversedBy="receivedMessages")
     * @var ArrayCollection
     */
    protected $recipients;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\MessageType", inversedBy="messages")
     * @ORM\JoinColumn(name="type_id", referencedColumnName="id", nullable=false)
     * @var MessageType
     */
    protected $type;

    /**
     * @ORM\Column(type="string", nullable=false)
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
     * @ORM\ManyToOne(targetEntity="\App\Entity\DueDiligence", inversedBy="messages")
     */
    protected $dueDiligence;

    public function __construct()
    {
        $this->responses = new ArrayCollection();
        $this->marketResponses = new ArrayCollection();
        $this->recipients = new ArrayCollection();
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
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param MarketUser $user
     */
    public function setUser(MarketUser $user)
    {
        $this->user = $user;
    }

    /**
     * @return MessageType
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param MessageType $type
     */
    public function setType(MessageType $type)
    {
        $this->type = $type;
    }

    /**
     * @return mixed
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param mixed $message
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }

    /**
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param mixed $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * @return string
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * @param string $subject
     */
    public function setSubject(string $subject)
    {
        $this->subject = $subject;
    }

    /**
     * @return ArrayCollection
     */
    public function getResponses()
    {
        return $this->responses;
    }

    /**
     * @param ArrayCollection $responses
     */
    public function setResponses(ArrayCollection $responses)
    {
        $this->responses = $responses;
    }

    /**
     * @return Deal
     */
    public function getDeal()
    {
        return $this->deal;
    }

    /**
     * @param mixed $deal
     */
    public function setDeal(Deal $deal)
    {
        $this->deal = $deal;
    }

    /**
     * @return Loan
     */
    public function getLoan()
    {
        return $this->loan;
    }

    /**
     * @param mixed $loan
     */
    public function setLoan(Loan $loan)
    {
        $this->loan = $loan;
    }

    /**
     * @return MessageOriginator
     */
    public function getOriginator()
    {
        return $this->originator;
    }

    /**
     * @param MessageOriginator $originator
     */
    public function setOriginator(MessageOriginator $originator)
    {
        $this->originator = $originator;
    }

    /**
     * @return DueDiligence
     */
    public function getDueDiligence()
    {
        return $this->dueDiligence;
    }

    /**
     * @param DueDiligence $dueDiligence
     */
    public function setDueDiligence(DueDiligence $dueDiligence)
    {
        $this->dueDiligence = $dueDiligence;
    }

    /**
     * @return ArrayCollection
     */
    public function getRecipients(): ArrayCollection
    {
        return $this->recipients;
    }


}