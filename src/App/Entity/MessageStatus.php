<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 * Date: 1/18/18
 * Time: 3:32 PM
 */

namespace App\Entity;


use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\PersistentCollection;

/**
 * @ORM\Entity(repositoryClass="\App\Repository\MessageStatus")
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
    protected int $id;

    /**
     * @ORM\Column(type="string", nullable=false)
     * @var string
     *   */
    protected string $messageStatus;

    /**
     * @ORM\OneToMany(targetEntity="\App\Entity\Message", mappedBy="status")
     * @var PersistentCollection|ArrayCollection|null
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
     * @return PersistentCollection|ArrayCollection|null
     */
    public function getMessages() :PersistentCollection|ArrayCollection|null { return $this->messages; }


}