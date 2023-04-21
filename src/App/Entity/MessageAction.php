<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 * Date: 1/19/18
 * Time: 8:44 AM
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\PersistentCollection;

/**
 * @ORM\Entity(repositoryClass="\App\Repository\MessageAction")
 * @ORM\Table(name="MessageAction")
 *
 */
class MessageAction 
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
     */
    protected string $urlText;

    /**
     * @ORM\Column(type="string", nullable=false)
     * @var string
     */
    protected string $documentUrl;

    /**
     * @ORM\Column(type="string", nullable=false)
     * @var string
     */
    protected string $icon;

    /**
     * @ORM\OneToMany(targetEntity="\App\Entity\Message", mappedBy="action")
     * @var PersistentCollection|ArrayCollection|null
     */
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