<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 * Date: 1/19/18
 * Time: 8:43 AM
 */

namespace App\Entity;

use \App\Entity\Message;
use \App\Entity\DueDiligenceIssue;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\PersistentCollection;

#[ORM\Table(name: 'MessagePriority')]
#[ORM\Entity(repositoryClass: \App\Repository\MessagePriority::class)]
class MessagePriority 
{
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    protected int $id;

    /**
     * @var string
     *   */
    #[ORM\Column(type: 'string', nullable: false)]
    protected string $messagePriority;

    /**
     * @var PersistentCollection|ArrayCollection|null
     */
    #[ORM\OneToMany(targetEntity: Message::class, mappedBy: 'priority')]
    protected $messages;

    /**
     * @var PersistentCollection|ArrayCollection|null
     */
    #[ORM\OneToMany(targetEntity: DueDiligenceIssue::class, mappedBy: 'priority')]
    protected $issues;

    /**
     * @return int
     */
    public function getId() : int { return $this->id; }

    /**
     * @return string
     */
    public function getMessagePriority(): string { return $this->messagePriority; }

    /**
     * @return PersistentCollection|ArrayCollection|null
     */
    public function getMessages() :PersistentCollection|ArrayCollection|null
    { return $this->messages; }

    /**
     * @return PersistentCollection|ArrayCollection|null
     */
    public function getIssues() :PersistentCollection|ArrayCollection|null
    { return $this->issues; }

}