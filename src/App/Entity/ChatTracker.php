<?php


namespace App\Entity;

use \App\Entity\Chat;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\PersistentCollection;

#[ORM\Table(name: 'ChatTracker')]
#[ORM\Entity(repositoryClass: \App\Repository\ChatTracker::class)]
class ChatTracker
{
    /**
     * @var int
     **/
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    #[ORM\Column(name: 'id', type: 'integer')]
    protected int $id;

    /**
     * @var string
     */
    #[ORM\Column(type: 'string', unique: true)]
    protected string $uuid;

    /**
     * @var GroupChat|null
     */
    #[ORM\OneToOne(targetEntity:  \App\Entity\GroupChat::class, mappedBy: 'tracker')]
    protected $group;

    /**
     * @var PersistentCollection
     */
    #[ORM\OneToMany(targetEntity: Chat::class, mappedBy: 'tracker')]
    protected $chats;

    /**
     * @return int
     */
    public function getId(): int { return $this->id; }

    /**
     * @return string
     */
    public function getUuid(): string { return $this->uuid; }

    /**
     * @return GroupChat|null
     */
    public function getGroup(): ?GroupChat { return $this->group; }

    /**
     * @return PersistentCollection
     */
    public function getChats(): PersistentCollection { return $this->chats; }

}