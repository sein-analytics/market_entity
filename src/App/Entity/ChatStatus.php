<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\PersistentCollection;
/**
 * @ORM\Entity
 * @ORM\Table(name="ChatStatus")
 */
class ChatStatus
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @var int
     **/
    protected int $id;

    /**
     * @ORM\GeneratedValue(strategy="UUID")
     * @ORM\Column(type="string", unique=true)
     * @var string
     */
    protected string $status;

    /**
     * @ORM\OneToMany (targetEntity="\App\Entity\Chat", mappedBy="status")
     * @var PersistentCollection
     */
    protected $chats;

    /**
     * @return int
     */
    public function getId(): int { return $this->id; }

    /**
     * @return string
     */
    public function getStatus(): string { return $this->status; }

    /**
     * @return PersistentCollection
     */
    public function getChats(): PersistentCollection { return $this->chats; }


}