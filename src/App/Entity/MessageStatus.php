<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 * Date: 1/18/18
 * Time: 3:32 PM
 */

namespace App\Entity;


use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\PersistentCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="MessageStatus")
 *
 */
class MessageStatus
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
    protected $messageStatus;

    /**
     * @ORM\OneToMany(targetEntity="\App\Entity\Message", mappedBy="status")
     * @var PersistentCollection
     */
    protected $messages;

    /**
     * @return int
     */
    public function getId() : int { return $this->id; }

    /**
     * @return string
     */
    public function getMessageStatus(): string { return $this->messageStatus; }

    /**
     * @return PersistentCollection
     */
    public function getMessages() :PersistentCollection { return $this->messages; }


}