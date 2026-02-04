<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 * Date: 1/19/18
 * Time: 8:44 AM
 */

namespace App\Entity;

use \App\Entity\Message;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\PersistentCollection;

#[ORM\Table(name: 'MessageAction')]
#[ORM\Entity(repositoryClass: \App\Repository\MessageAction::class)]
class MessageAction 
{
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    protected int $id;

    /**
     * @var string
     */
    #[ORM\Column(type: 'string', nullable: false)]
    protected string $urlText;

    /**
     * @var string
     */
    #[ORM\Column(type: 'string', nullable: false)]
    protected string $documentUrl;

    /**
     * @var string
     */
    #[ORM\Column(type: 'string', nullable: false)]
    protected string $icon;

    /**
     * @var PersistentCollection|ArrayCollection|null
     */
    #[ORM\OneToMany(targetEntity: Message::class, mappedBy: 'action')]
    protected $messages;

    /**
     * @return int
     */
    public function getId() : int { return $this->id; }

    /**
     * @return string
     */
    public function getUrlText(): string { return $this->urlText; }

    /**
     * @return PersistentCollection|ArrayCollection|null
     */
    public function getMessages() :PersistentCollection|ArrayCollection|null
    { return $this->messages; }

    /**
     * @return string
     */
    public function getDocumentUrl(): string { return $this->documentUrl; }

    /**
     * @return string
     */
    public function getIcon(): string { return $this->icon; }

}