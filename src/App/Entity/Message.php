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
     * @ORM\OneToMany(targetEntity="\App\Entity\Message")
     * @var ArrayCollection
     */
    protected $responses;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\MessageType", inversedBy="messages")
     * @var MessageType
     */
    protected $type;

    /**
     * @ORM\Column(type="string", nullable=false)
     * @var string
     */
    protected $message;

    public function __construct()
    {
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



}