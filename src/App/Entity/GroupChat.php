<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
/**
 * @ORM\Entity
 * @ORM\Table(name="ChatGroup")
 */
class GroupChat
{
    /**
     * @ORM\Id @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     **/
    protected $id;

    /**
     * @ORM\GeneratedValue(strategy="UUID")
     * @ORM\Column(type="string", unique=true)
     *
     */
    protected $uuid;

    /**
     * @ORM\Column(type="string", nullable=false)
     * @var string
     */
    protected $groupName;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\MarketUser", inversedBy="groupChats")
     * @var MarketUser
     */
    protected $user;

    /**
     * @ORM\Column(type="boolean", nullable=false, options={"default":"0"})
     * @var bool
     */
    protected $isPrivate;

    /**
     * @ORM\OneToMany(targetEntity="\App\Entity\Chat", mappedBy="group")
     * @var ArrayCollection
     */
    protected $chats;


}