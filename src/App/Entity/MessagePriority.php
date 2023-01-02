<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 * Date: 1/19/18
 * Time: 8:43 AM
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\PersistentCollection;

/**
 * @ORM\Entity(repositoryClass="\App\Repository\MessagePriority")
 * @ORM\Table(name="MessagePriority")
 *
 */
class MessagePriority 
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
    protected string $messagePriority;

    /**
     * @ORM\OneToMany(targetEntity="\App\Entity\Message", mappedBy="priority")
     * @var PersistentCollection|ArrayCollection|null
     */
    protected $messages;

    /**
     * @ORM\OneToMany(targetEntity="\App\Entity\DueDiligenceIssue", mappedBy="priority")
     * @var PersistentCollection|ArrayCollection|null
     */
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