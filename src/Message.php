<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\ChangeTrackingPolicy;

/**
 * @ORM\Entity(repositoryClass="\Repository\Message")
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
     * @ORM\Column(type="integer", nullable=false)
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
     * @param mixed $type
     */
    public function setType($type)
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


}