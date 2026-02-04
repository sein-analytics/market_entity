<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 * Date: 12/3/18
 * Time: 11:35 AM
 */

namespace App\Entity;

use \App\Entity\GroupChat;
use DateTime;
use \App\Entity\MarketUser;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
#[ORM\Table(name: 'Community')]
#[ORM\Entity(repositoryClass: \App\Repository\Community::class)]
class Community
{
    /**
     * @var int
     **/
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    protected int $id;

    #[ORM\JoinTable(name: 'user_communities')]
    #[ORM\JoinColumn(name: 'comm_id', referencedColumnName: 'id')]
    #[ORM\InverseJoinColumn(name: 'user_id', referencedColumnName: 'id')]
    #[ORM\ManyToMany(targetEntity:  MarketUser::class, inversedBy: 'communities')]
    protected $users;

    /**
     * @var MarketUser
     */
    #[ORM\JoinColumn(name: 'owner', referencedColumnName: 'id', nullable: false)]
    #[ORM\ManyToOne(targetEntity:  MarketUser::class, inversedBy: 'myCommunities')]
    protected $owner;

    /**
     * @var string
     */
    #[ORM\Column(type: 'string', length: 35, unique: true, nullable: false)]
    protected string $name='';

    /**
     * @var string
     */
    #[ORM\Column(type: 'text', nullable: false)]
    protected string $description='';

    /**
     * @var DateTime
     **/
    #[ORM\Column(type: 'datetime', nullable: false)]
    protected $dateCreated;

    /**
     * @var int
     */
    #[ORM\Column(type: 'boolean', nullable: false, options: ['default' => '0'])]
    protected int $isPrimaryGroup = 0;

    /**
     * @var ArrayCollection
     */
    #[ORM\OneToMany(targetEntity: GroupChat::class, mappedBy: 'community')]
    protected $groupChats;

    /**
     * @var ?string
     */
    #[ORM\Column(type: 'string', nullable: true)]
    protected ?string $avatar;

    /**
     * @var string
     */
    #[ORM\Column(type: 'string', unique: true)]
    protected string $uuid;

    /**
     * @var ArrayCollection
     */
    #[ORM\OneToMany(targetEntity: CommunityInvite::class, mappedBy: 'community')]
    protected $invites;

    // @ORM\Column(type="boolean", options={"default":"0"}

    public function __construct()
    {
        $this->users  = new ArrayCollection();
        $this->groupChats = new ArrayCollection();
        $this->invites = new ArrayCollection();
    }

    public function addUserToCommunity(MarketUser $user){
        $this->users->add($user);
    }

    /**
     * @param CommunityInvite $invite
     */
    public function addCommunityInvite (CommunityInvite $invite):void
    {
        $this->invites->add($invite);
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
    public function getId():int { return $this->id; }

    /**
     * @return ArrayCollection
     */
    public function getUsers():ArrayCollection { return $this->users; }

    /**
     * @return string
     */
    public function getName():string { return $this->name; }

    /**
     * @return MarketUser
     */
    public function getOwner(): MarketUser { return $this->owner; }

    /**
     * @return string
     */
    public function getDescription():string { return $this->description; }

    public function getDateCreated():DateTime { return $this->dateCreated; }

    /**
     * @return int
     */
    public function getIsPrimaryGroup(): int
    {
        return $this->isPrimaryGroup;
    }

    /**
     * @return ArrayCollection
     */
    public function getGroupChats(): ArrayCollection
    {
        return $this->groupChats;
    }

    /**
     * @return string
     */
    public function getAvatar(): string
    {
        return $this->avatar;
    }

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
     * @return string
     */
    public function getUuid(): string
    {
        return $this->uuid;
    }

    /**
     * @param string $name
     */
    public function setName(string $name) { $this->name = $name; }

    /**
     * @param string  $description
     */
    public function setDescription(string $description):void { $this->description = $description; }

    public function setDateCreated(DateTime $dateCreated):void { $this->dateCreated = $dateCreated; }

    /**
     * @param int $isPrimaryGroup
     */
    public function setIsPrimaryGroup(int $isPrimaryGroup):void { $this->isPrimaryGroup = $isPrimaryGroup; }

    /**
     * @return ArrayCollection
     */
    public function getInvites ():ArrayCollection { return $this->invites; }

}