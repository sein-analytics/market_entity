<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 */

namespace App\Entity;

use App\Service\CreatePropertiesArrayTrait;
use Doctrine\Common\NotifyPropertyChanged;
use Doctrine\ORM\Mapping\ChangeTrackingPolicy;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\PersistentCollection;
use Illuminate\Support\Facades\App;

/**
 * @ORM\Entity(repositoryClass="\App\Repository\Deal")
 * @ORM\Table(name="Deal")
 * @ChangeTrackingPolicy("NOTIFY")
 */
class Deal extends DealAbstract
{
    use CreatePropertiesArrayTrait;

    protected $ignoreDbProperties = [
        'bonds' => null, 'pools' => null, 'accounts' => null, 'shelfSpecifics' => null,
        'bids' => null  ,'triggers' => null, 'fees' => null, 'latestPeriod' => null
    ];

    protected $addUcIdToPropName = [
        'issuer' => null, 'bidType', 'latestPeriod' => null,
        'status' => null, 'auctionType' => null, 'user' => null, 'assetType'
    ];

    protected $defaultValueProperties = [
        'views' => 0,
        'callFormular' => null,
        'loanDataParser' => null,
        'priorOC' => null,
        'cashflowEngine' => null,
    ];

    /**
     * @ORM\Id @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     **/
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Issuer", inversedBy="deals")
     * @ORM\JoinColumn(name="issuer_id", referencedColumnName="id", nullable=false)
     * @var \App\Entity\Issuer
     **/
    protected $issuer;

    /** @ORM\Column(type="string") **/
    protected $issue;

    /** @ORM\Column(type="datetime", nullable=false)
     * @var \DateTime
     **/
    protected $cutOffDate;

    /** @ORM\Column(type="datetime", nullable=false) **/
    protected $closingDate;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\DealStatus", inversedBy="deals")
     * @ORM\JoinColumn(name="status_id", referencedColumnName="id", nullable=false)
     * @var \App\Entity\DealStatus
     **/
    protected $status;

    /**
     * @ORM\OneToMany(targetEntity="\App\Entity\DealFile", mappedBy="deal")
     * @var ArrayCollection
     **/
    protected $dealDocs;

    /** @ORM\Column(type="integer", nullable=false) **/
    protected $paymentDay = 1;

    /** @ORM\Column(type="decimal", precision=14, scale=2, nullable=false) **/
    protected $currentBalance;

    /** @ORM\Column(type="decimal", precision=14, scale=2, nullable=false) **/
    protected $originalBalance;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\DealAuction", inversedBy="deals")
     * @ORM\JoinColumn(name="auction_type_id", referencedColumnName="id", nullable=false)
     **/
    protected $auctionType;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\DealAsset", inversedBy="deals")
     * @ORM\JoinColumn(name="asset_type_id", referencedColumnName="id", nullable=false)
     **/
    protected $assetType;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\DealBid", inversedBy="deals")
     * @ORM\JoinColumn(name="bid_type_id", referencedColumnName="id", nullable=false)
     **/
    protected $bidType;

    /** @ORM\OneToOne(targetEntity="\App\Entity\Statistic", mappedBy="deal")
     * @var \App\Entity\Statistic
     **/
    protected $stats;

    /** @ORM\Column(type="decimal", precision=14, scale=2, nullable=true) **/
    protected $priorOC;

    /** @ORM\Column(type="string", nullable=true) **/
    protected $cashflowEngine;

    /** @ORM\Column(type="string", nullable=true) **/
    protected $callFormular;

    /**
     * @ORM\OneToMany(targetEntity="\App\Entity\Pool", mappedBy="deal")
     * @var ArrayCollection
     **/
    protected $pools;

    /**
     * @ORM\OneToMany(targetEntity="\App\Entity\Bond", mappedBy="deal")
     * @var ArrayCollection
     **/
    protected $bonds;

    /**
     * @ORM\OneToMany(targetEntity="\App\Entity\Period", mappedBy="deal")
     * @var ArrayCollection
     **/
    protected $periods;

    /**
     * @ORM\OneToMany(targetEntity="\App\Entity\Bid", mappedBy="deal")
     * @var ArrayCollection
     **/
    protected $bids;

    /**
     * @ORM\OneToMany(targetEntity="\App\Entity\DocAccess", mappedBy="deal")
     * @var ArrayCollection
     **/
    protected $documents;

    /**
    * @ORM\OneToOne(targetEntity="\App\Entity\Period")
    * @var \App\Entity\Period
    */
    protected $latestPeriod;

    /** @ORM\Column(type="string", nullable=true) */
    protected $loanDataParser;

    /** @ORM\OneToMany(targetEntity="\App\Entity\Typed\Fee", mappedBy="deal")   */
    protected $fees;

    /** @ORM\OneToMany(targetEntity="\App\Entity\Typed\Account", mappedBy="deal")  **/
    protected $accounts;

    /** @ORM\OneToMany(targetEntity="\App\Entity\Typed\ShelfSpecific", mappedBy="deal")  **/
    protected $shelfSpecifics;

    /** @ORM\OneToMany(targetEntity="\App\Entity\Typed\Trigger", mappedBy="deal")  **/
    protected $triggers;

    /**
     * @ORM\OneToMany(targetEntity="\App\Entity\Message", mappedBy="deal")
     * @var ArrayCollection
     */
    protected $messages;

    /**
     * @ORM\OneToMany(targetEntity="\App\Entity\DueDiligence", mappedBy="deal")
     * @var ArrayCollection
     */
    protected $diligence;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\MarketUser", inversedBy="deals")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false)
     * @var \App\Entity\MarketUser
     */
    protected $user;

    /**
     * @ORM\ManyToMany(targetEntity="\App\Entity\MarketUser", mappedBy="marketDeals")
     * @var PersistentCollection
     */
    protected $marketUsers;

    /**
     * @ORM\ManyToMany(targetEntity="\App\Entity\MarketUser", mappedBy="marketFavorites")
     * @var ArrayCollection
     */
    protected $userFavorites;

    /**
     * @ORM\OneToMany(targetEntity="\App\Entity\Rating", mappedBy="deal")
     * @var ArrayCollection
     */
    protected $ratings;

    /**
     * @ORM\OneToMany(targetEntity="\App\Entity\UserStip", mappedBy="deal")
     * @var ArrayCollection
     */
    protected $stips;

    /** @ORM\Column(type="integer", nullable=true)   */
    protected $views;

    public function __construct()
    {
        $this->pools = new ArrayCollection();
        $this->bonds = new ArrayCollection();
        $this->bids = new ArrayCollection();
        $this->dealDocs = new ArrayCollection();
        $this->documents = new ArrayCollection();
        $this->messages = new ArrayCollection();
        $this->diligence = new ArrayCollection();
        $this->userFavorites = new ArrayCollection();
        $this->periods = new ArrayCollection();
        $this->marketUsers = new MarketUser();
        $this->issuer = new Issuer();
        $this->ratings = new ArrayCollection();
        $this->stips = new ArrayCollection();
    }

    function addMessage(Message $message)
    {
        $this->messages->add($message);
    }

    function addDiligence(DueDiligence $diligence)
    {
        $this->diligence->add($diligence);
    }

    function addMarketUser(MarketUser $user)
    {
        $this->getMarketUsers()->add($user);
    }

    function addRating(Rating $rating)
    {
        if ($this->ratings->contains($rating))
            return;
        $this->ratings->add($rating);
    }

    function addStips(UserStip $stip)
    {
        $this->stips->add($stip);
    }

    function addUserFavorites(MarketUser $user){ $this->userFavorites->add($user); }

    /**
     * @param MarketUser $user
     */
    function removeUserFromUserFavorites(MarketUser $user)
    {
        if (! $this->userFavorites->contains($user))
            return;
        $this->userFavorites->removeElement($user);
        $user->removeDealFromMarketFavorites($this);
    }

    /**
     * @return mixed
     */
    public function getId() { return $this->id; }

    /**
     * @return Issuer
     */
    public function getIssuer() : Issuer { return $this->issuer; }

    /**
     * @param mixed $issuer
     */
    public function setIssuer(Issuer $issuer)
    {
        $this->implementChange($this,'issuer', $this->issuer, $issuer);
    }

    /**
     * @return mixed
     */
    public function getIssue() { return $this->issue; }

    /**
     * @param mixed $issue
     */
    public function setIssue($issue)
    {
        $this->implementChange($this,'issue', $this->issue, $issue);
    }

    /**
     * @return \DateTime
     */
    public function getClosingDate() :\DateTime { return $this->closingDate; }

    /**
     * @param \DateTime $closingDate
     */
    public function setClosingDate(\DateTime $closingDate)
    {
        $this->implementChange($this,'closingDate', $this->closingDate, $closingDate);
    }

    /**
     * @return \DateTime
     */
    public function getCutOffDate() :\DateTime { return $this->cutOffDate; }

    /**
     * @param \DateTime $cutOffDate
     */
    public function setCutOffDate(\DateTime$cutOffDate)
    {
        $this->implementChange($this,'cutOffDate', $this->cutOffDate, $cutOffDate);
    }

    /**
     * @return mixed
     */
    public function getPaymentDay() { return $this->paymentDay; }

    /**
     * @param mixed $paymentDay
     */
    public function setPaymentDay($paymentDay)
    {
        $this->implementChange($this,'paymentDay', $this->paymentDay, $paymentDay);
    }

    /**
     * @return mixed
     */
    public function getOriginalBalance() { return $this->originalBalance; }

    /**
     * @param mixed $originalBalance
     */
    public function setOriginalBalance($originalBalance)
    {
        $this->implementChange($this,'originalBalance', $this->originalBalance, $originalBalance);
    }

    /**
     * @return mixed
     */
    public function getPriorOC() { return $this->priorOC; }

    /**
     * @param mixed $priorOC
     */
    public function setPriorOC($priorOC)
    {
        $this->implementChange($this,'priorOC', $this->priorOC, $priorOC);
    }

    /**
     * @return mixed
     */
    public function getCashflowEngine() { return $this->cashflowEngine; }

    /**
     * @param mixed $cashflowEngine
     */
    public function setCashflowEngine($cashflowEngine)
    {
        $this->implementChange($this,'cashflowEngine', $this->cashflowEngine, $cashflowEngine);
    }

    /**
     * @return mixed
     */
    public function getCallFormular() { return $this->callFormular; }

    /**
     * @param mixed $callFormular
     */
    public function setCallFormular($callFormular)
    {
        $this->implementChange($this,'callFormular', $this->callFormular, $callFormular);
    }

    /**
     * @return ArrayCollection
     */
    public function getPools() : ArrayCollection { return $this->pools; }

    /**
     * @param mixed $pools
     */
    public function setPools($pools)
    {
        $this->implementChange($this,'pools', $this->pools, $pools);
    }

    /**
     * @return mixed
     */
    public function getBonds() { return $this->bonds; }

    /**
     * @param mixed $bonds
     */
    public function setBonds($bonds)
    {
        $this->implementChange($this,'bonds', $this->bonds, $bonds);
    }

    /**
     * @return mixed
     */
    public function getPeriods() { return $this->periods; }

    /**
     * @param mixed $periods
     */
    public function setPeriods($periods)
    {
        $this->implementChange($this,'periods', $this->periods, $periods);
    }

    /**
    * @return mixed
    */
    public function getLatestPeriod() { return $this->latestPeriod; }

    /**
     * @param mixed $latestPeriod
     */
    public function setLatestPeriod($latestPeriod)
     {
         $this->implementChange($this,'latestPeriod', $this->latestPeriod, $latestPeriod);
     }

    /**
     * @return mixed
     */
    public function getLoanDataParser() { return $this->loanDataParser; }

    /**
     * @param mixed $loanDataParser
     */
    public function setLoanDataParser($loanDataParser)
    {
        $this->implementChange($this,'loanDataParser', $this->loanDataParser, $loanDataParser);
    }

    /**
     * @return MarketUser
     */
    public function getUser() : MarketUser { return $this->user; }

    /**
     * @param MarketUser $user
     */
    public function setUser(MarketUser $user)
    {
        $this->implementChange($this,'user', $this->user, $user);
    }

    /**
     * @return ArrayCollection
     */
    public function getMessages() { return $this->messages; }

    /**
     * @return ArrayCollection
     */
    public function getDiligence() { return $this->diligence; }

    /**
     * @return PersistentCollection
     */
    public function getMarketUsers() : PersistentCollection { return $this->marketUsers; }

    /**
     * @return ArrayCollection
     */
    public function getUserFavorites() { return $this->userFavorites; }

    /**
     * @param integer $views
     */
    public function setViews($views)
    {
        $this->implementChange($this,'views', $this->views, $views);
        $this->views = $views;
    }

    public function getViews() { return $this->views; }

    /**
     * @return ArrayCollection
     */
    public function getRatings() {  return $this->ratings; }

    /**
     * @return mixed
     */
    public function getAssetType() : DealAsset { return $this->assetType; }

    /**
     * @return DealStatus
     */
    public function getStatus(): DealStatus { return $this->status; }

    /**
     * @param DealStatus $status
     */
    public function setStatus(DealStatus $status)  { $this->status = $status; }

    public function getStips() :ArrayCollection { return $this->stips; }


}