<?php

namespace App\Entity;

//use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\PersistentCollection;
/**
 * \Doctrine\ORM\Mapping\Entity
 * \Doctrine\ORM\Mapping\Table(name="ChatStatus")
 */
class ChatStatus extends AnnotationMappings
{
    /**
     * \Doctrine\ORM\Mapping\Id
     * \Doctrine\ORM\Mapping\Column(type="integer")
     * \Doctrine\ORM\Mapping\GeneratedValue(strategy="AUTO")
     * @var int
     **/
    protected int $id;

    /**
     * \Doctrine\ORM\Mapping\GeneratedValue(strategy="UUID")
     * \Doctrine\ORM\Mapping\Column(type="string", unique=true)
     * @var string
     */
    protected string $status;

    /**
     * \Doctrine\ORM\Mapping\OneToMany (targetEntity="\App\Entity\Chat", mappedBy="status")
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