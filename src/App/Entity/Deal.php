<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 */

namespace App\Entity;

use \App\Entity\DealFile;
use \App\Entity\DealAuction;
use \App\Entity\DealBid;
use \App\Entity\Statistic;
use \App\Entity\Pool;
use \App\Entity\Bond;
use \App\Entity\Bid;
use \App\Entity\DocAccess;
use \App\Entity\Typed\Fee;
use \App\Entity\Typed\ShelfSpecific;
use \App\Entity\Typed\Triggers;
use \App\Entity\DealContract;
use DateTime;
use App\Service\CreatePropertiesArrayTrait;
 
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\PersistentCollection;
use Illuminate\Support\Facades\App;

#[ORM\Table(name: 'Deal')]
#[ORM\Entity(repositoryClass: \App\Repository\Deal::class)]
 
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

    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    protected int $id;

    /**
     * @var Issuer
     **/
    #[ORM\JoinColumn(name: 'issuer_id', referencedColumnName: 'id', nullable: false)]
    #[ORM\ManyToOne(targetEntity: Issuer::class, inversedBy: 'deals')]
    protected $issuer;

    /**
     * @var string
     */
    #[ORM\Column(type: 'string')]
    protected string $issue = '';

    /**
     * @var DateTime
     **/
    #[ORM\Column(type: 'datetime', nullable: false)]
    protected $cutOffDate;

    /**
     * @var DateTime
     **/
    #[ORM\Column(type: 'datetime', nullable: false)]
    protected $closingDate;

    /**
     * @var DealStatus
     **/
    #[ORM\JoinColumn(name: 'status_id', referencedColumnName: 'id', nullable: false)]
    #[ORM\ManyToOne(targetEntity:  DealStatus::class, inversedBy: 'deals')]
    protected $status;

    /**
     * @var ArrayCollection
     **/
    #[ORM\OneToMany(targetEntity: DealFile::class, mappedBy: 'deal')]
    protected $dealDocs;

    /**
     * @var int
     */
    #[ORM\Column(type: 'integer', nullable: false)]
    protected int $paymentDay = 1;

    /**
     * @var float
     */
    #[ORM\Column(type: 'float', precision: 14, scale: 2, nullable: false)]
    protected float $currentBalance=0.0;

    /**
     * @var float
     */
    #[ORM\Column(type: 'float', precision: 14, scale: 2, nullable: false)]
    protected float $originalBalance=0.0;

    #[ORM\JoinColumn(name: 'auction_type_id', referencedColumnName: 'id', nullable: false)]
    #[ORM\ManyToOne(targetEntity: DealAuction::class, inversedBy: 'deals')]
    protected $auctionType;

    #[ORM\JoinColumn(name: 'asset_type_id', referencedColumnName: 'id', nullable: false)]
    #[ORM\ManyToOne(targetEntity:  DealAsset::class, inversedBy: 'deals')]
    protected $assetType;

    #[ORM\JoinColumn(name: 'bid_type_id', referencedColumnName: 'id', nullable: false)]
    #[ORM\ManyToOne(targetEntity: DealBid::class, inversedBy: 'deals')]
    protected $bidType;

    /**
     * @var Statistic
     **/
    #[ORM\OneToOne(targetEntity: Statistic::class, mappedBy: 'deal')]
    protected $stats;

    /**
     * @var ?float
     */
    #[ORM\Column(type: 'float', precision: 14, scale: 2, nullable: true)]
    protected ?float $priorOC;

    /**
     * @var ?string
     */
    #[ORM\Column(type: 'string', nullable: true)]
    protected ?string $cashflowEngine;

    /**
     * @var ?string
     */
    #[ORM\Column(type: 'string', nullable: true)]
    protected ?string $callFormular;

    /**
     * @var ArrayCollection
     **/
    #[ORM\OneToMany(targetEntity: Pool::class, mappedBy: 'deal')]
    protected $pools;

    /**
     * @var ArrayCollection
     **/
    #[ORM\OneToMany(targetEntity: Bond::class, mappedBy: 'deal')]
    protected $bonds;

    /**
     * @var ArrayCollection
     **/
    #[ORM\OneToMany(targetEntity:  Period::class, mappedBy: 'deal')]
    protected $periods;

    /**
     * @var ArrayCollection
     **/
    #[ORM\OneToMany(targetEntity: Bid::class, mappedBy: 'deal')]
    protected $bids;

    /**
     * @var ArrayCollection
     **/
    #[ORM\OneToMany(targetEntity: DocAccess::class, mappedBy: 'deal')]
    protected $documents;

    /**
     * @var Period
     */
    #[ORM\OneToOne(targetEntity:  Period::class)]
    protected $latestPeriod;

    /**
     * @var ?string
     */
    #[ORM\Column(type: 'string', nullable: true)]
    protected ?string $loanDataParser;

    #[ORM\OneToMany(targetEntity: Fee::class, mappedBy: 'deal')]
    protected $fees;

    #[ORM\OneToMany(targetEntity: ShelfSpecific::class, mappedBy: 'deal')]
    protected $shelfSpecifics;

    #[ORM\OneToMany(targetEntity: Triggers::class, mappedBy: 'deal')]
    protected $triggers;

    /**
     * @var ArrayCollection
     */
    #[ORM\OneToMany(targetEntity:  Message::class, mappedBy: 'deal')]
    protected $messages;

    /**
     * @var ArrayCollection
     */
    #[ORM\OneToMany(targetEntity:  DueDiligence::class, mappedBy: 'deal')]
    protected $diligence;

    /**
     * @var \App\Entity\MarketUser
     */
    #[ORM\JoinColumn(name: 'user_id', referencedColumnName: 'id', nullable: false)]
    #[ORM\ManyToOne(targetEntity:  MarketUser::class, inversedBy: 'deals')]
    protected $user;

    /**
     * @var PersistentCollection
     */
    #[ORM\ManyToMany(targetEntity:  MarketUser::class, mappedBy: 'marketDeals')]
    protected $marketUsers;

    /**
     * @var ArrayCollection
     */
    #[ORM\ManyToMany(targetEntity:  MarketUser::class, mappedBy: 'marketFavorites')]
    protected $userFavorites;

    /**
     * @var ArrayCollection
     */
    #[ORM\OneToMany(targetEntity:  Rating::class, mappedBy: 'deal')]
    protected $ratings;

    /**
     * @var ArrayCollection
     */
    #[ORM\OneToMany(targetEntity:  UserStip::class, mappedBy: 'deal')]
    protected $stips;

    /**
     * @var ?int
     */
    #[ORM\Column(type: 'integer', nullable: true)]
    protected ?int $views;

    /**
     * @var ArrayCollection|PersistentCollection|null
     */
    #[ORM\OneToMany(targetEntity: DealContract::class, mappedBy: 'deal')]
    protected $contracts;

    /**
     * @var null|bool
     */
    #[ORM\Column(type: 'boolean', nullable: true)]
    protected ?bool $requiresNda; 

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
        $this->contracts = new ArrayCollection();
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
     * @return DateTime
     */
    public function getClosingDate() :DateTime { return $this->closingDate; }

    /**
     * @param DateTime $closingDate
     */
    public function setClosingDate(DateTime $closingDate):void
    {
        $this->implementChange($this,'closingDate', $this->closingDate, $closingDate);
    }

    /**
     * @return DateTime
     */
    public function getCutOffDate() :DateTime { return $this->cutOffDate; }

    /**
     * @param DateTime $cutOffDate
     */
    public function setCutOffDate(DateTime $cutOffDate):void
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


    /**
     * @return ArrayCollection
     */
    public function getContracts():ArrayCollection|PersistentCollection|null { return $this->contracts; }

    /**
     * @return bool|null
     */
    public function getRequiresNda() :null|bool { return $this->requiresNda; }

    /**
     * @param bool $notify
     */
    public function setRequiresNda(bool $requiresNda):void
    {
        $this->requiresNda = $requiresNda;
    }

}