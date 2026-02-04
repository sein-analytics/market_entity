<?php

namespace App\Entity;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
#[ORM\Table(name: 'CommunityInvite')]
#[ORM\Entity(repositoryClass: \App\Repository\CommunityInvite::class)]
class CommunityInvite
{
    /**
     * @var int
     **/
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    protected int $id;

    /**
     * @var Community
     */
    #[ORM\JoinColumn(name: 'community_id', referencedColumnName: 'id', nullable: false)]
    #[ORM\ManyToOne(targetEntity:  \App\Entity\Community::class, inversedBy: 'invites')]
    protected $community;

    /**
     * @var CommInviteStatus
     */
    #[ORM\JoinColumn(name: 'status_id', referencedColumnName: 'id', nullable: false)]
    #[ORM\ManyToOne(targetEntity:  \App\Entity\CommInviteStatus::class, inversedBy: 'invites')]
    protected $status;

    /**
     * @var null|MarketUser
     */
    #[ORM\JoinColumn(name: 'user_id', referencedColumnName: 'id', nullable: true)]
    #[ORM\ManyToOne(targetEntity:  \App\Entity\MarketUser::class, inversedBy: 'communityInvites')]
    protected $user;

    /**
     * @var ?string
     */
    #[ORM\Column(type: 'string', nullable: true)]
    protected ?string $email;

    /**
     * @var DateTime
     */
    #[ORM\Column(type: 'datetime', nullable: false)]
    protected $inviteDate;

    /**
     * @var string
     */
    #[ORM\Column(type: 'string', unique: true)]
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
     * @return DateTime
     */
    public function getInviteDate(): DateTime { return $this->inviteDate; }

    /**
     * @param DateTime $inviteDate
     */
    public function setInviteDate(DateTime $inviteDate): void { $this->inviteDate = $inviteDate; }

    /**
     * @return string
     */
    public function getUuid(): string { return $this->uuid; }

}