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
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\OneToOne;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\ManyToMany;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\JoinColumns;
use Doctrine\ORM\Mapping\JoinTable;
use Doctrine\ORM\Mapping\GeneratedValue;

use Doctrine\ORM\Mapping\DiscriminatorColumn;
use Doctrine\ORM\Mapping\DiscriminatorMap;

use Doctrine\ORM\Mapping\Index;
use Doctrine\ORM\Mapping\ChangeTrackingPolicy;

use Doctrine\ORM\Mapping as ORM;

/**
 * \Doctrine\ORM\Mapping\Entity(repositoryClass="\App\Repository\MarketUser")
 * \Doctrine\ORM\Mapping\Table(name="MarketUser")
 * \Doctrine\ORM\Mapping\ChangeTrackingPolicy("NOTIFY")
 * \Doctrine\ORM\Mapping\HasLifeCycleCallbacks
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
     * \Doctrine\ORM\Mapping\Id
     * \Doctrine\ORM\Mapping\GeneratedValue(strategy="AUTO")
     * \Doctrine\ORM\Mapping\Column(type="integer")
     */
    protected int $id;

    public $incrementing = false;

    /**
     * \Doctrine\ORM\Mapping\Column(type="string", nullable=false, unique=true)
     * @var string
     */
    protected string $userName='';

    /**
     * \Doctrine\ORM\Mapping\Column(type="string", nullable=false)
     * @var string
     */
    protected string $firstName='';

    /**
     * \Doctrine\ORM\Mapping\Column(type="string", nullable=false)
     * @var string
     */
    protected string $lastName='';

    /**
     * \Doctrine\ORM\Mapping\Column(type="string", nullable=false)
     *@var string
     */
    protected string $image_arn='';

    /**
     * \Doctrine\ORM\Mapping\Column(type="string", nullable=true)
     * @var ?string
     */
    protected ?string $signature_arn;

    /**
     * \Doctrine\ORM\Mapping\Column(type="string", nullable=false)
     * @var string
     */
    protected string $companyAddress='';

    /**
     * \Doctrine\ORM\Mapping\Column(type="string", nullable=false)
     * @var string
     */
    protected string $city='';

    /**
     * \Doctrine\ORM\Mapping\Column(type="string", nullable=false)
     *@var string
     */
    protected string $zip='';

    /**
     * \Doctrine\ORM\Mapping\ManyToOne(targetEntity="\App\Entity\Data\State", inversedBy="users")
     * @var State
     **/
    protected $state;

    /**
     * \Doctrine\ORM\Mapping\Column(type="string", unique=true, nullable=false)
     * @var string
     */
    protected string $phone='';

    /**
     * \Doctrine\ORM\Mapping\Column(type="datetime", nullable=true)
     *{"type":"datetime","min":"2010-01-01T00:00:00Z","max":"2020-01-01T00:00:00Z","step":"1"}
     * {"format":"Y-m-d\TH:iP"}
     * @var \DateTime
     */
    protected $createdAt;

    /**
     * \Doctrine\ORM\Mapping\Column(type="datetime", nullable=true)
     * {"type":"datetime","min":"2010-01-01T00:00:00Z","max":"2020-01-01T00:00:00Z","step":"1"}
     * {"format":"Y-m-d\TH:iP"}
     * @var \DateTime
     */
    protected $updatedAt;

    /**
     * \Doctrine\ORM\Mapping\ManyToOne(targetEntity="App\Entity\Issuer", inversedBy="users")
     * @var Issuer
     */
    protected $issuer;

    /**
     * \Doctrine\ORM\Mapping\Column(type="string", unique=true)
     * @var string
     *
     * This doubles as the users uuid
     */
    protected string $emailConfirmHash='';

    /**
     * \Doctrine\ORM\Mapping\Column(type="string", unique=true)
     * @var string
     */
    protected string $email;

    /**
     * \Doctrine\ORM\Mapping\Column(type="string", unique=true)
     * @var string
     */
    protected string $phoneConfirmToken='';

    /**
     * \Doctrine\ORM\Mapping\Column(type="string", length=255, nullable=true)
     * @var ?string
     */
    protected ?string $userSalt;

    /**
     * \Doctrine\ORM\Mapping\Column(type="integer", nullable=true)
     * @var ?int
     */
    protected ?int $notifications;

    /**
     * \Doctrine\ORM\Mapping\OneToMany(targetEntity="\App\Entity\Deal", mappedBy="user")
     * @var ArrayCollection|PersistentCollection|null
     */
    protected $deals;

    /**
     * \Doctrine\ORM\Mapping\Column(type="string", , nullable=false)
     * @var string
     */
    protected string $password='';

    /**
     * \Doctrine\ORM\Mapping\OneToMany(targetEntity="\App\Entity\LoginLog", mappedBy="user")
     * @var ArrayCollection|PersistentCollection|null
     */
    protected $logins;

    /**
     * \Doctrine\ORM\Mapping\OneToMany(targetEntity="\App\Entity\UserStip", mappedBy="user")
     * @var ArrayCollection|PersistentCollection|null
     */
    protected $stips;

    /**
     * \Doctrine\ORM\Mapping\OneToMany(targetEntity="\App\Entity\Bid", mappedBy="user")
     * @var ArrayCollection|PersistentCollection|null
     */
    protected $bids;

    /**
     * \Doctrine\ORM\Mapping\OneToMany(targetEntity="App\Entity\CommunityInvite", mappedBy="user")
     * @var ArrayCollection|PersistentCollection|null
     */
    protected $communityInvites;

    /**
     * \Doctrine\ORM\Mapping\OneToMany(targetEntity="\App\Entity\Message", mappedBy="user")
     * @var ArrayCollection|PersistentCollection|null
     */
    protected $messages;

    /**
     * \Doctrine\ORM\Mapping\ManyToMany(targetEntity="\App\Entity\Message", mappedBy="recipients")
     * @var ArrayCollection|PersistentCollection|null
     */
    protected $receivedMessages;

    /**
     * \Doctrine\ORM\Mapping\OneToMany(targetEntity="\App\Entity\DocAccess", mappedBy="user")
     * @var ArrayCollection|PersistentCollection|null
     */
    protected $documents;

    /**
     * \Doctrine\ORM\Mapping\ManyToOne(targetEntity="\App\Entity\AclRole", inversedBy="users")
     * @var AclRole
     */
    protected $role;

    /**
     * \Doctrine\ORM\Mapping\ManyToOne(targetEntity="\App\Entity\UserStatus", inversedBy="users")
     * @var UserStatus
     */
    protected $status;

    /**
     * \Doctrine\ORM\Mapping\ManyToOne(targetEntity="\App\Entity\FailedLogin", inversedBy="users")
     * @var FailedLogin
     */
    protected $failedAttempts;

    /**
     * \Doctrine\ORM\Mapping\ManyToMany(targetEntity="App\Entity\Speciality", mappedBy="users")
     * @var Speciality
     */
    protected $specialities;

    /**
     * \Doctrine\ORM\Mapping\Column(type="bigint", nullable=false, unique=true)
     * @var int
     */
    protected int $authyId = 0;

    /**
     * \Doctrine\ORM\Mapping\Column(type="decimal", precision=14, scale=2, nullable=false)
     * @var float
     */
    protected float $closedVolume = 0;

    /**
     * \Doctrine\ORM\Mapping\Column(type="decimal", precision=14, scale=2, nullable=false)
     * @var float
     */
    protected float $dealVolume = 0;

    /**
     * \Doctrine\ORM\Mapping\OneToMany(targetEntity="\App\Entity\Rating", mappedBy="user")
     * @var ArrayCollection|PersistentCollection|null
     **/
    protected $ratings;

    /**
     * \Doctrine\ORM\Mapping\ManyToMany(targetEntity="\App\Entity\Community", mappedBy="users")
     * @var ArrayCollection|PersistentCollection|null
     */
    protected $communities;

    /**
     * \Doctrine\ORM\Mapping\OneToMany(targetEntity="\App\Entity\Community", mappedBy="owner")
     * @var ArrayCollection|PersistentCollection|null
     */
    protected $myCommunities;

    /**
     * \Doctrine\ORM\Mapping\OneToMany(targetEntity="\App\Entity\Rating", mappedBy="rater")
     * @var ArrayCollection|PersistentCollection|null
     **/
    protected $rated;

    /**
     * \Doctrine\ORM\Mapping\ManyToMany(targetEntity="\App\Entity\MarketUser")
     * \Doctrine\ORM\Mapping\JoinTable(name="followers",
     *     joinColumns={\Doctrine\ORM\Mapping\JoinColumn(name="user_id", referencedColumnName="id")},
     *     inverseJoinColumns={\Doctrine\ORM\Mapping\JoinColumn(name="follower_id", referencedColumnName="id")}
     *     )
     * @var ArrayCollection|PersistentCollection|null
     **/
    protected $followers;

    /**
     * \Doctrine\ORM\Mapping\ManyToMany(targetEntity="\App\Entity\MarketUser")
     * \Doctrine\ORM\Mapping\JoinTable(name="following",
     *     joinColumns={\Doctrine\ORM\Mapping\JoinColumn(name="user_id", referencedColumnName="id")},
     *     inverseJoinColumns={\Doctrine\ORM\Mapping\JoinColumn(name="following_id", referencedColumnName="id")}
     *     )
     * @var ArrayCollection|PersistentCollection|null
     **/
    protected $following;

    /**
     * \Doctrine\ORM\Mapping\OneToMany(targetEntity="\App\Entity\DealFile", mappedBy="user")
     * @var ArrayCollection|PersistentCollection|null
     */
    protected $files;

    /**
     * \Doctrine\ORM\Mapping\ManyToMany(targetEntity="\App\Entity\Deal", inversedBy="userFavorites")
     * \Doctrine\ORM\Mapping\JoinTable(name="user_favorite_deals",
     *     joinColumns={\Doctrine\ORM\Mapping\JoinColumn(name="user_id", referencedColumnName="id")},
     *     inverseJoinColumns={\Doctrine\ORM\Mapping\JoinColumn(name="favorite_deal_id", referencedColumnName="id")}
     *     )
     * @var ArrayCollection|PersistentCollection|null
     */
    protected $marketFavorites;

    /**
     * \Doctrine\ORM\Mapping\Column(type="text", nullable=true)
     * @var ?string
     */
    protected ?string $token;

    /**
     * \Doctrine\ORM\Mapping\Column(type="text", nullable=true)
     * @var ?string
     */
    protected ?string $authyToken;

    /**
     * \Doctrine\ORM\Mapping\Column(type="text", nullable=true)
     * @var ?string
     */
    protected ?string $rememberToken;

    /**
     * \Doctrine\ORM\Mapping\ManyToMany(targetEntity="\App\Entity\Deal", inversedBy="marketUsers")
     * @var ArrayCollection|PersistentCollection|null
     */
    protected $marketDeals;

    /**
     * \Doctrine\ORM\Mapping\ManyToMany(targetEntity="\App\Entity\Loan\SaleAttribute", mappedBy="buyers")
     * @var ArrayCollection|PersistentCollection|null
     */
    protected $boughtLoans;

    /**
     * \Doctrine\ORM\Mapping\OneToMany(targetEntity="\App\Entity\DueDiligence", mappedBy="user")
     * @var ArrayCollection|PersistentCollection|null
     */
    protected $diligence;

    /**
     * \Doctrine\ORM\Mapping\OneToMany(targetEntity="\App\Entity\LoanTapeTemplate", mappedBy="user")
     * @var  ArrayCollection|PersistentCollection|null
     * */
    protected $templates;

    /**
     * \Doctrine\ORM\Mapping\OneToMany(targetEntity="\App\Entity\Chat", mappedBy="user")
     * @var ArrayCollection|PersistentCollection|null
     */
    protected $chats;

    /**
     * \Doctrine\ORM\Mapping\OneToMany(targetEntity="\App\Entity\Chat", mappedBy="recipient")
     * @var MarketUser
     */
    protected $chatRecipient;

    /**
     * \Doctrine\ORM\Mapping\OneToMany(targetEntity="\App\Entity\GroupChat", mappedBy="user")
     * @var ArrayCollection|PersistentCollection|null
     */
    protected $groupChats;

    /**
     * \Doctrine\ORM\Mapping\ManyToMany(targetEntity="\App\Entity\GroupChat", mappedBy="members")
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