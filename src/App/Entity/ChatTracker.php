<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\PersistentCollection;

/**
 * @ORM\Entity(repositoryClass="\App\Repository\ChatTracker")
 * @ORM\Table(name="ChatTracker")
 */
class ChatTracker
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(name="id", type="integer")
     * @var int
     **/
    protected int $id;

    /**
     * @ORM\Column(type="string", unique=true)
     * @var string
     */
    protected string $uuid;

    /**
     * @ORM\OneToOne (targetEntity="\App\Entity\GroupChat", mappedBy="tracker")
     * @var GroupChat|null
     */
    protected $group;

    /**
     * @ORM\OneToMany (targetEntity="\App\Entity\Chat", mappedBy="tracker")
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