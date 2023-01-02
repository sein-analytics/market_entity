<?php

namespace App\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="CommInviteStatus")
 */
class CommInviteStatus
{
    const EMAIL_ERROR = 'emailError';

    const PENDING_RESPONSE = 'pending';

    const INVITE_ACCEPT = 'accepted';

    const INVITE_REJECT = 'rejected';

    const ON_BOARDING_USER = 'on-boarding';

    protected static array $inviteStatuses = [
        self::PENDING_RESPONSE => 1,
        self::INVITE_ACCEPT => 2,
        self::ON_BOARDING_USER => 3,
        self::INVITE_REJECT => 4,
        self::EMAIL_ERROR => 5
    ];

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     * @var int
     **/
    protected int $id;

    /**
     * @ORM\Column(type="string", nullable=false)
     * @var string
     */
    protected string $label = '';

    /**
     * @ORM\OneToMany(targetEntity="\App\Entity\CommunityInvite", mappedBy="status")
     * @var ArrayCollection
     */
    protected $invites;

    public function __construct () {
        $this->invites = new ArrayCollection();
    }

    /**
     * @return string
     */
    public function getLabel(): string { return $this->label; }

    /**
     * @return ArrayCollection
     */
    public function getInvites(): ArrayCollection { return $this->invites; }

    /**
     * @return int[]
     */
    public static function getInviteStatuses(): array { return self::$inviteStatuses; }


}