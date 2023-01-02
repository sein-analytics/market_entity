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
use Doctrine\ORM\PersistentCollection;

/**
 * \Doctrine\ORM\Mapping\Entity(repositoryClass="\App\Repository\MessageType")
 * \Doctrine\ORM\Mapping\Table(name="MessageType")
 */
class MessageType extends AnnotationMappings
{
    /**
     * \Doctrine\ORM\Mapping\Id
     * \Doctrine\ORM\Mapping\Column(type="integer")
     * \Doctrine\ORM\Mapping\GeneratedValue
     **/
    protected int $id;

    /**
     * \Doctrine\ORM\Mapping\Column(type="string", nullable=false)
     * @var string
     **/
    protected string $type='';

    /**
     * @ORM\OneToMany(targetEntity="\App\Entity\Message", mappedBy="type")
     * @var PersistentCollection|ArrayCollection|null
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
     * @return int
     */
    public function getId():int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getType():string
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
     * @return PersistentCollection|ArrayCollection|null
     */
    public function getMessages():PersistentCollection|ArrayCollection|null
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