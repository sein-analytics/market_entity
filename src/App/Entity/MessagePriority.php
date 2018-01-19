<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 * Date: 1/19/18
 * Time: 8:43 AM
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\PersistentCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="MessagePriority")
 *
 */
class MessagePriority
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
    protected $messagePriority;

    /**
     * @ORM\OneToMany(targetEntity="\App\Entity\Message", mappedBy="priority")
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
    public function getMessagePriority(): string { return $this->messagePriority; }

    /**
     * @return PersistentCollection
     */
    public function getMessages() :PersistentCollection { return $this->messages; }

}