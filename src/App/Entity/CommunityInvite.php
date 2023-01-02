<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
//use Doctrine\ORM\Mapping as ORM;
/**
 * \Doctrine\ORM\Mapping\Entity(repositoryClass="\App\Repository\CommunityInvite")
 * \Doctrine\ORM\Mapping\Table(name="CommunityInvite")
 */
class CommunityInvite extends AnnotationMappings
{
    /**
     * \Doctrine\ORM\Mapping\Id
     * \Doctrine\ORM\Mapping\Column(type="integer")
     * \Doctrine\ORM\Mapping\GeneratedValue
     * @var int
     **/
    protected int $id;

    /**
     * \Doctrine\ORM\Mapping\ManyToOne (targetEntity="\App\Entity\Community", inversedBy="invites")
     * \Doctrine\ORM\Mapping\JoinColumn(name="community_id", referencedColumnName="id", nullable=false)
     * @var Community
     */
    protected $community;

    /**
     * \Doctrine\ORM\Mapping\ManyToOne (targetEntity="\App\Entity\CommInviteStatus", inversedBy="invites")
     * \Doctrine\ORM\Mapping\JoinColumn(name="status_id", referencedColumnName="id", nullable=false)
     * @var CommInviteStatus
     */
    protected $status;

    /**
     * \Doctrine\ORM\Mapping\ManyToOne (targetEntity="\App\Entity\MarketUser", inversedBy="communityInvites")
     * \Doctrine\ORM\Mapping\JoinColumn(name="user_id", referencedColumnName="id", nullable=true)
     * @var null|MarketUser
     */
    protected $user;

    /**
     * \Doctrine\ORM\Mapping\Column(type="string", nullable=true)
     * @var ?string
     */
    protected ?string $email;

    /**
     * \Doctrine\ORM\Mapping\Column(type="datetime", nullable=false)
     * {"type":"datetime","min":"2010-01-01T00:00:00Z","step":"1"}
     * {"format":"Y-m-d\TH:iP"}
     * @var \DateTime
     */
    protected $inviteDate;

    /**
     * \Doctrine\ORM\Mapping\GeneratedValue(strategy="UUID")
     * \Doctrine\ORM\Mapping\Column(type="string", unique=true)
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