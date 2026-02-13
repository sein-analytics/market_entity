<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 * Date: 1/18/18
 * Time: 3:32 PM
 */

namespace App\Entity;


use \App\Entity\Message;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\PersistentCollection;

#[ORM\Table(name: 'MessageStatus')]
#[ORM\Entity(repositoryClass: \App\Repository\MessageStatus::class)]
class MessageStatus
{
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    protected int $id;

    /**
     * @var string
     *   */
    #[ORM\Column(type: 'string', nullable: false)]
    protected string $messageStatus;

    /**
     * @var PersistentCollection|ArrayCollection|null
     */
    #[ORM\OneToMany(targetEntity: Message::class, mappedBy: 'status')]
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