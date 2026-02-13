<?php

namespace App\Entity;

use \App\Entity\Bid;
use \App\Entity\Message;
use \App\Entity\DocAccess;
use \App\Entity\DealFile;
use \App\Entity\Loan\SaleAttribute;
use \App\Entity\Chat;
use \App\Entity\GroupChat;
use \App\Entity\DealContract;
use Exception;
use DateTime;
use App\Entity\Data\State;
use App\Service\CreatePropertiesArrayTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\PersistentCollection;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticableContracts;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContracts;
//use LaravelDoctrine\Extensions\Timestamps\Timestamps;
use LaravelDoctrine\ORM\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notification;
 
use Doctrine\ORM\Mapping\HasLifecycleCallbacks as HasLifecycleCallbacks;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'MarketUser')]
#[ORM\Entity(repositoryClass: \App\Repository\MarketUser::class)]
 
#[HasLifecycleCallbacks]
class MarketUser
    extends DomainObject
    implements AuthenticableContracts, CanResetPasswordContracts, JWTSubject
{
    use CreatePropertiesArrayTrait, Authenticatable, CanResetPassword, Notifiable;

    const ASAP = 'asap';

    const DAILY = 'daily';

    const NOTIFY_OFF = 'off';//this is just to reflect the update of the composer for plugin_entity

    const NOTIFY =[
        1 => self::ASAP,
        2 => self::DAILY,
        3 => self::NOTIFY_OFF
    ];

    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    #[ORM\Column(type: 'integer')]
    protected int $id;

    public $incrementing = false;

    /**
     * @var string
     */
    #[ORM\Column(type: 'string', nullable: false, unique: true)]
    protected string $userName='';

    /**
     * @var string
     */
    #[ORM\Column(type: 'string', nullable: false)]
    protected string $firstName='';

    /**
     * @var string
     */
    #[ORM\Column(type: 'string', nullable: false)]
    protected string $lastName='';

    /**
     *@var string
     */
    #[ORM\Column(type: 'string', nullable: false)]
    protected string $image_arn='';

    /**
     * @var ?string
     */
    #[ORM\Column(type: 'string', nullable: true)]
    protected ?string $signature_arn;

    /**
     * @var string
     */
    #[ORM\Column(type: 'string', nullable: false)]
    protected string $companyAddress='';

    /**
     * @var string
     */
    #[ORM\Column(type: 'string', nullable: false)]
    protected string $city='';

    /**
     *@var string
     */
    #[ORM\Column(type: 'string', nullable: false)]
    protected string $zip='';

    /**
     * @var State
     **/
    #[ORM\ManyToOne(targetEntity: State::class, inversedBy: 'users')]
    protected $state;

    /**
     * @var string
     */
    #[ORM\Column(type: 'string', unique: true, nullable: false)]
    protected string $phone='';

    /**
     * @var DateTime
     */
    #[ORM\Column(type: 'datetime', nullable: true)]
    protected $createdAt;

    /**
     * @var DateTime
     */
    #[ORM\Column(type: 'datetime', nullable: true)]
    protected $updatedAt;

    /**
     * @var Issuer
     */
    #[ORM\ManyToOne(targetEntity: Issuer::class, inversedBy: 'users')]
    protected $issuer;

    /**
     * @var string
     *
     * This doubles as the users uuid
     */
    #[ORM\Column(type: 'string', unique: true)]
    protected string $emailConfirmHash='';

    /**
     * @var string
     */
    #[ORM\Column(type: 'string', unique: true)]
    protected string $email;

    /**
     * @var string
     */
    #[ORM\Column(type: 'string', unique: true)]
    protected string $phoneConfirmToken='';

    /**
     * @var ?string
     */
    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    protected ?string $userSalt;

    /**
     * @var ?int
     */
    #[ORM\Column(type: 'integer', nullable: true)]
    protected ?int $notifications;

    /**
     * @var ArrayCollection|PersistentCollection|null
     */
    #[ORM\OneToMany(targetEntity: Deal::class, mappedBy: 'user')]
    protected $deals;

    /**
     * @var string
     */
    #[ORM\Column(type: 'string', nullable: false)]
    protected string $password='';

    /**
     * @var ArrayCollection|PersistentCollection|null
     */
    #[ORM\OneToMany(targetEntity: LoginLog::class, mappedBy: 'user')]
    protected $logins;

    /**
     * @var ArrayCollection|PersistentCollection|null
     */
    #[ORM\OneToMany(targetEntity: UserStip::class, mappedBy: 'user')]
    protected $stips;

    /**
     * @var ArrayCollection|PersistentCollection|null
     */
    #[ORM\OneToMany(targetEntity: Bid::class, mappedBy: 'user')]
    protected $bids;

    /**
     * @var ArrayCollection|PersistentCollection|null
     */
    #[ORM\OneToMany(targetEntity: CommunityInvite::class, mappedBy: 'user')]
    protected $communityInvites;

    /**
     * @var ArrayCollection|PersistentCollection|null
     */
    #[ORM\OneToMany(targetEntity: Message::class, mappedBy: 'user')]
    protected $messages;

    /**
     * @var ArrayCollection|PersistentCollection|null
     */
    #[ORM\ManyToMany(targetEntity: Message::class, mappedBy: 'recipients')]
    protected $receivedMessages;

    /**
     * @var ArrayCollection|PersistentCollection|null
     */
    #[ORM\OneToMany(targetEntity: DocAccess::class, mappedBy: 'user')]
    protected $documents;

    /**
     * @var AclRole
     */
    #[ORM\ManyToOne(targetEntity: AclRole::class, inversedBy: 'users')]
    protected $role;

    /**
     * @var UserStatus
     */
    #[ORM\ManyToOne(targetEntity: UserStatus::class, inversedBy: 'users')]
    protected $status;

    /**
     * @var FailedLogin
     */
    #[ORM\ManyToOne(targetEntity: FailedLogin::class, inversedBy: 'users')]
    protected $failedAttempts;

    /**
     * @var Speciality
     */
    #[ORM\ManyToMany(targetEntity: Speciality::class, mappedBy: 'users')]
    protected $specialities;

    /**
     * @var int
     */
    #[ORM\Column(type: 'bigint', nullable: false, unique: true)]
    protected int $authyId = 0;

    /**
     * @var float
     */
    #[ORM\Column(type: 'float', precision: 14, scale: 2, nullable: false)]
    protected float $closedVolume = 0;

    /**
     * @var float
     */
    #[ORM\Column(type: 'float', precision: 14, scale: 2, nullable: false)]
    protected float $dealVolume = 0;

    /**
     * @var ArrayCollection|PersistentCollection|null
     **/
    #[ORM\OneToMany(targetEntity: Rating::class, mappedBy: 'user')]
    protected $ratings;

    /**
     * @var ArrayCollection|PersistentCollection|null
     */
    #[ORM\ManyToMany(targetEntity: Community::class, mappedBy: 'users')]
    protected $communities;

    /**
     * @var ArrayCollection|PersistentCollection|null
     */
    #[ORM\OneToMany(targetEntity: Community::class, mappedBy: 'owner')]
    protected $myCommunities;

    /**
     * @var ArrayCollection|PersistentCollection|null
     **/
    #[ORM\OneToMany(targetEntity: Rating::class, mappedBy: 'rater')]
    protected $rated;

    /**
     * @var ArrayCollection|PersistentCollection|null
     **/
    #[ORM\JoinTable(name: 'followers')]
    #[ORM\JoinColumn(name: 'user_id', referencedColumnName: 'id')]
    #[ORM\InverseJoinColumn(name: 'follower_id', referencedColumnName: 'id')]
    #[ORM\ManyToMany(targetEntity: MarketUser::class)]
    protected $followers;

    /**
     * @var ArrayCollection|PersistentCollection|null
     **/
    #[ORM\JoinTable(name: 'following')]
    #[ORM\JoinColumn(name: 'user_id', referencedColumnName: 'id')]
    #[ORM\InverseJoinColumn(name: 'following_id', referencedColumnName: 'id')]
    #[ORM\ManyToMany(targetEntity: MarketUser::class)]
    protected $following;

    /**
     * @var ArrayCollection|PersistentCollection|null
     */
    #[ORM\OneToMany(targetEntity: DealFile::class, mappedBy: 'user')]
    protected $files;

    /**
     * @var ArrayCollection|PersistentCollection|null
     */
    #[ORM\JoinTable(name: 'user_favorite_deals')]
    #[ORM\JoinColumn(name: 'user_id', referencedColumnName: 'id')]
    #[ORM\InverseJoinColumn(name: 'favorite_deal_id', referencedColumnName: 'id')]
    #[ORM\ManyToMany(targetEntity: Deal::class, inversedBy: 'userFavorites')]
    protected $marketFavorites;

    /**
     * @var ?string
     */
    #[ORM\Column(type: 'text', nullable: true)]
    protected ?string $token;

    /**
     * @var ?string
     */
    #[ORM\Column(type: 'text', nullable: true)]
    protected ?string $authyToken;

    /**
     * @var ?string
     */
    #[ORM\Column(type: 'text', nullable: true)]
    protected ?string $rememberToken;

    /**
     * @var ArrayCollection|PersistentCollection|null
     */
    #[ORM\ManyToMany(targetEntity: Deal::class, inversedBy: 'marketUsers')]
    protected $marketDeals;

    /**
     * @var ArrayCollection|PersistentCollection|null
     */
    #[ORM\ManyToMany(targetEntity: SaleAttribute::class, mappedBy: 'buyers')]
    protected $boughtLoans;

    /**
     * @var ArrayCollection|PersistentCollection|null
     */
    #[ORM\OneToMany(targetEntity: DueDiligence::class, mappedBy: 'user')]
    protected $diligence;

    /**
     * @var  ArrayCollection|PersistentCollection|null
     * */
    #[ORM\OneToMany(targetEntity: LoanTapeTemplate::class, mappedBy: 'user')]
    protected $templates;

    /**
     * @var ArrayCollection|PersistentCollection|null
     */
    #[ORM\OneToMany(targetEntity: Chat::class, mappedBy: 'user')]
    protected $chats;

    /**
     * @var MarketUser
     */
    #[ORM\OneToMany(targetEntity: Chat::class, mappedBy: 'recipient')]
    protected $chatRecipient;

    /**
     * @var ArrayCollection|PersistentCollection|null
     */
    #[ORM\OneToMany(targetEntity: GroupChat::class, mappedBy: 'user')]
    protected $groupChats;

    /**
     * @var ArrayCollection|PersistentCollection|null
     */
    #[ORM\ManyToMany(targetEntity: GroupChat::class, mappedBy: 'members')]
    protected $chatGroupMemberships;

    /**
     * @var  ArrayCollection
     * */
    protected $mappedTypes;

    /**
     * @var ArrayCollection|PersistentCollection|null
     */
    #[ORM\OneToMany(targetEntity: DealContract::class, mappedBy: 'buyer')]
    protected $contracts;

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

    public function routeNotificationForSlack(Notification $notification):string {
        return env('SLACK_HOOK_NOTIFY');
    }

    /**
     * @return int
     */
    public  function getJWTIdentifier()
    {
        return $this->getId();
    }

    /**
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function setPasswordAttribute($password)
    {
        if(!empty($password)){
            $this->password = bcrypt($password);
        }
    }

    function addMarketDeal(Deal $deal)
    {
        $this->marketDeals->add($deal);
    }

    function addMarketFavorites(Deal $deal){ $this->marketFavorites->add($deal); }

    /**
     * @param Deal $deal
     */
    function removeDealFromMarketFavorites(Deal $deal)
    {
        if (! $this->marketFavorites->contains($deal))
            return;
        $this->marketFavorites->removeElement($deal);
        $deal->removeUserFromUserFavorites($this);
    }

    function addMappedType(MappedUserType $type){
        $this->mappedTypes->add($type);
    }

    function addUserCommunity(Community $community){
        $this->communities->add($community);
    }

    function removeCommunity(Community $community)
    {
        if (! $this->communities->contains($community))
            return;
        $this->communities->removeElement($community);
        $community->removeUserFromCommunity($this);
    }

    function addUserToMyCommunity(Community $community, MarketUser $user)
    {
        if(! $this->myCommunities->contains($community)
            || $community->getUsers()->contains($user))
            return;
        $community->addUserToCommunity($user);
    }

    function removeUserFromMyCommunity(Community $community, $user)
    {
        if(!$this->myCommunities->contains($community) ||
            !$community->getUsers()->contains($user))
            return;
        $community->removeUserFromCommunity($user);
    }

    /**
     * @return int
     */
    public function getId():int { return $this->id; }

    /**
     * @return string
     */
    public function getUserName():string { return $this->userName; }

    function addDiligence(DueDiligence $diligence)
    {
        $this->diligence->add($diligence);
    }

    function addTemplate(LoanTapeTemplate $template)
    {
        $this->templates->add($template);
    }

    function addRated(Rating  $rating){
        $this->rated->add($rating);
    }

    function addRatings(Rating $rating){
        $this->ratings->add($rating);
    }

    /**
     * @return string
     */
    public function getAuthPassword(): string
    { return $this->password; }

    public function getAuthIdentifierName():string { return 'userName'; }

    /**
     * @return string
     */
    public function getAuthIdentifier():string { return $this->userName; }

    public function getRememberTokenName():string { return 'rememberToken'; }

    public function getRememberToken():string { return $this->rememberToken; }

    public function setRememberToken($value)
    {
        $this->rememberToken = $value;
    }

    /**
     * @param mixed $password
     */
    public function setAuthPassword(mixed $password) { $this->password = $password; }

    public function setAuthyToken ($authyToken) { $this->authyToken = $authyToken; }

    /**
     * @return ?string
     */
    public function getUserSalt():?string { return $this->userSalt; }

    /**
     * @return UserStatus
     */
    public function getStatus():UserStatus { return $this->status; }

    /**
     * @param $status UserStatus
     * @throws Exception
     */
    public function setStatus(UserStatus $status):void
    {
        $this->implementChange($this,'status', $this->status, $status);
    }

    public function setIssuer(Issuer $issuer) { $this->issuer =  $issuer; }

    /**
     * @return FailedLogin
     */
    public function getFailedAttempts(): FailedLogin { return $this->failedAttempts; }

    /**
     * @param $failedAttempts
     * @throws Exception
     */
    public function setFailedAttempts(FailedLogin $failedAttempts)
    {
        $this->implementChange($this,'failedAttempts', $this->failedAttempts, $failedAttempts);
    }

    public function addFollower(MarketUser $follower)
    {
        $this->followers->add($follower);
    }

    public function removeFollower(MarketUser $follower)
    {
        $this->followers->removeElement($follower);
    }

    /**
     * @return int
     */
    public function getAuthyId():int { return $this->authyId; }

    /**
     * @param int $authyId
     */
    public function setAuthyId(int $authyId):void
    {
        $this->implementChange($this,'authyId', $this->authyId, $authyId);
    }

    /**
     * @param int $int
     * @return Exception|void
     * @throw  \Exception
     */
    public function setNotifications(int $int):?Exception
    {
        if(array_key_exists($int, self::NOTIFY)){
            $this->notifications = $int;
            return null;
        }else{
            return new Exception("Notifications must be either 1, 2 or 3.");
        }
    }

    /**
     * @return ArrayCollection|PersistentCollection|null
     */
    public function getDiligence():ArrayCollection|PersistentCollection|null { return $this->diligence; }

    /**
     * @return ArrayCollection|PersistentCollection|null
     */
    public function getFiles(): ArrayCollection|PersistentCollection|null
    { return $this->files; }

    /**
     * @return ArrayCollection|PersistentCollection|null
     */
    public function getMarketDeals():ArrayCollection|PersistentCollection|null
    { return $this->marketDeals; }

    /**
     * @return ArrayCollection|PersistentCollection|null
     */
    public function getMarketFavorites():ArrayCollection|PersistentCollection|null
    { return $this->marketFavorites; }

    /**
     * @return ArrayCollection|PersistentCollection|null
     */
    public function getTemplates():ArrayCollection|PersistentCollection|null
    { return $this->templates; }

    public function getMappedTypes():ArrayCollection { return $this->mappedTypes; }

    /**
     * @return string
     */
    public function getFirstName():string { return $this->firstName; }

    /**
     * @return string
     */
    public function getLastName():string { return $this->lastName; }

    /**
     * @return ?string
     */
    public function getSignatureArn():?string { return $this->signature_arn; }

    public function getIssuer() :Issuer { return $this->issuer; }

    /**
     * @return string
     */
    public function getImageArn():string { return $this->image_arn; }

    public function getEmail():string { return $this->email; }

    public function getNotifications():?string { return $this->notifications; }

    /**
     * @return AclRole
     */
    public function getRole(): AclRole { return $this->role; }

    /**
     * @return ArrayCollection|PersistentCollection|null
     */
    public function getMessages():ArrayCollection|PersistentCollection|null { return $this->messages; }

    /**
     * @return ArrayCollection|PersistentCollection|null
     */
    public function getRatings():ArrayCollection|PersistentCollection|null { return $this->ratings; }

    /**
     * @return mixed
     */
    public function getRated() { return $this->rated; }

    public function getAuthyToken():?string { return $this->authyToken; }

    /**
     * @return ArrayCollection|PersistentCollection|null
     */
    public function getCommunities():ArrayCollection|PersistentCollection|null { return $this->communities; }

    /**
     * @return ArrayCollection|PersistentCollection|null
     */
    public function getMyCommunities():ArrayCollection|PersistentCollection|null { return $this->myCommunities; }

    /**
     * @return string
     */
    public function getEmailConfirmHash(): string { return $this->emailConfirmHash; }


    public function addLogin(LoginLog $login)
    {
        $this->logins->add($login);
        $this->implementChange($this,'logins', $this->logins, $this->logins);
    }

    public function getLogins() :ArrayCollection|PersistentCollection|null
    { return $this->logins; }

    public function addStip (UserStip $stip)
    {
        $this->stips->add($stip);
        $this->implementChange($this,'stips', $this->stips, $this->stips);
    }

    public function getStips() :ArrayCollection|PersistentCollection|null
    { return $this->stips; }

    public function getPhone():string
    { return $this->phone; }

    public function loginToArray()
    {
        return [
            'id' => $this->getId(),
            'organization' => $this->getIssuer()->getIssuerName(),
            'name' => $this->getFirstName() . " " . $this->getLastName(),
            'picture' => $this->getImageArn(),
            'username' => $this->getUserName(),
            'access_token' => $this->getRememberToken(),
            'authy_token' => $this->getAuthyToken(),
            'authy_id'  => $this->getAuthyId(),
            'role' => $this->getRole()->getId()
        ];
    }

    /**
     * @return ArrayCollection|PersistentCollection|null
     */
    public function getContracts():ArrayCollection|PersistentCollection|null { return $this->contracts; }

}