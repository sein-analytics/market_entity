<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 */

namespace App\Entity;

use App\Entity\Data\Cbsa;
use App\Entity\Data\State;
use App\Entity\Loan\AmortAttribute;
use App\Entity\Loan\ArmAttribute;
use App\Entity\Loan\CommAttribute;
use App\Entity\Loan\DescAttribute;
use App\Entity\Loan\ModificationAttribute;
use App\Entity\Loan\SaleAttribute;
use App\Service\CreatePropertiesArrayTrait;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\PersistentCollection;

/**
 * @ORM\Entity(repositoryClass="\App\Repository\Loan")
 * @ORM\Table(name="loans")
 * @ORM\ChangeTrackingPolicy("NOTIFY")
 * @ORM\DiscriminatorColumn(name="assetClass", type="string")
 * @ORM\DiscriminatorMap({
 *      "Auto"          = "\App\Entity\AssetType\Auto",
 *      "Residential"   = "\App\Entity\AssetType\Residential",
 *      "Commercial"    = "\App\Entity\AssetType\Commercial",
 *      "CreditCard"    = "\App\Entity\AssetType\CreditCard",
 *      "Cre"           = "\App\Entity\AssetType\Cre",
 *      "HomeEquity"    = "\App\Entity\AssetType\HomeEquity"
 * })
 *
 */
class Loan extends DomainObject
{
    use CreatePropertiesArrayTrait;

    //abstract public function getAssetAttributes();

    //Note originally this class was abstract. We removed abstract from definition to facilitate
    //The creation of a class proxy....

    const AMORTIZING = 'Amortizing';
    const REVOLVING  = 'Revolving';
    const PARTIAL    = 'RevolvingToAmortizing';

    const ASSUMED = 'Assumed';
    const ACTUAL  = 'Actual';


    protected static array $amortTypes = array(
        self::AMORTIZING => 'Amortizing',
        self::REVOLVING  =>  'Revolving',
        //self::AMORTIZING => 'Amortizing',
    );

    protected static array $descriptions = array(
        self::ASSUMED => 'Assumed',
        self::ACTUAL  => 'Actual'
    );

    protected array $ignoreDbProperties = [
        'bids' => null, 'updates' => null, 'accounts' => null, 'specifics' => null,
        'triggers' => null, 'fees' => null, 'files' => 'null', 'issues' => null
    ];

    protected array $addUcIdToPropName = [
        'pool' => null,
        'amortization' => null,
        'description' => null,
        'state' => null,
        'msaCode' => null
    ];

    protected array $defaultValueProperties = [
        'msaCode' => null,
        'seasoning' => null,
        'remainingTerm' => null,
    ];

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     * @var int
     */
    protected int $id;

    /**
     * @ORM\Column(type="string", nullable=false)
     * @var string
     */
    protected string $loanId;


    /**
     * @ORM\OneToOne(targetEntity = "\App\Entity\Loan\ArmAttribute", mappedBy="loan")
     * @var ArmAttribute|null
     */
    protected $armAttributes;

    /**
     * @ORM\OneToOne(targetEntity = "\App\Entity\Loan\CommAttribute", mappedBy="loan")
     * @var CommAttribute|null
     */
    protected $commAttributes;

    /**
     * @ORM\OneToOne(targetEntity = "\App\Entity\Loan\SaleAttribute", mappedBy="loan")
     * @var SaleAttribute|null
     */
    protected $saleAttributes;

    /**
     * @ORM\OneToOne (targetEntity="\App\Entity\Loan\ModificationAttribute", mappedBy="loan")
     * @var ModificationAttribute|null
     */
    protected $modificationAttribute;

    protected $foreclosureAttributes;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\Pool", inversedBy = "loans")
     * @ORM\JoinColumn(name="pool_id", referencedColumnName="id", nullable=false)
     * @var Pool
     **/
    protected $pool;

    /**
     * @ORM\Column(type="decimal", precision=16, scale=3, nullable=false)
     * @var float
     */
    protected float $originalBalance = 0.0;

    /**
     * @ORM\Column(type="decimal", precision=16, scale=3, nullable=false)
     * @var float
     */
    protected float $currentBalance = 0.0;

    /**
     * @ORM\Column(type="decimal", precision=16, scale=3, nullable=true)
     * @var ?float
     */
    protected ?float $monthlyPayment = null;

    /**
     * @ORM\Column(type="decimal", precision=16, scale=3, nullable=true)
     * @var ?float
     */
    protected ?float $issuanceBalance;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=6, nullable=true)
     * @var ?float
     */
    protected ?float $initialRate;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @var ?int
     */
    protected ?int $seasoning;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=6, nullable=false)
     * @var float
     */
    protected float $currentRate=0.0;

    /**
     * @ORM\Column(type = "datetime", nullable=false)
     * @var \DateTime
     **/
    protected $originationDate;

    /**
     * @ORM\Column(type = "datetime", nullable=false)
     * @var \DateTime
     **/
    protected $currentDueforDate;

    /**
     * @ORM\Column(type = "datetime", nullable=false)
     * @var \DateTime
     **/
    protected $firstPaymentDate;

    /**
     * @ORM\Column(type="string", nullable=false)
     * @var string
     */
    protected string $loanStatus='';

    /**
     * @ORM\Column(type = "datetime", nullable=false)
     * @var \DateTime
     **/
    protected $finalDueforDate;

    /**
     * @ORM\Column(type="decimal", precision=14, scale=2, nullable=false)
     * @var float
     */
    protected float $originalTerm=0.0;

    /**
     * @ORM\Column(type="decimal", precision=14, scale=2, nullable=true)
     * @var ?float
     */
    protected ?float $remainingTerm;

    /**
     * @ORM\Column(type="decimal", precision=14, scale=2, nullable=false)
     * @var float
     */
    protected float $amortizationTerm=0.0;

    /**
     * @ORM\Column(type="decimal", precision=14, scale=2, nullable=true)
     * @var ?float
     */
    protected ?float $ioTerm;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @var ?int
     */
    protected ?int $balloonPeriod;

    /**
     * @ORM\Column(type="decimal", precision=8, scale=4, nullable=false)
     * @var float
     **/
    protected float $originalLtv=0.0;

    /**
     * @ORM\Column(type="decimal", precision=8, scale=4, nullable=true)
     * @var ?float
     **/
    protected ?float $originalCltv;

    /**
     * @ORM\Column(type="decimal", precision=16, scale=4, nullable=false)
     * @var float
     **/
    protected float $appraisedValue=0.0;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=4, nullable=true)
     * @var ?float
     **/
    protected ?float $creditScore;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=4, nullable=true)
     * @var ?float
     **/
    protected ?float $frontDti;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=4, nullable=true)
     * @var ?float
     **/
    protected ?float $backDti;

    /**
     * @ORM\Column(type = "integer", nullable=true)
     * @var ?int
     */
    protected ?int $numberOfBorrowers;

    /**
     * @ORM\Column(type = "integer", nullable=true)
     * @var ?int
     */
    protected ?int $firstTimeBuyer;

    /**
     * @ORM\Column(type="integer", nullable=false)
     * @var int
     */
    protected int $lienPosition=1;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var ?string
     */
    protected ?string $noteType;

    /**
     * @ORM\Column(type="string", nullable=false)
     * @var string
     */
    protected string $loanType='';

    /**
     * @ORM\Column(type="string", nullable=false)
     * @var string
     */
    protected string $documentation='';

    /**
     * @ORM\Column(type="string", nullable=false)
     * @var string
     */
    protected string $purpose='';

    /**
     * @ORM\Column(type="string", nullable=false)
     * @var string
     */
    protected string $occupancy='';

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var ?string
     */
    protected ?string $dwelling;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var ?string
     */
    protected ?string $address;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Data\State", inversedBy="loans") *
     */
    protected $state;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var ?string
     */
    protected ?string $city;

    /**
     * @ORM\Column(type="string", nullable=false)
     * @var string
     */
    protected string $zip='';


    /**
     * @ORM\Column(type="json", nullable=true)
     * @var ?string
     */
    protected ?string $assetAttributes;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Data\Cbsa", inversedBy="loans")
     **/
    protected $msaCode;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var ?string
     */
    protected ?string $paymentString;

    /**
     * @ORM\Column(type="decimal", precision=14, scale=6, nullable = true)
     * @var ?float
     */
    protected ?float $servicingfee;

    /**
     * @ORM\Column(type="decimal", precision=14, scale=6, nullable = true)
     * @var ?float
     */
    protected ?float $lpmiFee;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=4, nullable = true)
     * @var ?float
     */
    protected ?float $miCoverage;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\Loan\AmortAttribute", inversedBy="loans")
     * @var  AmortAttribute */
    protected $amortization;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\Loan\DescAttribute", inversedBy="loans")
     * @var  DescAttribute */
    protected $description;

    /**
     * @ORM\Column(type = "datetime", nullable=true)
     * @var ?\dateTime
     **/
    protected $foreclosureDate;

    /**
     * @ORM\Column(type = "datetime", nullable=true)
     * @var ?\dateTime
     **/
    protected $bankruptcyDate;

    /**
     * @ORM\Column(type = "datetime", nullable=true)
     * @var ?\dateTime
     **/
    protected $reoDate;

    /**
     * @ORM\Column(type = "datetime", nullable=true)
     * @var ?\dateTime
     **/
    protected $zeroBalanceDate;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @var ?int $loanHasBeenModified
     */
    protected ?int $loanHasBeenModified;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @var ?int $lengthOfModification
     */
    protected ?int $endModPeriod;

    /**
     * @ORM\Column(type="string", nullable=true) *
     * @var ?string
     */
    protected ?string $channel;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @var ?\DateTime
     */
    protected $lastPaymentDate;

    /**
     * @ORM\Column(type="integer", nullable=true)
     *@var ?int
     */
    protected ?int $times_30;

    /**
     * @ORM\Column(type="integer", nullable=true)
     *@var ?int
     */
    protected ?int $times_60;

    /**
     * @ORM\Column(type="integer", nullable=true)
     *@var ?int
     */
    protected ?int $times_90;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @var ?int
     */
    protected ?int $yearBuilt;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var ?string
     */
    protected ?string $newVsUsed;

    /**
     * @ORM\Column(type="decimal", precision=8, scale=2, nullable = true)
     * @var ?float
     */
    protected ?float $reserves;

    /**
     * @ORM\Column(type="decimal", precision=8, scale=2, nullable = true)
     * @var ?float
     */
    protected ?float $dealerReserve;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @var ?int
     */
    protected ?int $prepayPenaltyTerm;

    /**
     * @ORM\Column(type="decimal", precision=8, scale=2, nullable = true)
     * @var ?float
     */
    protected ?float $prepayPenalty;

    /**
     * @ORM\Column(type="json", nullable=true)
     * @var array|null
     **/
    protected $prepayStepDown;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Bid", mappedBy="loans")
     */
    protected $bids;

    /**
     * @ORM\OneToMany(targetEntity="\App\Entity\Update\LoanUpdate", mappedBy="loan")
     */
    protected $updates;

    /**
     * @ORM\ManyToMany(targetEntity="\App\Entity\Typed\ShelfSpecific\LoanSpecific", mappedBy="loans")
     */
    protected $specifics;

    /**
     * @ORM\ManyToMany(targetEntity="\App\Entity\Typed\Fee\LoanFee", mappedBy="loans")
     */
    protected $fees;

    /**
     * @ORM\ManyToMany(targetEntity="\App\Entity\Typed\Account\LoanAccount", mappedBy="loans")
     */
    protected $accounts;

    /**
     * @ORM\ManyToMany(targetEntity="\App\Entity\Typed\Trigger\LoanTrigger", mappedBy="loans")
     */
    protected $triggers;

    /**
     * @ORM\OneToMany(targetEntity="\App\Entity\DealFile", mappedBy="loan")
     * @var ArrayCollection
     */
    protected $files;

    /**
     * @ORM\OneToMany(targetEntity="\App\Entity\DueDilLoanStatus", mappedBy="loan")
     * @var ArrayCollection|PersistentCollection|null
     */
    protected $reviewStatuses;

    /**
     * @ORM\OneToMany(targetEntity="\App\Entity\DueDiligenceIssue", mappedBy="loan", cascade={"persist"})
     * @var ArrayCollection  */
    protected $issues;

    function __construct (){
        $this->bids = new ArrayCollection();
        $this->triggers = new ArrayCollection();
        $this->specifics = new ArrayCollection();
        $this->updates = new ArrayCollection();
        $this->accounts = new ArrayCollection();
        $this->issues = new ArrayCollection();
        $this->files = new ArrayCollection();
        $this->fees = new ArrayCollection();
        $this->reviewStatuses = new ArrayCollection();
        parent::__construct();
    }

    public function addDueDilReviewStatus(DueDilReviewStatus $status)
    {
        $this->reviewStatuses->add($status);
    }

    public function addNewIssueToLoan(DueDiligenceIssue $issue)
    {
        $issue->setLoan($this);
        $this->issues->add($issue);
    }

    /**
     * @return int
     */
    public function getId():int { return $this->id; }

    /**
     * @return string
     */
    public function getLoanId():string { return $this->loanId; }

    /**
     * @param string  $loanId
     */
    public function setLoanId(string $loanId):void
    {
        $this->implementChange($this,'loanId', $this->loanId, $loanId);
    }

    /**
     * @return Pool
     */
    public function getPool():Pool { return $this->pool; }

    /**
     * @param Pool $pool
     */
    public function setPool(Pool $pool):void
    {
        $this->implementChange($this,'pool', $this->pool, $pool);
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
     * @return float
     */
    public function getCurrentBalance():float { return $this->currentBalance; }

    /**
     * @param float $currentBalance
     */
    public function setCurrentBalance(float $currentBalance):void
    {
        $this->implementChange($this,'currentBalance', $this->currentBalance, $currentBalance);
    }

    /**
     * @return ?float
     */
    public function getMonthlyPayment():?float { return $this->monthlyPayment; }

    /**
     * @param float $monthlyPayment
     */
    public function setMonthlyPayment(float $monthlyPayment):void
    {
        $this->implementChange($this,'monthlyPayment', $this->monthlyPayment, $monthlyPayment);
    }

    /**
     * @return ?float
     */
    public function getIssuanceBalance():?float { return $this->issuanceBalance; }

    /**
     * @param float $issuanceBalance
     */
    public function setIssuanceBalance(float $issuanceBalance):void
    {
        $this->implementChange($this,'issuanceBalance', $this->issuanceBalance, $issuanceBalance);
    }

    /**
     * @return ?float
     */
    public function getInitialRate():?float { return $this->initialRate; }

    /**
     * @param float $initialRate
     */
    public function setInitialRate(float $initialRate):void
    {
        $this->implementChange($this,'initialRate', $this->initialRate, $initialRate);
    }

    /**
     * @return float
     */
    public function getCurrentRate():float { return $this->currentRate; }

    /**
     * @param float $currentRate
     */
    public function setCurrentRate(float $currentRate):void
    {
        $this->implementChange($this,'currentRate', $this->currentRate, $currentRate);
    }

    /**
     * @return \DateTime
     */
    public function getOriginationDate():\DateTime { return $this->originationDate; }

    /**
     * @param \DateTime $originationDate
     */
    public function setOriginationDate(\DateTime $originationDate):void
    {
        $this->implementChange($this,'originationDate', $this->originationDate, $originationDate);
    }

    /**
     * @return \DateTime
     */
    public function getCurrentDueforDate():\DateTime { return $this->currentDueforDate; }

    /**
     * @param \DateTime $currentDueforDate
     */
    public function setCurrentDueforDate(\DateTime $currentDueforDate):void
    {
        $this->implementChange($this,'currentDueforDate', $this->currentDueforDate, $currentDueforDate);
    }

    /**
     * @return \DateTime
     */
    public function getFirstPaymentDate():\DateTime { return $this->firstPaymentDate; }

    /**
     * @param \DateTime $firstPaymentDate
     */
    public function setFirstPaymentDate(\DateTime $firstPaymentDate):void
    {
        $this->implementChange($this,'firstPaymentDate', $this->firstPaymentDate, $firstPaymentDate);
    }

    /**
     * @return string
     */
    public function getLoanStatus():string { return $this->loanStatus; }

    /**
     * @param string  $loanStatus
     */
    public function setLoanStatus(string $loanStatus)
    {
        $this->implementChange($this,'loanStatus', $this->loanStatus, $loanStatus);
    }

    /**
     * @return \DateTime
     */
    public function getFinalDueforDate():\DateTime { return $this->finalDueforDate; }

    /**
     * @param \DateTime $finalDueforDate
     */
    public function setFinalDueforDate(\DateTime $finalDueforDate):void
    {
        $this->implementChange($this,'finalDueforDate', $this->finalDueforDate, $finalDueforDate);
    }

    /**
     * @return float
     */
    public function getOriginalTerm():float { return $this->originalTerm; }

    /**
     * @param float $originalTerm
     */
    public function setOriginalTerm(float $originalTerm):void
    {
        $this->implementChange($this,'originalTerm', $this->originalTerm, $originalTerm);
    }

    /**
     * @return ?float
     */
    public function getRemainingTerm():?float { return $this->remainingTerm; }

    /**
     * @param float $remainingTerm
     */
    public function setRemainingTerm(float $remainingTerm):void
    {
        $this->implementChange($this,'remainingTerm', $this->remainingTerm, $remainingTerm);
    }

    /**
     * @return float
     */
    public function getAmortizationTerm():float { return $this->amortizationTerm; }

    /**
     * @param float $amortizationTerm
     */
    public function setAmortizationTerm(float $amortizationTerm):void
    {
        $this->implementChange($this,'amortizationTerm', $this->amortizationTerm, $amortizationTerm);
    }

    /**
     * @return ?float
     */
    public function getIoTerm():?float { return $this->ioTerm; }

    /**
     * @param float $ioTerm
     */
    public function setIoTerm(float $ioTerm):void
    {
        $this->implementChange($this,'ioTerm', $this->ioTerm, $ioTerm);
    }

    /**
     * @return ?int
     */
    public function getBalloonPeriod():?int { return $this->balloonPeriod; }

    /**
     * @param int  $balloonPeriod
     */
    public function setBalloonPeriod(int $balloonPeriod):void
    {
        $this->implementChange($this,'balloonPeriod', $this->balloonPeriod, $balloonPeriod);
    }

    /**
     * @return float
     */
    public function getOriginalLtv():float { return $this->originalLtv; }

    /**
     * @param mixed $originalLtv
     */
    public function setOriginalLtv(float $originalLtv):void
    {
        $this->implementChange($this,'originalLtv', $this->originalLtv, $originalLtv);
    }

    /**
     * @return ?float
     */
    public function getOriginalCltv():?float { return $this->originalCltv; }

    /**
     * @param float $originalCltv
     */
    public function setOriginalCltv(float $originalCltv):void
    {
        $this->implementChange($this,'originalCltv', $this->originalCltv, $originalCltv);
    }

    /**
     * @return float
     */
    public function getAppraisedValue():float { return $this->appraisedValue; }

    /**
     * @param float $appraisedValue
     */
    public function setAppraisedValue(float $appraisedValue):void
    {
        $this->implementChange($this,'appraisedValue', $this->appraisedValue, $appraisedValue);
    }

    /**
     * @return ?float
     */
    public function getCreditScore():?float { return $this->creditScore; }

    /**
     * @param float $creditScore
     */
    public function setCreditScore(float $creditScore):void
    {
        $this->implementChange($this,'creditScore', $this->creditScore, $creditScore);
    }

    /**
     * @return ?float
     */
    public function getFrontDti():?float { return $this->frontDti; }

    /**
     * @param float $frontDti
     */
    public function setFrontDti(float $frontDti):void
    {
        $this->implementChange($this,'frontDti', $this->frontDti, $frontDti);
    }

    /**
     * @return ?float
     */
    public function getBackDti():?float { return $this->backDti; }

    /**
     * @param float $backDti
     */
    public function setBackDti(float $backDti):void
    {
        $this->implementChange($this,'backDti', $this->backDti, $backDti);
    }

    /**
     * @return ?int
     */
    public function getNumberOfBorrowers():?int { return $this->numberOfBorrowers; }

    /**
     * @param int $numberOfBorrowers
     */
    public function setNumberOfBorrowers(int $numberOfBorrowers):void
    {
        $this->implementChange($this,'numberOfBorrowers', $this->numberOfBorrowers, $numberOfBorrowers);
    }

    /**
     * @return ?int
     */
    public function getFirstTimeBuyer():?int { return $this->firstTimeBuyer; }

    /**
     * @param int $firstTimeBuyer
     */
    public function setFirstTimeBuyer(int $firstTimeBuyer):void
    {
        $this->implementChange($this,'firstTimeBuyer', $this->firstTimeBuyer, $firstTimeBuyer);
    }

    /**
     * @return int
     */
    public function getLienPosition():int { return $this->lienPosition; }

    /**
     * @param int $lienPosition
     */
    public function setLienPosition(int $lienPosition):void
    {
        $this->implementChange($this,'lienPosition', $this->lienPosition, $lienPosition);
    }

    /**
     * @return ?string
     */
    public function getNoteType():?string { return $this->noteType; }

    /**
     * @param string $noteType
     */
    public function setNoteType(string $noteType):void
    {
        $this->implementChange($this,'noteType', $this->noteType, $noteType);
    }

    /**
     * @return string
     */
    public function getLoanType():string { return $this->loanType; }

    /**
     * @param string $loanType
     */
    public function setLoanType(string $loanType):void
    {
        $this->implementChange($this,'loanType', $this->loanType, $loanType);
    }

    /**
     * @return string
     */
    public function getDocumentation():string { return $this->documentation; }

    /**
     * @param string $documentation
     */
    public function setDocumentation(string $documentation):void
    {
        $this->implementChange($this,'documentation', $this->documentation, $documentation);
    }

    /**
     * @return string
     */
    public function getPurpose():string { return $this->purpose; }

    /**
     * @param string $purpose
     */
    public function setPurpose(string $purpose):void
    {
        $this->implementChange($this,'purpose', $this->purpose, $purpose);
    }

    /**
     * @return string
     */
    public function getOccupancy():string { return $this->occupancy; }

    /**
     * @param string $occupancy
     */
    public function setOccupancy(string $occupancy):void
    {
        $this->implementChange($this,'occupancy', $this->occupancy, $occupancy);
    }

    /**
     * @return ?string
     */
    public function getDwelling():?string { return $this->dwelling; }

    /**
     * @param string $dwelling
     */
    public function setDwelling(string $dwelling):void
    {
        $this->implementChange($this,'dwelling', $this->dwelling, $dwelling);
    }

    /**
     * @return ?string
     */
    public function getAddress():?string { return $this->address; }

    /**
     * @param string $address
     */
    public function setAddress(string $address):void
    {
        $this->implementChange($this,'address', $this->address, $address);
    }

    /**
     * @return ?State
     */
    public function getState():?State
    { return $this->state; }

    /**
     * @param State $state
     */
    public function setState(State $state):void
    {
        $this->implementChange($this,'state', $this->state, $state);
    }

    /**
     * @return ?string
     */
    public function getCity():?string { return $this->city; }

    /**
     * @param string $city
     */
    public function setCity(string $city):void
    {
        $this->implementChange($this,'city', $this->city, $city);
    }

    /**
     * @return string
     */
    public function getZip():string { return $this->zip; }

    /**
     * @param string $zip
     */
    public function setZip(string $zip):void
    {
        $this->implementChange($this,'zip', $this->zip, $zip);
    }

    /**
     * @return ?Cbsa
     */
    public function getMsaCode():?Cbsa { return $this->msaCode; }

    /**
     * @param Cbsa $msaCode
     */
    public function setMsaCode(Cbsa $msaCode):void
    {
        $this->implementChange($this,'msaCode', $this->msaCode, $msaCode);
    }

    /**
     * @return ?string
     */
    public function getPaymentString():?string { return $this->paymentString; }

    /**
     * @param string  $paymentString
     */
    public function setPaymentString(string $paymentString):void
    {
        $this->implementChange($this,'paymentString', $this->paymentString, $paymentString);
    }

    /**
     * @return ?float
     */
    public function getServicingfee():?float { return $this->servicingfee; }

    /**
     * @param float  $servicingfee
     */
    public function setServicingfee(float $servicingfee):void
    {
        $this->implementChange($this,'servicingfee', $this->servicingfee, $servicingfee);
    }

    /**
     * @return ?float
     */
    public function getLpmiFee():?float { return $this->lpmiFee; }

    /**
     * @param float $lpmiFee
     */
    public function setLpmiFee(float $lpmiFee):void
    {
        $this->implementChange($this,'lpmiFee', $this->lpmiFee, $lpmiFee);
    }

    /**
     * @return ?float
     */
    public function getMiCoverage():?float { return $this->miCoverage; }

    /**
     * @param float $miCoverage
     */
    public function setMiCoverage(float $miCoverage):void
    {
        $this->implementChange($this,'miCoverage', $this->miCoverage, $miCoverage);
    }

    /**
     * @return ?AmortAttribute
     */
    public function getAmortization():?AmortAttribute { return $this->amortization; }

    /**
     * @param AmortAttribute $amortization
     * @throws \Exception
     */
    public function setAmortization(AmortAttribute $amortization):void
    {
        $this->implementChange($this,'amortization', $this->amortization, $amortization);
    }

    /**
     * @return ?DescAttribute
     */
    public function getDescription():?DescAttribute { return $this->description; }

    /**
     * @param DescAttribute  $description
     * @throws \Exception
     */
    public function setDescription(DescAttribute $description):void
    {
        $this->description = $description;
    }

    /**
     * @return ?\dateTime
     */
    public function getForeclosureDate():?\dateTime { return $this->foreclosureDate; }

    /**
     * @param \dateTime $foreclosureDate
     */
    public function setForeclosureDate(\DateTime $foreclosureDate)
    {
        $this->implementChange($this,'foreclosureDate', $this->foreclosureDate, $foreclosureDate);
    }

    /**
     * @return \dateTime|null
     */
    public function getBankruptcyDate():?\dateTime { return $this->bankruptcyDate; }

    /**
     * @param \DateTime $bankruptcyDate
     */
    public function setBankruptcyDate(\DateTime $bankruptcyDate):void
    {
        $this->implementChange($this,'bankruptcyDate', $this->bankruptcyDate, $bankruptcyDate);
    }

    /**
     * @return \DateTime|null
     */
    public function getReoDate():?\dateTime { return $this->reoDate; }

    /**
     * @param mixed $reoDate
     */
    public function setReoDate(\DateTime $reoDate):void
    {
        $this->implementChange($this,'reoDate', $this->reoDate, $reoDate);
    }

    /**
     * @return \dateTime
     */
    public function getZeroBalanceDate():?\dateTime { return $this->zeroBalanceDate; }

    /**
     * @param \dateTime $zeroBalanceDate
     */
    public function setZeroBalanceDate(\DateTime $zeroBalanceDate):void
    {
        $this->implementChange($this,'zeroBalanceDate', $this->zeroBalanceDate, $zeroBalanceDate);
    }

    /**
     * @return null|ArrayCollection|PersistentCollection
     */
    public function getUpdates():null|ArrayCollection|PersistentCollection { return $this->updates; }

    /**
     * @param ArrayCollection|PersistentCollection $updates
     */
    public function setUpdates(ArrayCollection|PersistentCollection $updates) { $this->updates = $updates; }

    /**
     * @return ?int
     */
    public function getSeasoning():?int { return $this->seasoning; }

    /**
     * @param int $seasoning
     */
    public function setSeasoning(int $seasoning)
    {
        $this->implementChange($this,'seasoning', $this->seasoning, $seasoning);
    }

    /**
     * @return null|ArrayCollection|PersistentCollection
     */
    public function getBids():null|ArrayCollection|PersistentCollection { return $this->bids; }

    /**
     * @param ArrayCollection|PersistentCollection $bids
     */
    public function setBids(ArrayCollection|PersistentCollection $bids) { $this->bids = $bids; }

    /**
     * @return null|ArrayCollection|PersistentCollection
     */
    public function getIssues():null|ArrayCollection|PersistentCollection { return $this->issues; }

    /**
     * @return number
     */
    public function getLoanHasBeenModified(): int { return $this->loanHasBeenModified; }

    /**
     * @param int $loanHasBeenModified
     */
    public function setLoanHasBeenModified(int $loanHasBeenModified)
    {
        $this->implementChange($this,'loanHasBeenModified', $this->loanHasBeenModified, $loanHasBeenModified);
    }

    /**
     * @return ?int
     */
    public function getEndModPeriod(): ?int { return $this->endModPeriod; }

    /**
     * @param int $endModPeriod
     */
    public function setEndModPeriod(int $endModPeriod)
    {
        $this->implementChange($this,'endModPeriod', $this->endModPeriod, $endModPeriod);
    }

    /**
     * @return ?string
     */
    public function getChannel():?string { return $this->channel; }

    /**
     * @param string $channel
     */
    public function setChannel(string $channel)
    {
        $this->implementChange($this,'channel', $this->channel, $channel);
    }

    /**
     * @return ?\DateTime
     */
    public function getLastPaymentDate():?\DateTime { return $this->lastPaymentDate; }

    /**
     * @param \DateTime $lastPaymentDate
     */
    public function setLastPaymentDate(\DateTime $lastPaymentDate):void
    {
        $this->implementChange($this,'lastPaymentDate', $this->lastPaymentDate, $lastPaymentDate);
    }

    /**
     * @return ?int
     */
    public function getTimes30():?int { return $this->times_30; }

    /**
     * @param int $times_30
     */
    public function setTimes30(int $times_30):void
    {
        $this->implementChange($this,'times_30', $this->times_30, $times_30);
    }

    /**
     * @return ?int
     */
    public function getTimes60():?int { return $this->times_60; }

    /**
     * @param int $times_60
     */
    public function setTimes60(int $times_60):void
    {
        $this->implementChange($this,'times_60', $this->times_60, $times_60);
    }

    /**
     * @return ?int
     */
    public function getTimes90():?int { return $this->times_90; }

    /**
     * @param int $times_90
     */
    public function setTimes90(int $times_90):void
    {
        $this->implementChange($this,'times_90', $this->times_90, $times_90);
    }

    /**
     * @return ?int
     */
    public function getYearBuilt():?int { return $this->yearBuilt; }

    /**
     * @param int $yearBuilt
     */
    public function setYearBuilt(int $yearBuilt):void
    {
        $this->yearBuilt = $yearBuilt;
    }

    /**
     * @return ?string
     */
    public function getNewVsUsed():?string { return $this->newVsUsed; }

    /**
     * @param string $newVsUsed
     */
    public function setNewVsUsed(string $newVsUsed):void
    {
        $this->newVsUsed = $newVsUsed;
    }

    /**
     * @return ?float
     */
    public function getReserves():?float { return $this->reserves; }

    /**
     * @param float $reserves
     */
    public function setReserves(float $reserves):void
    {
        $this->reserves = $reserves;
    }

    /**
     * @return ?float
     */
    public function getDealerReserve():?float { return $this->dealerReserve; }

    /**
     * @param float $dealerReserve
     */
    public function setDealerReserve(float $dealerReserve):void
    {
        $this->dealerReserve = $dealerReserve;
    }

    /**
     * @return ?ArrayCollection|PersistentCollection
     */
    public function getReviewStatuses(): ArrayCollection|PersistentCollection|null
    { return $this->reviewStatuses; }

    /**
     * @return ?int
     */
    public function getPrepayPenaltyTerm():?int { return $this->prepayPenaltyTerm; }

    /**
     * @param int $prepayPenaltyTerm
     */
    public function setPrepayPenaltyTerm(int $prepayPenaltyTerm):void
    {
        $this->implementChange($this,'prepayPenaltyTerm', $this->prepayPenaltyTerm, $prepayPenaltyTerm);
    }

    /**
     * @return ?float
     */
    public function getPrepayPenalty():?float {  return $this->prepayPenalty; }

    /**
     * @param float $prepayPenalty
     */
    public function setPrepayPenalty(float $prepayPenalty):void
    {
        $this->implementChange($this,'prepayPenalty', $this->prepayPenalty, $prepayPenalty);
    }

    /**
     * @return ?array
     */
    public function getPrepayStepDown(): ?array { return $this->prepayStepDown; }

    /**
     * @param array $prepayStepDown
     */
    public function setPrepayStepDown(array $prepayStepDown)
    {
        $string = json_encode($prepayStepDown);
        $this->implementChange($this,'prepayStepDown', $this->prepayStepDown, $string);
    }

    /**
     * @return ArmAttribute|null
     */
    public function getArmAttributes():?ArmAttribute { return $this->armAttributes; }

    /**
     * @return CommAttribute|null
     */
    public function getCommAttributes():?CommAttribute { return $this->commAttributes; }

    /**
     * @return SaleAttribute|null
     */
    public function getSaleAttributes():?SaleAttribute { return $this->saleAttributes; }


}