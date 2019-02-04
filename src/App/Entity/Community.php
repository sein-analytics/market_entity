<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 * Date: 12/3/18
 * Time: 11:35 AM
 */

namespace App\Entity;

use \App\Entity\MarketUser;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 * @ORM\Table(name="Community")
 */
class Community
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     * @var int
     **/
    protected $id;

    /**
     * @ORM\ManyToMany(targetEntity="\App\Entity\MarketUser", inversedBy="communities")
     * @ORM\JoinTable(name="user_communities",
     *     joinColumns={@ORM\JoinColumn(name="comm_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")}
     *     )
     */
    protected $users;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\MarketUser", inversedBy="myCommunities")
     * @ORM\JoinColumn(name="owner", referencedColumnName="id", nullable=false)
     * @var MarketUser
     */
    protected $owner;

    /** @ORM\Column(type="string", length=35, unique=true, nullable=false)  */
    protected $name;

    /** @ORM\Column(type="text", nullable=false)  */
    protected $description;

    /** @ORM\Column(type="datetime", nullable=false) **/
    protected $dateCreated;

    /** @ORM\Column(type="datetime", nullable=false, options={"default":"0"}) **/
    protected $isPrimaryGroup;

    // @ORM\Column(type="boolean", options={"default":"0"}

    public function __construct()
    {
        $this->users  = new ArrayCollection();
    }

    public function addUserToCommunity(MarketUser $user){
        $this->users->add($user);
    }

    public function removeUserFromCommunity(MarketUser $user)
    {
        if (! $this->users->contains($user))
            return;
        $this->users->removeElement($user);
        $user->removeCommunity($this);
    }

    /**
     * @return int
     */
    public function getId() { return $this->id; }

    /**
     * @return ArrayCollection
     */
    public function getUsers() { return $this->users; }

    /**
     * @return string
     */
    public function getName() { return $this->name; }

    /**
     * @return \App\Entity\MarketUser
     */
    public function getOwner(): MarketUser { return $this->owner; }

    /**
     * @return mixed
     */
    public function getDescription() { return $this->description; }

    public function getDateCreated() { return $this->dateCreated; }

    /**
     * @return mixed
     */
    public function getisPrimaryGroup() { return $this->isPrimaryGroup; }

    /**
     * @param MarketUser $owner
     */
    public function setOwner(MarketUser $owner)
    {
        if ($this->owner)
            return;
        $this->owner = $owner;
    }

    /**
     * @param mixed $name
     */
    public function setName($name) { $this->name = $name; }

    /**
     * @param mixed $description
     */
    public function setDescription($description) { $this->description = $description; }

    public function setDateCreated(\DateTime $dateCreated) { $this->dateCreated = $dateCreated; }

    /**
     * @param bool $isPrimaryGroup
     */
    public function setIsPrimaryGroup(bool $isPrimaryGroup) { $this->isPrimaryGroup = $isPrimaryGroup; }

}