<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
/**
 * @ORM\Entity
 * @ORM\Table(name="Chat")
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
     * @ORM\Column(type="uuid", unique=true)
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
     * @ORM\ManyToOne(targetEntity="\App\Entity\Chat", inversedBy="group")
     * @var ArrayCollection
     */
    protected $chats;


}