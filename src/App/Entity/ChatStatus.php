<?php

namespace App\Entity;

use \App\Entity\Chat;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\PersistentCollection;
#[ORM\Table(name: 'ChatStatus')]
#[ORM\Entity]
class ChatStatus
{
    /**
     * @var int
     **/
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    protected int $id;

    /**
     * @var string
     */
    #[ORM\Column(type: 'string', unique: true)]
    protected string $status;

    /**
     * @var PersistentCollection
     */
    #[ORM\OneToMany(targetEntity: Chat::class, mappedBy: 'status')]
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