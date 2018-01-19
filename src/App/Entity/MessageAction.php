<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 * Date: 1/19/18
 * Time: 8:44 AM
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\PersistentCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="MessageAction")
 *
 */
class MessageAction
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
    protected $messageAction;

    /**
     * @ORM\OneToMany(targetEntity="\App\Entity\Message", mappedBy="action")
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
    public function getMessageAction(): string { return $this->messageAction; }

    /**
     * @return PersistentCollection
     */
    public function getMessages() :PersistentCollection { return $this->messages; }

}