<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 */

namespace App\Entity;

use Doctrine\Common\NotifyPropertyChanged;
use Doctrine\ORM\Mapping\ChangeTrackingPolicy;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Illuminate\Support\Facades\App;

/**
 * @ORM\Entity(repositoryClass="\App\Repository\Deal")
 * @ORM\Table(name="Deal")
 * @ChangeTrackingPolicy("NOTIFY")
 */
class Deal extends DealAbstract implements NotifyPropertyChanged
{
    use NotifyChangeTrait;

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
     * @var ArrayCollection
     */
    protected $marketUsers;

    /**
     * @ORM\ManyToMany(targetEntity="\App\Entity\MarketUser", mappedBy="marketFavorites")
     * @var ArrayCollection
     */
    protected $userFavorites;

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
        $this->marketUsers = new ArrayCollection();
        $this->userFavorites = new ArrayCollection();
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
        $this->marketUsers->add($user);
    }

    function addUserFavorites(MarketUser $user){
        $this->userFavorites->add($user);
    }

    /**
     * @return mixed
     */
    public function getId() { return $this->id; }

    /**
     * @return mixed
     */
    public function getIssuer() { return $this->issuer; }

    /**
     * @param mixed $issuer
     */
    public function setIssuer(Issuer $issuer)
    {
        $this->_onPropertyChanged('issuer', $this->issuer, $issuer);
        $this->issuer = $issuer;
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
        $this->_onPropertyChanged('issue', $this->issue, $issue);
        $this->issue = $issue;
    }

    /**
     * @return mixed
     */
    public function getClosingDate() { return $this->closingDate; }

    /**
     * @param mixed $closingDate
     */
    public function setClosingDate($closingDate)
    {
        $this->_onPropertyChanged('closingDate', $this->closingDate, $closingDate);
        $this->closingDate = $closingDate;
    }

    /**
     * @return \DateTime
     */
    public function getCutOffDate() { return $this->cutOffDate; }

    /**
     * @param \DateTime $cutOffDate
     */
    public function setCutOffDate($cutOffDate)
    {
        $this->_onPropertyChanged('cutOffDate', $this->cutOffDate, $cutOffDate);
        $this->cutOffDate = $cutOffDate;
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
        $this->_onPropertyChanged('paymentDay', $this->paymentDay, $paymentDay);
        $this->paymentDay = $paymentDay;
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
        $this->_onPropertyChanged('originalBalance', $this->originalBalance, $originalBalance);
        $this->originalBalance = $originalBalance;
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
        $this->_onPropertyChanged('priorOC', $this->priorOC, $priorOC);
        $this->priorOC = $priorOC;
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
        $this->_onPropertyChanged('cashflowEngine', $this->cashflowEngine, $cashflowEngine);
        $this->cashflowEngine = $cashflowEngine;
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
        $this->_onPropertyChanged('callFormular', $this->callFormular, $callFormular);
        $this->callFormular = $callFormular;
    }

    /**
     * @return mixed
     */
    public function getPools() { return $this->pools; }

    /**
     * @param mixed $pools
     */
    public function setPools($pools)
    {
        $this->_onPropertyChanged('pools', $this->pools, $pools);
        $this->pools = $pools;
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
        $this->_onPropertyChanged('bonds', $this->bonds, $bonds);
        $this->bonds = $bonds;
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
        $this->_onPropertyChanged('periods', $this->periods, $periods);
        $this->periods = $periods;
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
        $this->_onPropertyChanged('latestPeriod', $this->latestPeriod, $latestPeriod);
        $this->latestPeriod = $latestPeriod;
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
        $this->_onPropertyChanged('loanDataParser', $this->loanDataParser, $loanDataParser);
        $this->loanDataParser = $loanDataParser;
    }

    /**
     * @return MarketUser
     */
    public function getUser() { return $this->user; }

    /**
     * @param MarketUser $user
     */
    public function setUser(MarketUser $user)
    {
        $this->_onPropertyChanged('user', $this->user, $user);
        $this->user = $user;
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
     * @return ArrayCollection
     */
    public function getMarketUsers() { return $this->marketUsers; }

    /**
     * @return ArrayCollection
     */
    public function getUserFavorites() { return $this->userFavorites; }

    /**
     * @param integer $views
     */
    public function setViews($views)
    {
        $this->_onPropertyChanged('views', $this->views, $views);
        $this->views = $views;
    }

    public function getViews() { return $this->views; }


}