<?php

namespace App\Entity;

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
use Doctrine\ORM\Mapping\ChangeTrackingPolicy;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="\App\Repository\MarketUser")
 * @ORM\Table(name="MarketUser")
 * @ORM\ChangeTrackingPolicy("NOTIFY")
 * @ORM\HasLifeCycleCallbacks()
 */
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

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected int $id;

    public $incrementing = false;

    /**
     * @ORM\Column(type="string", nullable=false, unique=true)
     * @var string
     */
    protected string $userName='';

    /**
     * @ORM\Column(type="string", nullable=false)
     * @var string
     */
    protected string $firstName='';

    /**
     * @ORM\Column(type="string", nullable=false)
     * @var string
     */
    protected string $lastName='';

    /**
     * @ORM\Column(type="string", nullable=false)
     *@var string
     */
    protected string $image_arn='';

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var ?string
     */
    protected ?string $signature_arn;

    /**
     * @ORM\Column(type="string", nullable=false)
     * @var string
     */
    protected string $companyAddress='';

    /**
     * @ORM\Column(type="string", nullable=false)
     * @var string
     */
    protected string $city='';

    /**
     * @ORM\Column(type="string", nullable=false)
     *@var string
     */
    protected string $zip='';

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\Data\State", inversedBy="users")
     * @var State
     **/
    protected $state;

    /**
     * @ORM\Column(type="string", unique=true, nullable=false)
     * @var string
     */
    protected string $phone='';

    /**
     * @ORM\Column(type="datetime", nullable=true)
     *{"type":"datetime","min":"2010-01-01T00:00:00Z","max":"2020-01-01T00:00:00Z","step":"1"}
     * {"format":"Y-m-d\TH:iP"}
     * @var \DateTime
     */
    protected $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * {"type":"datetime","min":"2010-01-01T00:00:00Z","max":"2020-01-01T00:00:00Z","step":"1"}
     * {"format":"Y-m-d\TH:iP"}
     * @var \DateTime
     */
    protected $updatedAt;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Issuer", inversedBy="users")
     * @var Issuer
     */
    protected $issuer;

    /**
     * @ORM\Column(type="string", unique=true)
     * @var string
     *
     * This doubles as the users uuid
     */
    protected string $emailConfirmHash='';

    /**
     * @ORM\Column(type="string", unique=true)
     * @var string
     */
    protected string $email;

    /**
     * @ORM\Column(type="string", unique=true)
     * @var string
     */
    protected string $phoneConfirmToken='';

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @var ?string
     */
    protected ?string $userSalt;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @var ?int
     */
    protected ?int $notifications;

    /**
     * @ORM\OneToMany(targetEntity="\App\Entity\Deal", mappedBy="user")
     * @var ArrayCollection|PersistentCollection|null
     */
    protected $deals;

    /**
     * @ORM\Column(type="string", nullable=false)
     * @var string
     */
    protected string $password='';

    /**
     * @ORM\OneToMany(targetEntity="\App\Entity\LoginLog", mappedBy="user")
     * @var ArrayCollection|PersistentCollection|null
     */
    protected $logins;

    /**
     * @ORM\OneToMany(targetEntity="\App\Entity\UserStip", mappedBy="user")
     * @var ArrayCollection|PersistentCollection|null
     */
    protected $stips;

    /**
     * @ORM\OneToMany(targetEntity="\App\Entity\Bid", mappedBy="user")
     * @var ArrayCollection|PersistentCollection|null
     */
    protected $bids;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\CommunityInvite", mappedBy="user")
     * @var ArrayCollection|PersistentCollection|null
     */
    protected $communityInvites;

    /**
     * @ORM\OneToMany(targetEntity="\App\Entity\Message", mappedBy="user")
     * @var ArrayCollection|PersistentCollection|null
     */
    protected $messages;

    /**
     * @ORM\ManyToMany(targetEntity="\App\Entity\Message", mappedBy="recipients")
     * @var ArrayCollection|PersistentCollection|null
     */
    protected $receivedMessages;

    /**
     * @ORM\OneToMany(targetEntity="\App\Entity\DocAccess", mappedBy="user")
     * @var ArrayCollection|PersistentCollection|null
     */
    protected $documents;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\AclRole", inversedBy="users")
     * @var AclRole
     */
    protected $role;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\UserStatus", inversedBy="users")
     * @var UserStatus
     */
    protected $status;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\FailedLogin", inversedBy="users")
     * @var FailedLogin
     */
    protected $failedAttempts;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Speciality", mappedBy="users")
     * @var Speciality
     */
    protected $specialities;

    /**
     * @ORM\Column(type="bigint", nullable=false, unique=true)
     * @var int
     */
    protected int $authyId = 0;

    /**
     * @ORM\Column(type="decimal", precision=14, scale=2, nullable=false)
     * @var float
     */
    protected float $closedVolume = 0;

    /**
     * @ORM\Column(type="decimal", precision=14, scale=2, nullable=false)
     * @var float
     */
    protected float $dealVolume = 0;

    /**
     * @ORM\OneToMany(targetEntity="\App\Entity\Rating", mappedBy="user")
     * @var ArrayCollection|PersistentCollection|null
     **/
    protected $ratings;

    /**
     * @ORM\ManyToMany(targetEntity="\App\Entity\Community", mappedBy="users")
     * @var ArrayCollection|PersistentCollection|null
     */
    protected $communities;

    /**
     * @ORM\OneToMany(targetEntity="\App\Entity\Community", mappedBy="owner")
     * @var ArrayCollection|PersistentCollection|null
     */
    protected $myCommunities;

    /**
     * @ORM\OneToMany(targetEntity="\App\Entity\Rating", mappedBy="rater")
     * @var ArrayCollection|PersistentCollection|null
     **/
    protected $rated;

    /**
     * @ORM\ManyToMany(targetEntity="\App\Entity\MarketUser")
     * @ORM\JoinTable(name="followers",
     *     joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="follower_id", referencedColumnName="id")}
     *     )
     * @var ArrayCollection|PersistentCollection|null
     **/
    protected $followers;

    /**
     * @ORM\ManyToMany(targetEntity="\App\Entity\MarketUser")
     * @ORM\JoinTable(name="following",
     *     joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="following_id", referencedColumnName="id")}
     *     )
     * @var ArrayCollection|PersistentCollection|null
     **/
    protected $following;

    /**
     * @ORM\OneToMany(targetEntity="\App\Entity\DealFile", mappedBy="user")
     * @var ArrayCollection|PersistentCollection|null
     */
    protected $files;

    /**
     * @ORM\ManyToMany(targetEntity="\App\Entity\Deal", inversedBy="userFavorites")
     * @ORM\JoinTable(name="user_favorite_deals",
     *     joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="favorite_deal_id", referencedColumnName="id")}
     *     )
     * @var ArrayCollection|PersistentCollection|null
     */
    protected $marketFavorites;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @var ?string
     */
    protected ?string $token;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @var ?string
     */
    protected ?string $authyToken;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @var ?string
     */
    protected ?string $rememberToken;

    /**
     * @ORM\ManyToMany(targetEntity="\App\Entity\Deal", inversedBy="marketUsers")
     * @var ArrayCollection|PersistentCollection|null
     */
    protected $marketDeals;

    /**
     * @ORM\ManyToMany(targetEntity="\App\Entity\Loan\SaleAttribute", mappedBy="buyers")
     * @var ArrayCollection|PersistentCollection|null
     */
    protected $boughtLoans;

    /**
     * @ORM\OneToMany(targetEntity="\App\Entity\DueDiligence", mappedBy="user")
     * @var ArrayCollection|PersistentCollection|null
     */
    protected $diligence;

    /**
     * @ORM\OneToMany(targetEntity="\App\Entity\LoanTapeTemplate", mappedBy="user")
     * @var  ArrayCollection|PersistentCollection|null
     * */
    protected $templates;

    /**
     * @ORM\OneToMany(targetEntity="\App\Entity\Chat", mappedBy="user")
     * @var ArrayCollection|PersistentCollection|null
     */
    protected $chats;

    /**
     * @ORM\OneToMany(targetEntity="\App\Entity\Chat", mappedBy="recipient")
     * @var MarketUser
     */
    protected $chatRecipient;

    /**
     * @ORM\OneToMany(targetEntity="\App\Entity\GroupChat", mappedBy="user")
     * @var ArrayCollection|PersistentCollection|null
     */
    protected $groupChats;

    /**
     * @ORM\ManyToMany(targetEntity="\App\Entity\GroupChat", mappedBy="members")
     * @var ArrayCollection|PersistentCollection|null
     */
    protected $chatGroupMemberships;

    /**
     * @var  ArrayCollection
     * */
    protected $mappedTypes;

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
     * @throws \Exception
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
     * @throws \Exception
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
     * @return \Exception|void
     * @throw  \Exception
     */
    public function setNotifications(int $int):?\Exception
    {
        if(array_key_exists($int, self::NOTIFY)){
            $this->notifications = $int;
        }else{
            return new \Exception("Notifications must be either 1, 2 or 3.");
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

}