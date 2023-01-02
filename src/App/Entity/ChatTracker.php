<?php


namespace App\Entity;

//use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\PersistentCollection;

/**
 * \Doctrine\ORM\Mapping\Entity(repositoryClass="\App\Repository\ChatTracker")
 * \Doctrine\ORM\Mapping\Table(name="ChatTracker")
 */
class ChatTracker extends AnnotationMappings
{
    /**
     * \Doctrine\ORM\Mapping\Id
     * \Doctrine\ORM\Mapping\GeneratedValue(strategy="AUTO")
     * \Doctrine\ORM\Mapping\Column(name="id", type="integer")
     * @var int
     **/
    protected int $id;

    /**
     * \Doctrine\ORM\Mapping\Column(type="string", unique=true)
     * @var string
     */
    protected string $uuid;

    /**
     * \Doctrine\ORM\Mapping\OneToOne (targetEntity="\App\Entity\GroupChat", mappedBy="tracker")
     * @var GroupChat|null
     */
    protected $group;

    /**
     * \Doctrine\ORM\Mapping\OneToMany (targetEntity="\App\Entity\Chat", mappedBy="tracker")
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