<?php

namespace App\Entity;

use App\Entity\Data\State;
use App\Service\CreatePropertiesArrayTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\PersistentCollection;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticableContracts;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContracts;
use Illuminate\Notifications\Notification;
use LaravelDoctrine\ORM\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

#[ORM\Entity(repositoryClass: \App\Repository\MarketUser::class)]
#[ORM\Table(name: 'MarketUser')]
#[ORM\ChangeTrackingPolicy('DEFERRED_EXPLICIT')]
#[ORM\HasLifecycleCallbacks]
class MarketUser extends DomainObject implements AuthenticableContracts, CanResetPasswordContracts, JWTSubject
{
    use CreatePropertiesArrayTrait, Authenticatable, CanResetPassword, Notifiable;

    public const ASAP = 'asap';
    public const DAILY = 'daily';
    public const NOTIFY_OFF = 'off'; // this is just to reflect the update of the composer for plugin_entity

    public const NOTIFY = [
        1 => self::ASAP,
        2 => self::DAILY,
        3 => self::NOTIFY_OFF,
    ];

    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    #[ORM\Column(type: Types::INTEGER)]
    protected int $id;

    public $incrementing = false;

    #[ORM\Column(type: Types::STRING, unique: true, nullable: false)]
    protected string $userName = '';

    #[ORM\Column(type: Types::STRING, nullable: false)]
    protected string $firstName = '';

    #[ORM\Column(type: Types::STRING, nullable: false)]
    protected string $lastName = '';

    #[ORM\Column(type: Types::STRING, nullable: false)]
    protected string $image_arn = '';

    #[ORM\Column(type: Types::STRING, nullable: true)]
    protected ?string $signature_arn = null;

    #[ORM\Column(type: Types::STRING, nullable: false)]
    protected string $companyAddress = '';

    #[ORM\Column(type: Types::STRING, nullable: false)]
    protected string $city = '';

    #[ORM\Column(type: Types::STRING, nullable: false)]
    protected string $zip = '';

    #[ORM\ManyToOne(targetEntity: State::class, inversedBy: 'users')]
    protected ?State $state = null;

    #[ORM\Column(type: Types::STRING, unique: true, nullable: false)]
    protected string $phone = '';

    // {"type":"datetime","min":"2010-01-01T00:00:00Z","max":"2020-01-01T00:00:00Z","step":"1"}
    // {"format":"Y-m-d\TH:iP"}
    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    protected ?\DateTime $createdAt = null;

    // {"type":"datetime","min":"2010-01-01T00:00:00Z","max":"2020-01-01T00:00:00Z","step":"1"}
    // {"format":"Y-m-d\TH:iP"}
    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    protected ?\DateTime $updatedAt = null;

    #[ORM\ManyToOne(targetEntity: Issuer::class, inversedBy: 'users')]
    protected ?Issuer $issuer = null;

    /**
     * This doubles as the users uuid
     */
    #[ORM\Column(type: Types::STRING, unique: true)]
    protected string $emailConfirmHash = '';

    #[ORM\Column(type: Types::STRING, unique: true)]
    protected string $email = '';

    #[ORM\Column(type: Types::STRING, unique: true)]
    protected string $phoneConfirmToken = '';

    #[ORM\Column(type: Types::STRING, length: 255, nullable: true)]
    protected ?string $userSalt = null;

    #[ORM\Column(type: Types::INTEGER, nullable: true)]
    protected ?int $notifications = null;

    #[ORM\OneToMany(targetEntity: Deal::class, mappedBy: 'user')]
    protected ArrayCollection|PersistentCollection|null $deals = null;

    #[ORM\Column(type: Types::STRING, nullable: false)]
    protected string $password = '';

    #[ORM\OneToMany(targetEntity: LoginLog::class, mappedBy: 'user')]
    protected ArrayCollection|PersistentCollection|null $logins = null;

    #[ORM\OneToMany(targetEntity: UserStip::class, mappedBy: 'user')]
    protected ArrayCollection|PersistentCollection|null $stips = null;

    #[ORM\OneToMany(targetEntity: Bid::class, mappedBy: 'user')]
    protected ArrayCollection|PersistentCollection|null $bids = null;

    #[ORM\OneToMany(targetEntity: CommunityInvite::class, mappedBy: 'user')]
    protected ArrayCollection|PersistentCollection|null $communityInvites = null;

    #[ORM\OneToMany(targetEntity: Message::class, mappedBy: 'user')]
    protected ArrayCollection|PersistentCollection|null $messages = null;

    #[ORM\ManyToMany(targetEntity: Message::class, mappedBy: 'recipients')]
    protected ArrayCollection|PersistentCollection|null $receivedMessages = null;

    #[ORM\OneToMany(targetEntity: DocAccess::class, mappedBy: 'user')]
    protected ArrayCollection|PersistentCollection|null $documents = null;

    #[ORM\ManyToOne(targetEntity: AclRole::class, inversedBy: 'users')]
    protected ?AclRole $role = null;

    #[ORM\ManyToOne(targetEntity: UserStatus::class, inversedBy: 'users')]
    protected ?UserStatus $status = null;

    #[ORM\ManyToOne(targetEntity: FailedLogin::class, inversedBy: 'users')]
    protected ?FailedLogin $failedAttempts = null;

    #[ORM\ManyToMany(targetEntity: Speciality::class, mappedBy: 'users')]
    protected $specialities;

    #[ORM\Column(type: Types::BIGINT, unique: true, nullable: false)]
    protected int $authyId = 0;

    #[ORM\Column(type: Types::FLOAT, precision: 14, scale: 2, nullable: false)]
    protected float $closedVolume = 0;

    #[ORM\Column(type: Types::FLOAT, precision: 14, scale: 2, nullable: false)]
    protected float $dealVolume = 0;

    #[ORM\OneToMany(targetEntity: Rating::class, mappedBy: 'user')]
    protected ArrayCollection|PersistentCollection|null $ratings = null;

    #[ORM\ManyToMany(targetEntity: Community::class, mappedBy: 'users')]
    protected ArrayCollection|PersistentCollection|null $communities = null;

    #[ORM\OneToMany(targetEntity: Community::class, mappedBy: 'owner')]
    protected ArrayCollection|PersistentCollection|null $myCommunities = null;

    #[ORM\OneToMany(targetEntity: Rating::class, mappedBy: 'rater')]
    protected ArrayCollection|PersistentCollection|null $rated = null;

    #[ORM\ManyToMany(targetEntity: MarketUser::class)]
    #[ORM\JoinTable(name: 'followers')]
    #[ORM\JoinColumn(name: 'user_id', referencedColumnName: 'id')]
    #[ORM\InverseJoinColumn(name: 'follower_id', referencedColumnName: 'id')]
    protected ArrayCollection|PersistentCollection|null $followers = null;

    #[ORM\ManyToMany(targetEntity: MarketUser::class)]
    #[ORM\JoinTable(name: 'following')]
    #[ORM\JoinColumn(name: 'user_id', referencedColumnName: 'id')]
    #[ORM\InverseJoinColumn(name: 'following_id', referencedColumnName: 'id')]
    protected ArrayCollection|PersistentCollection|null $following = null;

    #[ORM\OneToMany(targetEntity: DealFile::class, mappedBy: 'user')]
    protected ArrayCollection|PersistentCollection|null $files = null;

    #[ORM\ManyToMany(targetEntity: Deal::class, inversedBy: 'userFavorites')]
    #[ORM\JoinTable(name: 'user_favorite_deals')]
    #[ORM\JoinColumn(name: 'user_id', referencedColumnName: 'id')]
    #[ORM\InverseJoinColumn(name: 'favorite_deal_id', referencedColumnName: 'id')]
    protected ArrayCollection|PersistentCollection|null $marketFavorites = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    protected ?string $token = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    protected ?string $authyToken = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    protected ?string $rememberToken = null;

    #[ORM\ManyToMany(targetEntity: Deal::class, inversedBy: 'marketUsers')]
    protected ArrayCollection|PersistentCollection|null $marketDeals = null;

    #[ORM\ManyToMany(targetEntity: \App\Entity\Loan\SaleAttribute::class, mappedBy: 'buyers')]
    protected ArrayCollection|PersistentCollection|null $boughtLoans = null;

    #[ORM\OneToMany(targetEntity: DueDiligence::class, mappedBy: 'user')]
    protected ArrayCollection|PersistentCollection|null $diligence = null;

    #[ORM\OneToMany(targetEntity: LoanTapeTemplate::class, mappedBy: 'user')]
    protected ArrayCollection|PersistentCollection|null $templates = null;

    #[ORM\OneToMany(targetEntity: Chat::class, mappedBy: 'user')]
    protected ArrayCollection|PersistentCollection|null $chats = null;

    #[ORM\OneToMany(targetEntity: Chat::class, mappedBy: 'recipient')]
    protected $chatRecipient;

    #[ORM\OneToMany(targetEntity: GroupChat::class, mappedBy: 'user')]
    protected ArrayCollection|PersistentCollection|null $groupChats = null;

    #[ORM\ManyToMany(targetEntity: GroupChat::class, mappedBy: 'members')]
    protected ArrayCollection|PersistentCollection|null $chatGroupMemberships = null;

    protected ArrayCollection $mappedTypes;

    #[ORM\OneToMany(targetEntity: DealContract::class, mappedBy: 'buyer')]
    protected ArrayCollection|PersistentCollection|null $contracts = null;

    public function __construct()
    {
        $this->bids = new ArrayCollection();
        $this->logins = new ArrayCollection();
        $this->stips = new ArrayCollection();
        $this->documents = new ArrayCollection();
        $this->followers = new ArrayCollection();
        $this->following = new ArrayCollection();
        $this->receivedMessages = new ArrayCollection();
        $this->diligence = new ArrayCollection();
        $this->files = new ArrayCollection();
        $this->marketDeals = new ArrayCollection();
        $this->marketFavorites = new ArrayCollection();
        $this->templates = new ArrayCollection();
        $this->mappedTypes = new ArrayCollection();
        $this->rated = new ArrayCollection();
        $this->ratings = new ArrayCollection();
        $this->role = new AclRole();
        $this->communities = new ArrayCollection();
        $this->myCommunities = new ArrayCollection();
        $this->communityInvites = new ArrayCollection();
        $this->failedAttempts = new FailedLogin();
        $this->contracts = new ArrayCollection();
        parent::__construct();
    }

    public function routeNotificationForSlack(Notification $notification): string
    {
        return env('SLACK_HOOK_NOTIFY');
    }

    public function getJWTIdentifier()
    {
        return $this->getId();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function setPasswordAttribute($password)
    {
        if (! empty($password)) {
            $this->password = bcrypt($password);
        }
    }

    public function addMarketDeal(Deal $deal): void
    {
        $this->marketDeals->add($deal);
    }

    public function addMarketFavorites(Deal $deal): void
    {
        $this->marketFavorites->add($deal);
    }

    public function removeDealFromMarketFavorites(Deal $deal): void
    {
        if (! $this->marketFavorites->contains($deal)) {
            return;
        }

        $this->marketFavorites->removeElement($deal);
        $deal->removeUserFromUserFavorites($this);
    }

    public function addMappedType(MappedUserType $type): void
    {
        $this->mappedTypes->add($type);
    }

    public function addUserCommunity(Community $community): void
    {
        $this->communities->add($community);
    }

    public function removeCommunity(Community $community): void
    {
        if (! $this->communities->contains($community)) {
            return;
        }

        $this->communities->removeElement($community);
        $community->removeUserFromCommunity($this);
    }

    public function addUserToMyCommunity(Community $community, MarketUser $user): void
    {
        if (! $this->myCommunities->contains($community) || $community->getUsers()->contains($user)) {
            return;
        }

        $community->addUserToCommunity($user);
    }

    public function removeUserFromMyCommunity(Community $community, $user): void
    {
        if (! $this->myCommunities->contains($community) || ! $community->getUsers()->contains($user)) {
            return;
        }

        $community->removeUserFromCommunity($user);
    }

    public function getId(): int { return $this->id; }
    public function getUserName(): string { return $this->userName; }

    public function addDiligence(DueDiligence $diligence): void
    {
        $this->diligence->add($diligence);
    }

    public function addTemplate(LoanTapeTemplate $template): void
    {
        $this->templates->add($template);
    }

    public function addRated(Rating $rating): void
    {
        $this->rated->add($rating);
    }

    public function addRatings(Rating $rating): void
    {
        $this->ratings->add($rating);
    }

    public function getAuthPassword(): string { return $this->password; }
    public function getAuthIdentifierName(): string { return 'userName'; }
    public function getAuthIdentifier(): string { return $this->userName; }

    public function getRememberTokenName(): string { return 'rememberToken'; }
    public function getRememberToken(): string { return $this->rememberToken; }

    public function setRememberToken($value): void
    {
        $this->rememberToken = $value;
    }

    public function setAuthPassword(mixed $password): void
    {
        $this->password = $password;
    }

    public function setAuthyToken($authyToken): void
    {
        $this->authyToken = $authyToken;
    }

    public function getUserSalt(): ?string { return $this->userSalt; }
    public function getStatus(): UserStatus { return $this->status; }

    public function setStatus(UserStatus $status): void
    {
        $this->implementChange($this, 'status', $this->status, $status);
    }

    public function setIssuer(Issuer $issuer): void
    {
        $this->issuer = $issuer;
    }

    public function getFailedAttempts(): FailedLogin { return $this->failedAttempts; }

    public function setFailedAttempts(FailedLogin $failedAttempts): void
    {
        $this->implementChange($this, 'failedAttempts', $this->failedAttempts, $failedAttempts);
    }

    public function addFollower(MarketUser $follower): void
    {
        $this->followers->add($follower);
    }

    public function removeFollower(MarketUser $follower): void
    {
        $this->followers->removeElement($follower);
    }

    public function getAuthyId(): int { return $this->authyId; }

    public function setAuthyId(int $authyId): void
    {
        $this->implementChange($this, 'authyId', $this->authyId, $authyId);
    }

    public function setNotifications(int $int): ?\Exception
    {
        if (array_key_exists($int, self::NOTIFY)) {
            $this->notifications = $int;
            return null;
        }

        return new \Exception('Notifications must be either 1, 2 or 3.');
    }

    public function getDiligence(): ArrayCollection|PersistentCollection|null { return $this->diligence; }

    public function getFiles(): ArrayCollection|PersistentCollection|null { return $this->files; }
    public function getMarketDeals(): ArrayCollection|PersistentCollection|null { return $this->marketDeals; }
    public function getMarketFavorites(): ArrayCollection|PersistentCollection|null { return $this->marketFavorites; }
    public function getTemplates(): ArrayCollection|PersistentCollection|null { return $this->templates; }
    public function getMappedTypes(): ArrayCollection { return $this->mappedTypes; }

    public function getFirstName(): string { return $this->firstName; }
    public function getLastName(): string { return $this->lastName; }
    public function getSignatureArn(): ?string { return $this->signature_arn; }
    public function getIssuer(): Issuer { return $this->issuer; }
    public function getImageArn(): string { return $this->image_arn; }
    public function getEmail(): string { return $this->email; }

    public function getNotifications(): ?string
    {
        // NOTE: original property is ?int but method returns ?string in your code.
        // Keeping your original signature, but you may want to change this to ?int.
        return $this->notifications;
    }

    public function getRole(): AclRole { return $this->role; }
    public function getMessages(): ArrayCollection|PersistentCollection|null { return $this->messages; }
    public function getRatings(): ArrayCollection|PersistentCollection|null { return $this->ratings; }
    public function getRated() { return $this->rated; }
    public function getAuthyToken(): ?string { return $this->authyToken; }
    public function getCommunities(): ArrayCollection|PersistentCollection|null { return $this->communities; }
    public function getMyCommunities(): ArrayCollection|PersistentCollection|null { return $this->myCommunities; }
    public function getEmailConfirmHash(): string { return $this->emailConfirmHash; }

    public function addLogin(LoginLog $login): void
    {
        $this->logins->add($login);
        $this->implementChange($this, 'logins', $this->logins, $this->logins);
    }

    public function getLogins(): ArrayCollection|PersistentCollection|null
    {
        return $this->logins;
    }

    public function addStip(UserStip $stip): void
    {
        $this->stips->add($stip);
        $this->implementChange($this, 'stips', $this->stips, $this->stips);
    }

    public function getStips(): ArrayCollection|PersistentCollection|null
    {
        return $this->stips;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function loginToArray(): array
    {
        return [
            'id' => $this->getId(),
            'organization' => $this->getIssuer()->getIssuerName(),
            'name' => $this->getFirstName() . ' ' . $this->getLastName(),
            'picture' => $this->getImageArn(),
            'username' => $this->getUserName(),
            'access_token' => $this->getRememberToken(),
            'authy_token' => $this->getAuthyToken(),
            'authy_id' => $this->getAuthyId(),
            'role' => $this->getRole()->getId(),
        ];
    }

    public function getContracts(): ArrayCollection|PersistentCollection|null
    {
        return $this->contracts;
    }
}

/**
 * @ORM\Entity(repositoryClass="\App\Repository\MarketUser")
 * @ORM\Table(name="MarketUser")
 * @ORM\ChangeTrackingPolicy("NOTIFY")
 * @HasLifecycleCallbacks
 */
// class MarketUser
//     extends DomainObject
//     implements AuthenticableContracts, CanResetPasswordContracts, JWTSubject
// {
//     use CreatePropertiesArrayTrait, Authenticatable, CanResetPassword, Notifiable;

//     const ASAP = 'asap';

//     const DAILY = 'daily';

//     const NOTIFY_OFF = 'off';//this is just to reflect the update of the composer for plugin_entity

//     const NOTIFY =[
//         1 => self::ASAP,
//         2 => self::DAILY,
//         3 => self::NOTIFY_OFF
//     ];

//     /**
//      * @ORM\Id
//      * @ORM\GeneratedValue(strategy="AUTO")
//      * @ORM\Column(type="integer")
//      */
//     protected int $id;

//     public $incrementing = false;

//     /**
//      * @ORM\Column(type="string", nullable=false, unique=true)
//      * @var string
//      */
//     protected string $userName='';

//     /**
//      * @ORM\Column(type="string", nullable=false)
//      * @var string
//      */
//     protected string $firstName='';

//     /**
//      * @ORM\Column(type="string", nullable=false)
//      * @var string
//      */
//     protected string $lastName='';

//     /**
//      * @ORM\Column(type="string", nullable=false)
//      *@var string
//      */
//     protected string $image_arn='';

//     /**
//      * @ORM\Column(type="string", nullable=true)
//      * @var ?string
//      */
//     protected ?string $signature_arn;

//     /**
//      * @ORM\Column(type="string", nullable=false)
//      * @var string
//      */
//     protected string $companyAddress='';

//     /**
//      * @ORM\Column(type="string", nullable=false)
//      * @var string
//      */
//     protected string $city='';

//     /**
//      * @ORM\Column(type="string", nullable=false)
//      *@var string
//      */
//     protected string $zip='';

//     /**
//      * @ORM\ManyToOne(targetEntity="\App\Entity\Data\State", inversedBy="users")
//      * @var State
//      **/
//     protected $state;

//     /**
//      * @ORM\Column(type="string", unique=true, nullable=false)
//      * @var string
//      */
//     protected string $phone='';

//     /**
//      * @ORM\Column(type="datetime", nullable=true)
//      *{"type":"datetime","min":"2010-01-01T00:00:00Z","max":"2020-01-01T00:00:00Z","step":"1"}
//      * {"format":"Y-m-d\TH:iP"}
//      * @var \DateTime
//      */
//     protected $createdAt;

//     /**
//      * @ORM\Column(type="datetime", nullable=true)
//      * {"type":"datetime","min":"2010-01-01T00:00:00Z","max":"2020-01-01T00:00:00Z","step":"1"}
//      * {"format":"Y-m-d\TH:iP"}
//      * @var \DateTime
//      */
//     protected $updatedAt;

//     /**
//      * @ORM\ManyToOne(targetEntity="App\Entity\Issuer", inversedBy="users")
//      * @var Issuer
//      */
//     protected $issuer;

//     /**
//      * @ORM\Column(type="string", unique=true)
//      * @var string
//      *
//      * This doubles as the users uuid
//      */
//     protected string $emailConfirmHash='';

//     /**
//      * @ORM\Column(type="string", unique=true)
//      * @var string
//      */
//     protected string $email;

//     /**
//      * @ORM\Column(type="string", unique=true)
//      * @var string
//      */
//     protected string $phoneConfirmToken='';

//     /**
//      * @ORM\Column(type="string", length=255, nullable=true)
//      * @var ?string
//      */
//     protected ?string $userSalt;

//     /**
//      * @ORM\Column(type="integer", nullable=true)
//      * @var ?int
//      */
//     protected ?int $notifications;

//     /**
//      * @ORM\OneToMany(targetEntity="\App\Entity\Deal", mappedBy="user")
//      * @var ArrayCollection|PersistentCollection|null
//      */
//     protected $deals;

//     /**
//      * @ORM\Column(type="string", nullable=false)
//      * @var string
//      */
//     protected string $password='';

//     /**
//      * @ORM\OneToMany(targetEntity="\App\Entity\LoginLog", mappedBy="user")
//      * @var ArrayCollection|PersistentCollection|null
//      */
//     protected $logins;

//     /**
//      * @ORM\OneToMany(targetEntity="\App\Entity\UserStip", mappedBy="user")
//      * @var ArrayCollection|PersistentCollection|null
//      */
//     protected $stips;

//     /**
//      * @ORM\OneToMany(targetEntity="\App\Entity\Bid", mappedBy="user")
//      * @var ArrayCollection|PersistentCollection|null
//      */
//     protected $bids;

//     /**
//      * @ORM\OneToMany(targetEntity="App\Entity\CommunityInvite", mappedBy="user")
//      * @var ArrayCollection|PersistentCollection|null
//      */
//     protected $communityInvites;

//     /**
//      * @ORM\OneToMany(targetEntity="\App\Entity\Message", mappedBy="user")
//      * @var ArrayCollection|PersistentCollection|null
//      */
//     protected $messages;

//     /**
//      * @ORM\ManyToMany(targetEntity="\App\Entity\Message", mappedBy="recipients")
//      * @var ArrayCollection|PersistentCollection|null
//      */
//     protected $receivedMessages;

//     /**
//      * @ORM\OneToMany(targetEntity="\App\Entity\DocAccess", mappedBy="user")
//      * @var ArrayCollection|PersistentCollection|null
//      */
//     protected $documents;

//     /**
//      * @ORM\ManyToOne(targetEntity="\App\Entity\AclRole", inversedBy="users")
//      * @var AclRole
//      */
//     protected $role;

//     /**
//      * @ORM\ManyToOne(targetEntity="\App\Entity\UserStatus", inversedBy="users")
//      * @var UserStatus
//      */
//     protected $status;

//     /**
//      * @ORM\ManyToOne(targetEntity="\App\Entity\FailedLogin", inversedBy="users")
//      * @var FailedLogin
//      */
//     protected $failedAttempts;

//     /**
//      * @ORM\ManyToMany(targetEntity="App\Entity\Speciality", mappedBy="users")
//      * @var Speciality
//      */
//     protected $specialities;

//     /**
//      * @ORM\Column(type="bigint", nullable=false, unique=true)
//      * @var int
//      */
//     protected int $authyId = 0;

//     /**
//      * @ORM\Column(type="float", precision=14, scale=2, nullable=false)
//      * @var float
//      */
//     protected float $closedVolume = 0;

//     /**
//      * @ORM\Column(type="float", precision=14, scale=2, nullable=false)
//      * @var float
//      */
//     protected float $dealVolume = 0;

//     /**
//      * @ORM\OneToMany(targetEntity="\App\Entity\Rating", mappedBy="user")
//      * @var ArrayCollection|PersistentCollection|null
//      **/
//     protected $ratings;

//     /**
//      * @ORM\ManyToMany(targetEntity="\App\Entity\Community", mappedBy="users")
//      * @var ArrayCollection|PersistentCollection|null
//      */
//     protected $communities;

//     /**
//      * @ORM\OneToMany(targetEntity="\App\Entity\Community", mappedBy="owner")
//      * @var ArrayCollection|PersistentCollection|null
//      */
//     protected $myCommunities;

//     /**
//      * @ORM\OneToMany(targetEntity="\App\Entity\Rating", mappedBy="rater")
//      * @var ArrayCollection|PersistentCollection|null
//      **/
//     protected $rated;

//     /**
//      * @ORM\ManyToMany(targetEntity="\App\Entity\MarketUser")
//      * @ORM\JoinTable(name="followers",
//      *     joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
//      *     inverseJoinColumns={@ORM\JoinColumn(name="follower_id", referencedColumnName="id")}
//      *     )
//      * @var ArrayCollection|PersistentCollection|null
//      **/
//     protected $followers;

//     /**
//      * @ORM\ManyToMany(targetEntity="\App\Entity\MarketUser")
//      * @ORM\JoinTable(name="following",
//      *     joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
//      *     inverseJoinColumns={@ORM\JoinColumn(name="following_id", referencedColumnName="id")}
//      *     )
//      * @var ArrayCollection|PersistentCollection|null
//      **/
//     protected $following;

//     /**
//      * @ORM\OneToMany(targetEntity="\App\Entity\DealFile", mappedBy="user")
//      * @var ArrayCollection|PersistentCollection|null
//      */
//     protected $files;

//     /**
//      * @ORM\ManyToMany(targetEntity="\App\Entity\Deal", inversedBy="userFavorites")
//      * @ORM\JoinTable(name="user_favorite_deals",
//      *     joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
//      *     inverseJoinColumns={@ORM\JoinColumn(name="favorite_deal_id", referencedColumnName="id")}
//      *     )
//      * @var ArrayCollection|PersistentCollection|null
//      */
//     protected $marketFavorites;

//     /**
//      * @ORM\Column(type="text", nullable=true)
//      * @var ?string
//      */
//     protected ?string $token;

//     /**
//      * @ORM\Column(type="text", nullable=true)
//      * @var ?string
//      */
//     protected ?string $authyToken;

//     /**
//      * @ORM\Column(type="text", nullable=true)
//      * @var ?string
//      */
//     protected ?string $rememberToken;

//     /**
//      * @ORM\ManyToMany(targetEntity="\App\Entity\Deal", inversedBy="marketUsers")
//      * @var ArrayCollection|PersistentCollection|null
//      */
//     protected $marketDeals;

//     /**
//      * @ORM\ManyToMany(targetEntity="\App\Entity\Loan\SaleAttribute", mappedBy="buyers")
//      * @var ArrayCollection|PersistentCollection|null
//      */
//     protected $boughtLoans;

//     /**
//      * @ORM\OneToMany(targetEntity="\App\Entity\DueDiligence", mappedBy="user")
//      * @var ArrayCollection|PersistentCollection|null
//      */
//     protected $diligence;

//     /**
//      * @ORM\OneToMany(targetEntity="\App\Entity\LoanTapeTemplate", mappedBy="user")
//      * @var  ArrayCollection|PersistentCollection|null
//      * */
//     protected $templates;

//     /**
//      * @ORM\OneToMany(targetEntity="\App\Entity\Chat", mappedBy="user")
//      * @var ArrayCollection|PersistentCollection|null
//      */
//     protected $chats;

//     /**
//      * @ORM\OneToMany(targetEntity="\App\Entity\Chat", mappedBy="recipient")
//      * @var MarketUser
//      */
//     protected $chatRecipient;

//     /**
//      * @ORM\OneToMany(targetEntity="\App\Entity\GroupChat", mappedBy="user")
//      * @var ArrayCollection|PersistentCollection|null
//      */
//     protected $groupChats;

//     /**
//      * @ORM\ManyToMany(targetEntity="\App\Entity\GroupChat", mappedBy="members")
//      * @var ArrayCollection|PersistentCollection|null
//      */
//     protected $chatGroupMemberships;

//     /**
//      * @var  ArrayCollection
//      * */
//     protected $mappedTypes;

//     /**
//      * @ORM\OneToMany(targetEntity="\App\Entity\DealContract", mappedBy="buyer")
//      * @var ArrayCollection|PersistentCollection|null
//      */
//     protected $contracts;

//     public function __construct()
//     {
//         $this->bids = new ArrayCollection();
//         $this->logins = new ArrayCollection();
//         $this->stips = new ArrayCollection();
//         $this->documents = new ArrayCollection();
//         $this->followers = new ArrayCollection();
//         $this->following = new ArrayCollection();
//         $this->receivedMessages = new ArrayCollection();
//         $this->diligence = new ArrayCollection();
//         $this->files = new ArrayCollection();
//         $this->marketDeals = new ArrayCollection();
//         $this->marketFavorites = new ArrayCollection();
//         $this->templates = new ArrayCollection();
//         $this->mappedTypes = new ArrayCollection();
//         $this->rated = new ArrayCollection();
//         $this->ratings = new ArrayCollection();
//         $this->role = new AclRole();
//         $this->communities = new ArrayCollection();
//         $this->myCommunities = new ArrayCollection();
//         $this->communityInvites = new ArrayCollection();
//         $this->failedAttempts = new FailedLogin();
//         $this->contracts = new ArrayCollection();
//         parent::__construct();
//     }

//     public function routeNotificationForSlack(Notification $notification):string {
//         return env('SLACK_HOOK_NOTIFY');
//     }

//     /**
//      * @return int
//      */
//     public  function getJWTIdentifier()
//     {
//         return $this->getId();
//     }

//     /**
//      * @return array
//      */
//     public function getJWTCustomClaims()
//     {
//         return [];
//     }

//     public function setPasswordAttribute($password)
//     {
//         if(!empty($password)){
//             $this->password = bcrypt($password);
//         }
//     }

//     function addMarketDeal(Deal $deal)
//     {
//         $this->marketDeals->add($deal);
//     }

//     function addMarketFavorites(Deal $deal){ $this->marketFavorites->add($deal); }

//     /**
//      * @param Deal $deal
//      */
//     function removeDealFromMarketFavorites(Deal $deal)
//     {
//         if (! $this->marketFavorites->contains($deal))
//             return;
//         $this->marketFavorites->removeElement($deal);
//         $deal->removeUserFromUserFavorites($this);
//     }

//     function addMappedType(MappedUserType $type){
//         $this->mappedTypes->add($type);
//     }

//     function addUserCommunity(Community $community){
//         $this->communities->add($community);
//     }

//     function removeCommunity(Community $community)
//     {
//         if (! $this->communities->contains($community))
//             return;
//         $this->communities->removeElement($community);
//         $community->removeUserFromCommunity($this);
//     }

//     function addUserToMyCommunity(Community $community, MarketUser $user)
//     {
//         if(! $this->myCommunities->contains($community)
//             || $community->getUsers()->contains($user))
//             return;
//         $community->addUserToCommunity($user);
//     }

//     function removeUserFromMyCommunity(Community $community, $user)
//     {
//         if(!$this->myCommunities->contains($community) ||
//             !$community->getUsers()->contains($user))
//             return;
//         $community->removeUserFromCommunity($user);
//     }

//     /**
//      * @return int
//      */
//     public function getId():int { return $this->id; }

//     /**
//      * @return string
//      */
//     public function getUserName():string { return $this->userName; }

//     function addDiligence(DueDiligence $diligence)
//     {
//         $this->diligence->add($diligence);
//     }

//     function addTemplate(LoanTapeTemplate $template)
//     {
//         $this->templates->add($template);
//     }

//     function addRated(Rating  $rating){
//         $this->rated->add($rating);
//     }

//     function addRatings(Rating $rating){
//         $this->ratings->add($rating);
//     }

//     /**
//      * @return string
//      */
//     public function getAuthPassword(): string
//     { return $this->password; }

//     public function getAuthIdentifierName():string { return 'userName'; }

//     /**
//      * @return string
//      */
//     public function getAuthIdentifier():string { return $this->userName; }

//     public function getRememberTokenName():string { return 'rememberToken'; }

//     public function getRememberToken():string { return $this->rememberToken; }

//     public function setRememberToken($value)
//     {
//         $this->rememberToken = $value;
//     }

//     /**
//      * @param mixed $password
//      */
//     public function setAuthPassword(mixed $password) { $this->password = $password; }

//     public function setAuthyToken ($authyToken) { $this->authyToken = $authyToken; }

//     /**
//      * @return ?string
//      */
//     public function getUserSalt():?string { return $this->userSalt; }

//     /**
//      * @return UserStatus
//      */
//     public function getStatus():UserStatus { return $this->status; }

//     /**
//      * @param $status UserStatus
//      * @throws \Exception
//      */
//     public function setStatus(UserStatus $status):void
//     {
//         $this->implementChange($this,'status', $this->status, $status);
//     }

//     public function setIssuer(Issuer $issuer) { $this->issuer =  $issuer; }

//     /**
//      * @return FailedLogin
//      */
//     public function getFailedAttempts(): FailedLogin { return $this->failedAttempts; }

//     /**
//      * @param $failedAttempts
//      * @throws \Exception
//      */
//     public function setFailedAttempts(FailedLogin $failedAttempts)
//     {
//         $this->implementChange($this,'failedAttempts', $this->failedAttempts, $failedAttempts);
//     }

//     public function addFollower(MarketUser $follower)
//     {
//         $this->followers->add($follower);
//     }

//     public function removeFollower(MarketUser $follower)
//     {
//         $this->followers->removeElement($follower);
//     }

//     /**
//      * @return int
//      */
//     public function getAuthyId():int { return $this->authyId; }

//     /**
//      * @param int $authyId
//      */
//     public function setAuthyId(int $authyId):void
//     {
//         $this->implementChange($this,'authyId', $this->authyId, $authyId);
//     }

//     /**
//      * @param int $int
//      * @return \Exception|void
//      * @throw  \Exception
//      */
//     public function setNotifications(int $int):?\Exception
//     {
//         if(array_key_exists($int, self::NOTIFY)){
//             $this->notifications = $int;
//         }else{
//             return new \Exception("Notifications must be either 1, 2 or 3.");
//         }
//     }

//     /**
//      * @return ArrayCollection|PersistentCollection|null
//      */
//     public function getDiligence():ArrayCollection|PersistentCollection|null { return $this->diligence; }

//     /**
//      * @return ArrayCollection|PersistentCollection|null
//      */
//     public function getFiles(): ArrayCollection|PersistentCollection|null
//     { return $this->files; }

//     /**
//      * @return ArrayCollection|PersistentCollection|null
//      */
//     public function getMarketDeals():ArrayCollection|PersistentCollection|null
//     { return $this->marketDeals; }

//     /**
//      * @return ArrayCollection|PersistentCollection|null
//      */
//     public function getMarketFavorites():ArrayCollection|PersistentCollection|null
//     { return $this->marketFavorites; }

//     /**
//      * @return ArrayCollection|PersistentCollection|null
//      */
//     public function getTemplates():ArrayCollection|PersistentCollection|null
//     { return $this->templates; }

//     public function getMappedTypes():ArrayCollection { return $this->mappedTypes; }

//     /**
//      * @return string
//      */
//     public function getFirstName():string { return $this->firstName; }

//     /**
//      * @return string
//      */
//     public function getLastName():string { return $this->lastName; }

//     /**
//      * @return ?string
//      */
//     public function getSignatureArn():?string { return $this->signature_arn; }

//     public function getIssuer() :Issuer { return $this->issuer; }

//     /**
//      * @return string
//      */
//     public function getImageArn():string { return $this->image_arn; }

//     public function getEmail():string { return $this->email; }

//     public function getNotifications():?string { return $this->notifications; }

//     /**
//      * @return AclRole
//      */
//     public function getRole(): AclRole { return $this->role; }

//     /**
//      * @return ArrayCollection|PersistentCollection|null
//      */
//     public function getMessages():ArrayCollection|PersistentCollection|null { return $this->messages; }

//     /**
//      * @return ArrayCollection|PersistentCollection|null
//      */
//     public function getRatings():ArrayCollection|PersistentCollection|null { return $this->ratings; }

//     /**
//      * @return mixed
//      */
//     public function getRated() { return $this->rated; }

//     public function getAuthyToken():?string { return $this->authyToken; }

//     /**
//      * @return ArrayCollection|PersistentCollection|null
//      */
//     public function getCommunities():ArrayCollection|PersistentCollection|null { return $this->communities; }

//     /**
//      * @return ArrayCollection|PersistentCollection|null
//      */
//     public function getMyCommunities():ArrayCollection|PersistentCollection|null { return $this->myCommunities; }

//     /**
//      * @return string
//      */
//     public function getEmailConfirmHash(): string { return $this->emailConfirmHash; }


//     public function addLogin(LoginLog $login)
//     {
//         $this->logins->add($login);
//         $this->implementChange($this,'logins', $this->logins, $this->logins);
//     }

//     public function getLogins() :ArrayCollection|PersistentCollection|null
//     { return $this->logins; }

//     public function addStip (UserStip $stip)
//     {
//         $this->stips->add($stip);
//         $this->implementChange($this,'stips', $this->stips, $this->stips);
//     }

//     public function getStips() :ArrayCollection|PersistentCollection|null
//     { return $this->stips; }

//     public function getPhone():string
//     { return $this->phone; }

//     public function loginToArray()
//     {
//         return [
//             'id' => $this->getId(),
//             'organization' => $this->getIssuer()->getIssuerName(),
//             'name' => $this->getFirstName() . " " . $this->getLastName(),
//             'picture' => $this->getImageArn(),
//             'username' => $this->getUserName(),
//             'access_token' => $this->getRememberToken(),
//             'authy_token' => $this->getAuthyToken(),
//             'authy_id'  => $this->getAuthyId(),
//             'role' => $this->getRole()->getId()
//         ];
//     }

//     /**
//      * @return ArrayCollection|PersistentCollection|null
//      */
//     public function getContracts():ArrayCollection|PersistentCollection|null { return $this->contracts; }

// }