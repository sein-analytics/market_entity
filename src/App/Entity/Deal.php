<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 */

namespace App\Entity;

use App\Service\CreatePropertiesArrayTrait;
use Doctrine\ORM\Mapping\ChangeTrackingPolicy;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\PersistentCollection;
use Illuminate\Support\Facades\App;

/**
 * \Doctrine\ORM\Mapping\Entity(repositoryClass="\App\Repository\Deal")
 * \Doctrine\ORM\Mapping\Table(name="Deal")
 * \Doctrine\ORM\Mapping\ChangeTrackingPolicy("NOTIFY")
 */
class Deal extends DealAbstract
{
    use CreatePropertiesArrayTrait;

    protected array $ignoreDbProperties = [
        'bonds' => null, 'pools' => null, 'accounts' => null, 'shelfSpecifics' => null,
        'bids' => null  ,'triggers' => null, 'fees' => null, 'latestPeriod' => null
    ];

    protected array $addUcIdToPropName = [
        'issuer' => null, 'bidType', 'latestPeriod' => null,
        'status' => null, 'auctionType' => null, 'user' => null, 'assetType'
    ];

    protected array $defaultValueProperties = [
        'views' => 0,
        'callFormular' => null,
        'loanDataParser' => null,
        'priorOC' => null,
        'cashflowEngine' => null,
    ];

    /**
     * \Doctrine\ORM\Mapping\Id @ORM\Column(type="integer")
     * \Doctrine\ORM\Mapping\GeneratedValue
     **/
    protected int $id;

    /**
     * \Doctrine\ORM\Mapping\ManyToOne(targetEntity="App\Entity\Issuer", inversedBy="deals")
     * \Doctrine\ORM\Mapping\JoinColumn(name="issuer_id", referencedColumnName="id", nullable=false)
     * @var Issuer
     **/
    protected $issuer;

    /**
     * \Doctrine\ORM\Mapping\Column(type="string")
     * @var string
     */
    protected string $issue = '';

    /**
     * \Doctrine\ORM\Mapping\Column(type="datetime", nullable=false)
     * @var \DateTime
     **/
    protected $cutOffDate;

    /**
     * \Doctrine\ORM\Mapping\Column(type="datetime", nullable=false)
     * @var \DateTime
     **/
    protected $closingDate;

    /**
     * \Doctrine\ORM\Mapping\ManyToOne(targetEntity="\App\Entity\DealStatus", inversedBy="deals")
     * \Doctrine\ORM\Mapping\JoinColumn(name="status_id", referencedColumnName="id", nullable=false)
     * @var DealStatus
     **/
    protected $status;

    /**
     * \Doctrine\ORM\Mapping\OneToMany(targetEntity="\App\Entity\DealFile", mappedBy="deal")
     * @var ArrayCollection
     **/
    protected $dealDocs;

    /**
     * @ORM\Column(type="integer", nullable=false)
     * @var int
     */
    protected int $paymentDay = 1;

    /**
     * \Doctrine\ORM\Mapping\Column(type="decimal", precision=14, scale=2, nullable=false) *
     * @var float
     */
    protected float $currentBalance=0.0;

    /**
     * \Doctrine\ORM\Mapping\Column(type="decimal", precision=14, scale=2, nullable=false) *
     * @var float
     */
    protected float $originalBalance=0.0;

    /**
     * \Doctrine\ORM\Mapping\ManyToOne(targetEntity="\App\Entity\DealAuction", inversedBy="deals")
     * \Doctrine\ORM\Mapping\JoinColumn(name="auction_type_id", referencedColumnName="id", nullable=false)
     **/
    protected $auctionType;

    /**
     * \Doctrine\ORM\Mapping\ManyToOne(targetEntity="\App\Entity\DealAsset", inversedBy="deals")
     * \Doctrine\ORM\Mapping\JoinColumn(name="asset_type_id", referencedColumnName="id", nullable=false)
     **/
    protected $assetType;

    /**
     * \Doctrine\ORM\Mapping\ManyToOne(targetEntity="\App\Entity\DealBid", inversedBy="deals")
     * \Doctrine\ORM\Mapping\JoinColumn(name="bid_type_id", referencedColumnName="id", nullable=false)
     **/
    protected $bidType;

    /**
     * \Doctrine\ORM\Mapping\OneToOne(targetEntity="\App\Entity\Statistic", mappedBy="deal")
     * @var Statistic
     **/
    protected $stats;

    /**
     * \Doctrine\ORM\Mapping\Column(type="decimal", precision=14, scale=2, nullable=true)
     * @var ?float
     */
    protected ?float $priorOC;

    /**
     * \Doctrine\ORM\Mapping\Column(type="string", nullable=true)
     * @var ?string
     */
    protected ?string $cashflowEngine;

    /**
     * \Doctrine\ORM\Mapping\Column(type="string", nullable=true)
     * @var ?string
     */
    protected ?string $callFormular;

    /**
     * \Doctrine\ORM\Mapping\OneToMany(targetEntity="\App\Entity\Pool", mappedBy="deal")
     * @var ArrayCollection
     **/
    protected $pools;

    /**
     * \Doctrine\ORM\Mapping\OneToMany(targetEntity="\App\Entity\Bond", mappedBy="deal")
     * @var ArrayCollection
     **/
    protected $bonds;

    /**
     * \Doctrine\ORM\Mapping\OneToMany(targetEntity="\App\Entity\Period", mappedBy="deal")
     * @var ArrayCollection
     **/
    protected $periods;

    /**
     * \Doctrine\ORM\Mapping\OneToMany(targetEntity="\App\Entity\Bid", mappedBy="deal")
     * @var ArrayCollection
     **/
    protected $bids;

    /**
     * \Doctrine\ORM\Mapping\OneToMany(targetEntity="\App\Entity\DocAccess", mappedBy="deal")
     * @var ArrayCollection
     **/
    protected $documents;

    /**
    * \Doctrine\ORM\Mapping\OneToOne(targetEntity="\App\Entity\Period")
    * @var Period
    */
    protected $latestPeriod;

    /**
     * \Doctrine\ORM\Mapping\Column(type="string", nullable=true)
     * @var ?string
     */
    protected ?string $loanDataParser;

    /**
     * \Doctrine\ORM\Mapping\OneToMany(targetEntity="\App\Entity\Typed\Fee", mappedBy="deal")
     */
    protected $fees;

    /**
     * \Doctrine\ORM\Mapping\OneToMany(targetEntity="\App\Entity\Typed\Account", mappedBy="deal")  *
     */
    protected $accounts;

    /**
     * \Doctrine\ORM\Mapping\OneToMany(targetEntity="\App\Entity\Typed\ShelfSpecific", mappedBy="deal")  *
     */
    protected $shelfSpecifics;

    /**
     * \Doctrine\ORM\Mapping\OneToMany(targetEntity="\App\Entity\Typed\Triggers", mappedBy="deal")  *
     */
    protected $triggers;

    /**
     * \Doctrine\ORM\Mapping\OneToMany(targetEntity="\App\Entity\Message", mappedBy="deal")
     * @var ArrayCollection
     */
    protected $messages;

    /**
     * \Doctrine\ORM\Mapping\OneToMany(targetEntity="\App\Entity\DueDiligence", mappedBy="deal")
     * @var ArrayCollection
     */
    protected $diligence;

    /**
     * \Doctrine\ORM\Mapping\ManyToOne(targetEntity="\App\Entity\MarketUser", inversedBy="deals")
     * \Doctrine\ORM\Mapping\JoinColumn(name="user_id", referencedColumnName="id", nullable=false)
     * @var \App\Entity\MarketUser
     */
    protected $user;

    /**
     * \Doctrine\ORM\Mapping\ManyToMany(targetEntity="\App\Entity\MarketUser", mappedBy="marketDeals")
     * @var PersistentCollection
     */
    protected $marketUsers;

    /**
     * \Doctrine\ORM\Mapping\ManyToMany(targetEntity="\App\Entity\MarketUser", mappedBy="marketFavorites")
     * @var ArrayCollection
     */
    protected $userFavorites;

    /**
     * \Doctrine\ORM\Mapping\OneToMany(targetEntity="\App\Entity\Rating", mappedBy="deal")
     * @var ArrayCollection
     */
    protected $ratings;

    /**
     * \Doctrine\ORM\Mapping\OneToMany(targetEntity="\App\Entity\UserStip", mappedBy="deal")
     * @var ArrayCollection
     */
    protected $stips;

    /**
     * \Doctrine\ORM\Mapping\Column(type="integer", nullable=true)
     * @var ?int
     */
    protected ?int $views;

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
        parent::__construct();
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
     * @return int
     */
    public function getId():int { return $this->id; }

    /**
     * @return Issuer
     */
    public function getIssuer() : Issuer { return $this->issuer; }

    /**
     * @param mixed $issuer
     */
    public function setIssuer(Issuer $issuer):void
    {
        $this->implementChange($this,'issuer', $this->issuer, $issuer);
    }

    /**
     * @return string
     */
    public function getIssue():string { return $this->issue; }

    /**
     * @param string $issue
     */
    public function setIssue(string $issue):void
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
    public function setClosingDate(\DateTime $closingDate):void
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
    public function setCutOffDate(\DateTime $cutOffDate):void
    {
        $this->implementChange($this,'cutOffDate', $this->cutOffDate, $cutOffDate);
    }

    /**
     * @return int
     */
    public function getPaymentDay():int { return $this->paymentDay; }

    /**
     * @param int $paymentDay
     */
    public function setPaymentDay(int $paymentDay):void
    {
        $this->implementChange($this,'paymentDay', $this->paymentDay, $paymentDay);
    }

    /**
     * @return float
     */
    public function getOriginalBalance():float { return $this->originalBalance; }

    /**
     * @param float $originalBalance
     */
    public function setOriginalBalance(float $originalBalance):void
    {
        $this->implementChange($this,'originalBalance', $this->originalBalance, $originalBalance);
    }

    /**
     * @return ?float
     */
    public function getPriorOC():?float { return $this->priorOC; }

    /**
     * @param float $priorOC
     */
    public function setPriorOC(float $priorOC):void
    {
        $this->implementChange($this,'priorOC', $this->priorOC, $priorOC);
    }

    /**
     * @return ?string
     */
    public function getCashflowEngine():?string { return $this->cashflowEngine; }

    /**
     * @param string $cashflowEngine
     */
    public function setCashflowEngine(string $cashflowEngine):void
    {
        $this->implementChange($this,'cashflowEngine', $this->cashflowEngine, $cashflowEngine);
    }

    /**
     * @return ?string
     */
    public function getCallFormular():?string { return $this->callFormular; }

    /**
     * @param string $callFormular
     */
    public function setCallFormular(string $callFormular):void
    {
        $this->implementChange($this,'callFormular', $this->callFormular, $callFormular);
    }

    /**
     * @return ArrayCollection
     */
    public function getPools() : ArrayCollection { return $this->pools; }

    /**
     * @param ArrayCollection $pools
     */
    public function setPools(ArrayCollection $pools):void
    {
        $this->implementChange($this,'pools', $this->pools, $pools);
    }

    /**
     * @return ArrayCollection
     */
    public function getBonds():ArrayCollection { return $this->bonds; }

    /**
     * @param ArrayCollection $bonds
     */
    public function setBonds(ArrayCollection $bonds):void
    {
        $this->implementChange($this,'bonds', $this->bonds, $bonds);
    }

    /**
     * @return ArrayCollection
     */
    public function getPeriods():ArrayCollection { return $this->periods; }

    /**
     * @param ArrayCollection $periods
     */
    public function setPeriods(ArrayCollection $periods):void
    {
        $this->implementChange($this,'periods', $this->periods, $periods);
    }

    /**
    * @return Period
    */
    public function getLatestPeriod():Period { return $this->latestPeriod; }

    /**
     * @param Period $latestPeriod
     */
    public function setLatestPeriod(Period $latestPeriod):void
     {
         $this->implementChange($this,'latestPeriod', $this->latestPeriod, $latestPeriod);
     }

    /**
     * @return ?string
     */
    public function getLoanDataParser():?string { return $this->loanDataParser; }

    /**
     * @param string $loanDataParser
     */
    public function setLoanDataParser(string $loanDataParser):void
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
    public function getMessages():ArrayCollection { return $this->messages; }

    /**
     * @return ArrayCollection
     */
    public function getDiligence():ArrayCollection { return $this->diligence; }

    /**
     * @return PersistentCollection
     */
    public function getMarketUsers() : PersistentCollection { return $this->marketUsers; }

    /**
     * @return ArrayCollection
     */
    public function getUserFavorites():ArrayCollection { return $this->userFavorites; }

    /**
     * @param int $views
     */
    public function setViews(int $views):void
    {
        $this->implementChange($this,'views', $this->views, $views);
        $this->views = $views;
    }

    public function getViews():?int { return $this->views; }

    /**
     * @return ArrayCollection
     */
    public function getRatings():ArrayCollection {  return $this->ratings; }

    /**
     * @return DealAsset
     */
    public function getAssetType() : DealAsset { return $this->assetType; }

    /**
     * @return DealStatus
     */
    public function getStatus(): DealStatus { return $this->status; }

    /**
     * @param DealStatus $status
     */
    public function setStatus(DealStatus $status):void  { $this->status = $status; }

    public function getStips() :ArrayCollection { return $this->stips; }


}