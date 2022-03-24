<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity(repositoryClass="\App\Repository\CommunityInvite")
 * @ORM\Table(name="CommunityInvite")
 */
class CommunityInvite
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     * @var int
     **/
    protected $id;

    /**
     * @ORM\ManyToOne (targetEntity="\App\Entity\Community", inversedBy="invites")
     * @ORM\JoinColumn(name="community_id", referencedColumnName="id", nullable=false)
     * @var Community
     */
    protected $community;

    /**
     * @ORM\ManyToOne (targetEntity="\App\Entity\CommInviteStatus", inversedBy="invites")
     * @ORM\JoinColumn(name="status_id", referencedColumnName="id", nullable=false)
     * @var CommInviteStatus
     */
    protected $status;

    /**
     * @ORM\ManyToOne (targetEntity="\App\Entity\MarketUser", inversedBy="communityInvites")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=true)
     * @var null|MarketUser
     */
    protected $user;

    /**
     * @return int
     */
    public function getId(): int { return $this->id; }

    /**
     * @return Community
     */
    public function getCommunity():Community { return $this->community; }

    /**
     * @param Community
     */
    public function setCommunityId(Community $community): void { $this->community = $community; }

    /**
     * @return null|MarketUser
     */
    public function getUser(): ?MarketUser{ return $this->user; }

    /**
     * @param mixed $user
     */
    public function setUser(MarketUser $user): void{ $this->user = $user; }

    /**
     * @return CommInviteStatus
     */
    public function getStatus(): CommInviteStatus { return $this->status; }

    /**
     * @param CommInviteStatus $status
     */
    public function setStatus(CommInviteStatus $status): void { $this->status = $status; }




}