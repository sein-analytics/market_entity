<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 * Date: 10/3/17
 * Time: 3:04 PM
 */

namespace App\Entity;

use App\Service\CreatePropertiesArrayTrait;
use Doctrine\Common\Collections\ArrayCollection;
//use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\PersistentCollection;

/**
 * \Doctrine\ORM\Mapping\Entity(repositoryClass="\App\Repository\MessageOriginator")
 * \Doctrine\ORM\Mapping\Table(name="MessageOriginator")
 */
class MessageOriginator extends AnnotationMappings
{
    use CreatePropertiesArrayTrait;

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
    protected string $originator;

    /**
     * \Doctrine\ORM\Mapping\OneToMany(targetEntity="\App\Entity\Message", mappedBy="originator")
     * @var PersistentCollection|ArrayCollection|null
     */
    protected $messages;

    function __construct()
    {
    }

    public function addMessage(Message $message)
    {
        $this->messages->add($message);
    }

    /**
     * @return int
     */
    public function getId() :int { return $this->id; }

    /**
     * @return string
     */
    public function getOriginator():string { return $this->originator; }

    /**
     * @return PersistentCollection|ArrayCollection|null
     */
    public function getMessages() :PersistentCollection|ArrayCollection|null
    { return $this->messages; }

}