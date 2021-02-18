<?php

namespace App\Entity;

use App\Service\CreatePropertiesArrayTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\PersistentCollection;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticableContracts;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContracts;
use LaravelDoctrine\Extensions\Timestamps\Timestamps;
use LaravelDoctrine\ORM\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Doctrine\ORM\Mapping\ChangeTrackingPolicy;

/**
 * @ORM\Entity(repositoryClass="\App\Repository\MarketUser")
 * @ORM\Table(name="MarketUser")
 * @ChangeTrackingPolicy("NOTIFY")
 * @ORM\HasLifeCycleCallbacks
 */
class MarketUser
    extends DomainObject
    implements AuthenticableContracts, CanResetPasswordContracts, JWTSubject
{
    use CreatePropertiesArrayTrait, Authenticatable, CanResetPassword, Notifiable;

    const ASAP = 'asap';

    const DAILY = 'daily';

    const NOTIFY_OFF = 'off';

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
    protected $id;

    public $incrementing = false;

    /**
     * @ORM\Column(type="string", nullable=false, unique=true)
     */
    protected $userName;

    /**
     * @ORM\Column(type="string", nullable=false)
     */
    protected $firstName;

    /**
     * @ORM\Column(type="string", nullable=false)
     */
    protected $lastName;

    /** @ORM\Column(type="string", nullable=false) */
    protected $image_arn;

    /** @ORM\Column(type="string", nullable=true) */
    protected $signature_arn;

    /**
     * @ORM\Column(type="string", nullable=false)
     */
    protected $companyAddress;

    /**
     * @ORM\Column(type="string", nullable=false)
     */
    protected $city;

    /** @ORM\Column(type="string", nullable=false) */
    protected $zip;

    /** @ORM\ManyToOne(targetEntity="\App\Entity\Data\State", inversedBy="users")
     * @var \App\Entity\Data\State
     **/
    protected $state;

    /** @ORM\Column(type="string", unique=true), nullable=false */
    protected $phone;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     *{"type":"datetime","min":"2010-01-01T00:00:00Z","max":"2020-01-01T00:00:00Z","step":"1"}
     * {"format":"Y-m-d\TH:iP"}
     */
    protected $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * {"type":"datetime","min":"2010-01-01T00:00:00Z","max":"2020-01-01T00:00:00Z","step":"1"}
     * {"format":"Y-m-d\TH:iP"}
     */
    protected $updatedAt;

    /** @ORM\ManyToOne(targetEntity="App\Entity\Issuer", inversedBy="users")   */
    protected $issuer;

    /** @ORM\Column(type="string", unique=true)   */
    protected $emailConfirmHash;

    /**
     * @ORM\Column(type="string", unique=true)
     *
     */
    protected $email;

    /** @ORM\Column(type="string", unique=true)   */
    protected $phoneConfirmToken;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $userSalt;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $notifications;

    /**
     * @ORM\OneToMany(targetEntity="\App\Entity\Deal", mappedBy="user")
     * @var ArrayCollection
     */
    protected $deals;

    /** @ORM\Column(type="string") */
    protected $password;

    /**
     * @ORM\OneToMany(targetEntity="\App\Entity\LoginLog", mappedBy="user")
     * @var ArrayCollection
     */
    protected $logins;

    /**
     * @ORM\OneToMany(targetEntity="\App\Entity\UserStip", mappedBy="user")
     * @var ArrayCollection
     */
    protected $stips;

    /**
     * @ORM\OneToMany(targetEntity="\App\Entity\Bid", mappedBy="user")
     * @var ArrayCollection
     */
    protected $bids;

    /**
     * @ORM\OneToMany(targetEntity="\App\Entity\Message", mappedBy="user")
     * @var null|PersistentCollection
     */
    protected $messages;

    /**
     * @ORM\ManyToMany(targetEntity="\App\Entity\Message", mappedBy="recipients")
     * @var ArrayCollection
     */
    protected $receivedMessages;

    /**
     * @ORM\OneToMany(targetEntity="\App\Entity\DocAccess", mappedBy="user")
     * @var ArrayCollection
     */
    protected $documents;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\AclRole", inversedBy="users")
     * @var \App\Entity\AclRole
     */
    protected $role;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\UserStatus", inversedBy="users")
     * @var \App\Entity\UserStatus
     */
    protected $status;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\FailedLogin", inversedBy="users")
     * @var \App\Entity\FailedLogin
     */
    protected $failedAttempts;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Speciality", mappedBy="users")
     * @var \App\Entity\Speciality
     */
    protected $specialities;

    /** @ORM\Column(type="bigint", nullable=false, unique=true) **/
    protected $authyId = 0;

    /** @ORM\Column(type="decimal", precision=14, scale=2, nullable=false) **/
    protected $closedVolume = 0;

    /** @ORM\Column(type="decimal", precision=14, scale=2, nullable=false) **/
    protected $dealVolume = 0;

    /**
     * @ORM\OneToMany(targetEntity="\App\Entity\Rating", mappedBy="user")
     * @var ArrayCollection
     **/
    protected $ratings;

    /**
     * @ORM\ManyToMany(targetEntity="\App\Entity\Community", mappedBy="users")
     * @var ArrayCollection
     */
    protected $communities;

    /**
     * @ORM\OneToMany(targetEntity="\App\Entity\Community", mappedBy="owner")
     * @var ArrayCollection
     */
    protected $myCommunities;

    /**
     * @ORM\OneToMany(targetEntity="\App\Entity\Rating", mappedBy="rater")
     * @var ArrayCollection
     **/
    protected $rated;

    /**
     * @ORM\ManyToMany(targetEntity="\App\Entity\MarketUser")
     * @ORM\JoinTable(name="followers",
     *     joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="follower_id", referencedColumnName="id")}
     *     )
     * @var ArrayCollection
     **/
    protected $followers;

    /**
     * @ORM\ManyToMany(targetEntity="\App\Entity\MarketUser")
     * @ORM\JoinTable(name="following",
     *     joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="following_id", referencedColumnName="id")}
     *     )
     * @var ArrayCollection
     **/
    protected $following;

    /**
     * @ORM\OneToMany(targetEntity="\App\Entity\DealFile", mappedBy="user")
     * @var ArrayCollection
     */
    protected $files;

    /**
     * @ORM\ManyToMany(targetEntity="\App\Entity\Deal", inversedBy="userFavorites")
     * @ORM\JoinTable(name="user_favorite_deals",
     *     joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="favorite_deal_id", referencedColumnName="id")}
     *     )
     * @var ArrayCollection
     */
    protected $marketFavorites;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $token;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $authyToken;

    /**
     * @var string
     * @ORM\Column(type="text", nullable=true)
     */
    protected $rememberToken;

    /**
     * @ORM\ManyToMany(targetEntity="\App\Entity\Deal", inversedBy="marketUsers")
     *
     * @var ArrayCollection
     */
    protected $marketDeals;

    /**
     * @ORM\ManyToMany(targetEntity="\App\Entity\Loan\SaleAttribute", mappedBy="buyers")
     * @var PersistentCollection
     */
    protected $boughtLoans;

    /**
     * @ORM\OneToMany(targetEntity="\App\Entity\DueDiligence", mappedBy="user")
     * @var \App\Entity\DueDiligence
     */
    protected $diligence;

    /**
     * @ORM\OneToMany(targetEntity="\App\Entity\LoanTapeTemplate", mappedBy="user")
     * @var  ArrayCollection
     * */
    protected $templates;

    /**
     * @ORM\OneToMany(targetEntity="\App\Entity\Chat", mappedBy="user")
     * @var ArrayCollection
     */
    protected $chats;

    /**
     * @ORM\OneToMany(targetEntity="\App\Entity\Chat", mappedBy="recipient")
     * @var MarketUser
     */
    protected $chatRecipient;

    /**
     * @ORM\OneToMany(targetEntity="\App\Entity\GroupChat", mappedBy="user")
     * @var ArrayCollection
     */
    protected $groupChats;

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
        $this->failedAttempts = new FailedLogin();
        parent::__construct();
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
    public function getId() { return $this->id; }

    /**
     * @return mixed
     */
    public function getUserName() { return $this->userName; }

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
     * @return mixed
     */
    public function getAuthPassword() { return $this->password; }

    public function getAuthIdentifierName() { return 'userName'; }

    /**
     * @return mixed
     */
    public function getAuthIdentifier() { return $this->userName; }

    public function getRememberTokenName() { return 'rememberToken'; }

    public function getRememberToken() { return $this->rememberToken; }

    public function setRememberToken($value)
    {
        $this->rememberToken = $value;
    }

    /**
     * @param mixed $password
     */
    public function setAuthPassword($password) { $this->password = $password; }

    public function setAuthyToken ($authyToken) { $this->authyToken = $authyToken; }

    /**
     * @return mixed
     */
    public function getUserSalt() { return $this->userSalt; }

    /**
     * @return mixed
     */
    public function getStatus() { return $this->status; }

    /**
     * @param $status UserStatus
     * @throws \Exception
     */
    public function setStatus(UserStatus $status)
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
     * @return mixed
     */
    public function getAuthyId() { return $this->authyId; }

    /**
     * @param mixed $authyId
     */
    public function setAuthyId($authyId)
    {
        $this->implementChange($this,'authyId', $this->authyId, $authyId);
    }

    /**
     * @param int $int
     * @return \Exception
     */
    public function setNotifications(int $int)
    {
        if(array_key_exists($int, self::NOTIFY)){
            $this->notifications = $int;
        }else{
            return new \Exception("Notifications must be either 1, 2 or 3.");
        }
    }

    /**
     * @return ArrayCollection
     */
    public function getDiligence() { return $this->diligence; }

    /**
     * @return ArrayCollection
     */
    public function getFiles(){ return $this->files; }

    /**
     * @return mixed
     */
    public function getMarketDeals() { return $this->marketDeals; }

    /**
     * @return ArrayCollection
     */
    public function getMarketFavorites() { return $this->marketFavorites; }

    /**
     * @return ArrayCollection
     */
    public function getTemplates() { return $this->templates; }

    public function getMappedTypes() { return $this->mappedTypes; }

    /**
     * @return mixed
     */
    public function getFirstName() { return $this->firstName; }

    /**
     * @return mixed
     */
    public function getLastName() { return $this->lastName; }

    /**
     * @return mixed
     */
    public function getSignatureArn() { return $this->signature_arn; }

    public function getIssuer() :Issuer { return $this->issuer; }

    /**
     * @return mixed
     */
    public function getImageArn() { return $this->image_arn; }

    public function getEmail() { return $this->email; }

    public function getNotifications() { return $this->notifications; }

    /**
     * @return AclRole
     */
    public function getRole(): AclRole { return $this->role; }

    /**
     * @return null|PersistentCollection
     */
    public function getMessages() { return $this->messages; }

    /**
     * @return mixed
     */
    public function getRatings() { return $this->ratings; }

    /**
     * @return mixed
     */
    public function getRated() { return $this->rated; }

    public function getAuthyToken() { return $this->authyToken; }

    /**
     * @return ArrayCollection
     */
    public function getCommunities() { return $this->communities; }

    /**
     * @return ArrayCollection
     */
    public function getMyCommunities() { return $this->myCommunities; }

    public function addLogin(LoginLog $login)
    {
        $this->logins->add($login);
        $this->implementChange($this,'logins', $this->logins, $this->logins);
    }

    public function getLogins() :ArrayCollection { return $this->logins; }

    public function addStip (UserStip $stip)
    {
        $this->stips->add($stip);
        $this->implementChange($this,'stips', $this->stips, $this->stips);
    }

    public function getStips() :ArrayCollection { return $this->stips; }

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