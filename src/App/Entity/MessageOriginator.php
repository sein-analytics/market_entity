<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 * Date: 10/3/17
 * Time: 3:04 PM
 */

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 * @ORM\Table(name="BidStatus")
 */
class MessageOriginator
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     **/
    protected $id;

    /**
     * @ORM\Column(type="string", nullable=false)
     * @var string
     *   */
    protected $originator;

    /**
     * @ORM\OneToMany(targetEntity="\App\Entity\Message, mappedBy="originator")
     * @var ArrayCollection
     */
    protected $messages;

    function __construct()
    {
        $this->messages = new ArrayCollection();
    }

    public function addMessage(Message $message)
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
    public function getOriginator()
    {
        return $this->originator;
    }

    /**
     * @return mixed
     */
    public function getMessages()
    {
        return $this->messages;
    }

}