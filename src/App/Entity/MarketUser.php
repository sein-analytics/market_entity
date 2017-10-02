<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\NotifyPropertyChanged;
use Doctrine\ORM\Mapping\ChangeTrackingPolicy;
use Doctrine\ORM\Mapping as ORM;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Arr;

/**
 * @ORM\Entity
 * @ORM\Table(name="MarketUser")
 * @ChangeTrackingPolicy("NOTIFY")
 * @ORM\HasLifeCycleCallbacks
 */
class MarketUser implements NotifyPropertyChanged, Authenticatable
{
    use NotifyChangeTrait;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", nullable=false)
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
    protected $activeDate;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * {"type":"datetime","min":"2010-01-01T00:00:00Z","max":"2020-01-01T00:00:00Z","step":"1"}
     * {"format":"Y-m-d\TH:iP"}
     */
    protected $dateModified;

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
     * @ORM\OneToMany(targetEntity="\App\Entity\Bid", mappedBy="user")
     * @var ArrayCollection
     */
    protected $bids;

    /**
     * @ORM\OneToMany(targetEntity="\App\Entity\Message", mappedBy="user")
     * @var ArrayCollection
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

    /** @ORM\Column(type="bigint", nullable=false) **/
    protected $authyId = 0;

    /** @ORM\Column(type="decimal", precision=14, scale=2, nullable=false) **/
    protected $closedVolume = 0;

    /** @ORM\Column(type="decimal", precision=14, scale=2, nullable=false) **/
    protected $dealVolume = 0;

    /**
     * @ORM\ManyToMany(targetEntity="\App\Entity\Rating", mappedBy="users")
     **/
    protected $ratings;

    /**
     * @ORM\ManyToMany(targetEntity="\App\Entity\MarketUser")
     * @ORM\JoinTable(name="followers",
     *     joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="follower_id", referencedColumnName="id")}
     *     )
     **/
    protected $followers;

    /**
     * @ORM\ManyToMany(targetEntity="\App\Entity\MarketUser")
     * @ORM\JoinTable(name="following",
     *     joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="following_id", referencedColumnName="id")}
     *     )
     **/
    protected $following;

    /** @ORM\OneToMany(targetEntity="\App\Entity\DealFile", mappedBy="user")  */
    protected $files;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $token;

    public function __construct()
    {
        $this->bids = new ArrayCollection();
        $this->messages = new ArrayCollection();
        $this->logins = new ArrayCollection();
        $this->documents = new ArrayCollection();
        $this->followers = new ArrayCollection();
        $this->following = new ArrayCollection();
        $this->receivedMessages = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getAuthPassword()
    {
        return $this->password;
    }

    public function getAuthIdentifierName()
    {
        return 'userName';
    }

    /**
     * @return mixed
     */
    public function getAuthIdentifier()
    {
        return $this->userName;
    }

    public function getRememberTokenName()
    {
        return 'token';
    }

    public function getRememberToken()
    {
        return $this->token;
    }

    public function setRememberToken($value)
    {
        $this->token = $value;
    }

    /**
     * @param mixed $password
     */
    public function setAuthPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function getUserSalt()
    {
        return $this->userSalt;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param $status UserStatus
     * @throws \Exception
     */
    public function setStatus(UserStatus $status)
    {
        $this->_onPropertyChanged('status', $this->status, $status);
        $this->status = $status;
    }

    /**
     * @return mixed
     */
    public function getFailedAttempts()
    {
        return $this->failedAttempts;
    }

    /**
     * @param $failedAttempts
     * @throws \Exception
     */
    public function setFailedAttempts($failedAttempts)
    {
        $this->_onPropertyChanged('failedAttempts', $this->failedAttempts, $failedAttempts);
        $this->failedAttempts = $failedAttempts;
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
    public function getAuthyId()
    {
        return $this->authyId;
    }

    /**
     * @param mixed $authyId
     */
    public function setAuthyId($authyId)
    {
        $this->_onPropertyChanged('authyId', $this->authyId, $authyId);
        $this->authyId = $authyId;
    }

}