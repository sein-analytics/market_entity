<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 * Date: 1/19/18
 * Time: 8:43 AM
 */

namespace App\Entity;

//use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\PersistentCollection;

/**
 * \Doctrine\ORM\Mapping\Entity(repositoryClass="\App\Repository\MessagePriority")
 * \Doctrine\ORM\Mapping\Table(name="MessagePriority")
 *
 */
class MessagePriority extends AnnotationMappings
{
    /**
     * \Doctrine\ORM\Mapping\Id
     * \Doctrine\ORM\Mapping\Column(type="integer")
     * \Doctrine\ORM\Mapping\GeneratedValue
     **/
    protected int $id;

    /**
     * \Doctrine\ORM\Mapping\Column(type="string", nullable=false)
     * @var string
     *   */
    protected string $messagePriority;

    /**
     * \Doctrine\ORM\Mapping\OneToMany(targetEntity="\App\Entity\Message", mappedBy="priority")
     * @var PersistentCollection|ArrayCollection|null
     */
    protected $messages;

    /**
     * \Doctrine\ORM\Mapping\OneToMany(targetEntity="\App\Entity\DueDiligenceIssue", mappedBy="priority")
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