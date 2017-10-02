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
    const TEXT_STRING = 'Text';
    const CHAT_STRING = 'Chat';

    protected static $messageTypes = array(
        self::CHAT_STRING      => 0,
        self::TEXT_STRING      => 1
    );

    /**
     * @ORM\Id @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     **/
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\MarketUser", inversedBy="messages")
     * @var MarketUser
     **/
    protected $user;

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
     * @ORM\ManyToOne(targetEntity="\App\Entity\Message")
     * @var ArrayCollection
     */
    protected $responses;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\MessageType", inversedBy="messages")
     * @var int
     */
    protected $type;

    /**
     * @ORM\Column(type="integer", nullable=false)
     * @var string
     */
    protected $message;

    public function __construct()
    {
        $this->type = self::$messageTypes[self::TEXT_STRING];
    }

    /**
     * @return array
     */
    public static function getMessageTypes()
    {
        return self::$messageTypes;
    }

    /**
     * @param array $messageTypes
     */
    public static function setMessageTypes($messageTypes)
    {
        self::$messageTypes = $messageTypes;
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
     * @return mixed
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

}