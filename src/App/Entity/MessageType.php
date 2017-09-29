<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 * Date: 9/29/17
 * Time: 12:34 PM
 */

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="MessageType")
 */
class MessageType
{
    /**
     * @ORM\Id @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     **/
    protected $id;

    /**
     * @ORM\Column(type="string", nullable=false)
     * @var string
     **/
    protected $type;

    /**
     * @ORM\OneToMany(targetEntity="\App\Entity\Message", mappedBy=type)
     * @var ArrayCollection
     */
    protected $messages;

    function __construct()
    {
        $this->messages = new ArrayCollection();
    }

    function addMessage(Message $message)
    {
        $this->messages->add($message);
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType(string $type)
    {
        $this->type = $type;
    }

    /**
     * @return ArrayCollection
     */
    public function getMessages()
    {
        return $this->messages;
    }

    /**
     * @param ArrayCollection $messages
     */
    public function setMessages(ArrayCollection $messages)
    {
        $this->messages = $messages;
    }


}