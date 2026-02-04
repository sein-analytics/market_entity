<?php

namespace App\Entity;
use \App\Entity\CommunityInvite;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'CommInviteStatus')]
#[ORM\Entity]
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
     * @var int
     **/
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    protected int $id;

    /**
     * @var string
     */
    #[ORM\Column(type: 'string', nullable: false)]
    protected string $label = '';

    /**
     * @var ArrayCollection
     */
    #[ORM\OneToMany(targetEntity: CommunityInvite::class, mappedBy: 'status')]
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