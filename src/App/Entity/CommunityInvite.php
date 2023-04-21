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
    protected int $id;

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
     * @ORM\Column(type="string", nullable=true)
     * @var ?string
     */
    protected ?string $email;

    /**
     * @ORM\Column(type="datetime", nullable=false)
     * {"type":"datetime","min":"2010-01-01T00:00:00Z","step":"1"}
     * {"format":"Y-m-d\TH:iP"}
     * @var \DateTime
     */
    protected $inviteDate;

    /**
     * @ORM\GeneratedValue(strategy="UUID")
     * @ORM\Column(type="string", unique=true)
     * @var string
     */
    protected string $uuid;

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

    /**
     * @return null|string
     */
    public function getEmail(): ?string { return $this->email; }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void { $this->email = $email; }

    /**
     * @return \DateTime
     */
    public function getInviteDate(): \DateTime { return $this->inviteDate; }

    /**
     * @param \DateTime $inviteDate
     */
    public function setInviteDate(\DateTime $inviteDate): void { $this->inviteDate = $inviteDate; }

    /**
     * @return string
     */
    public function getUuid(): string { return $this->uuid; }

}