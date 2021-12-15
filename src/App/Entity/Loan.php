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

/**
 * @ORM\Entity(repositoryClass="\App\Repository\Loan")
 * @ORM\Table(name="loans")
 * @ChangeTrackingPolicy("NOTIFY")
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


    protected static $amortTypes = array(
        self::AMORTIZING => 'Amortizing',
        self::REVOLVING  =>  'Revolving',
        //self::AMORTIZING => 'Amortizing',
    );

    protected static $descriptions = array(
        self::ASSUMED => 'Assumed',
        self::ACTUAL  => 'Actual'
    );

    protected $ignoreDbProperties = [
        'bids' => null, 'updates' => null, 'accounts' => null, 'specifics' => null,
        'triggers' => null, 'fees' => null, 'files' => 'null', 'issues' => null
    ];

    protected $addUcIdToPropName = [
        'pool' => null,
        'amortization' => null,
        'description' => null,
        'state' => null,
        'msaCode' => null
    ];

    protected $defaultValueProperties = [
        'msaCode' => null,
        'seasoning' => null,
        'remainingTerm' => null,
    ];

    /** @ORM\Id @ORM\Column(type="integer") @ORM\GeneratedValue **/
    protected $id;

    /** @ORM\Column(type="string", nullable=false) **/
    protected $loanId;


    /**
     * @ORM\OneToOne(targetEntity = "\App\Entity\Loan\ArmAttribute", mappedBy="loan")
     * @var \App\Entity\Loan\ArmAttribute
     */
    protected $armAttributes;

    /**
     * @ORM\OneToOne(targetEntity = "\App\Entity\Loan\CommAttribute", mappedBy="loan")
     * @var \App\Entity\Loan\CommAttribute
     */
    protected $commAttributes;

    /**
     * @ORM\OneToOne(targetEntity = "\App\Entity\Loan\SaleAttribute", mappedBy="loan")
     * @var \App\Entity\Loan\SaleAttribute
     */
    protected $saleAttributes;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\Pool", inversedBy = "loans")
     * @ORM\JoinColumn(name="pool_id", referencedColumnName="id", nullable=false)
     * @var \App\Entity\Pool
     **/
    protected $pool;

    /** @ORM\Column(type="decimal", precision=16, scale=3, nullable=false) */
    protected $originalBalance = 0.0;

    /** @ORM\Column(type="decimal", precision=16, scale=3, nullable=false) */
    protected $currentBalance = 0.0;

    /** @ORM\Column(type="decimal", precision=16, scale=3, nullable=true) **/
    protected $monthlyPayment = null;

    /** @ORM\Column(type="decimal", precision=16, scale=3, nullable=true) **/
    protected $issuanceBalance;

    /** @ORM\Column(type="decimal", precision=10, scale=6, nullable=true) **/
    protected $initialRate;

    /** @ORM\Column(type="integer", nullable=true) **/
    protected $seasoning;

    /** @ORM\Column(type="decimal", precision=10, scale=6, nullable=false) **/
    protected $currentRate;

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

    /** @ORM\Column(type="string", nullable=false) **/
    protected $loanStatus;

    /**
     * @ORM\Column(type = "datetime", nullable=false)
     * @var \DateTime
     **/
    protected $finalDueforDate;

    /** @ORM\Column(type="decimal", precision=14, scale=2, nullable=false) **/
    protected $originalTerm;

    /** @ORM\Column(type="decimal", precision=14, scale=2, nullable=true) **/
    protected $remainingTerm;

    /** @ORM\Column(type="decimal", precision=14, scale=2, nullable=false) **/
    protected $amortizationTerm;

    /** @ORM\Column(type="decimal", precision=14, scale=2, nullable=true) **/
    protected $ioTerm;

    /** @ORM\Column(type="integer", nullable=true) **/
    protected $balloonPeriod;

    /** @ORM\Column(type="decimal", precision=8, scale=4, nullable=false)
     * @var number
     **/
    protected $originalLtv;

    /**
     * @ORM\Column(type="decimal", precision=8, scale=4, nullable=true)
     *
     **/
    protected $originalCltv;

    /**
     * @ORM\Column(type="decimal", precision=16, scale=4, nullable=false)
     *
     **/
    protected $appraisedValue;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=4, nullable=true)
     **/
    protected $creditScore;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=4, nullable=true)
     * @var number
     **/
    protected $frontDti;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=4, nullable=true)
     * @var number
     **/
    protected $backDti;

    /** @ORM\Column(type = "integer", nullable=true) **/
    protected $numberOfBorrowers;

    /** @ORM\Column(type = "integer", nullable=true) **/
    protected $firstTimeBuyer;

    /** @ORM\Column(type="integer", nullable=false) **/
    protected $lienPosition;

    /** @ORM\Column(type="string", nullable=true) **/
    protected $noteType;

    /** @ORM\Column(type="string", nullable=false) **/
    protected $loanType;

    /** @ORM\Column(type="string", nullable=false) **/
    protected $documentation;

    /** @ORM\Column(type="string", nullable=false) **/
    protected $purpose;

    /** @ORM\Column(type="string", nullable=false) **/
    protected $occupancy;

    /** @ORM\Column(type="string", nullable=true) **/
    protected $dwelling;

    /** @ORM\Column(type="string", nullable=true) **/
    protected $address;

    /** @ORM\ManyToOne(targetEntity="App\Entity\Data\State", inversedBy="loans") **/
    protected $state;

    /** @ORM\Column(type="string", nullable=true) **/
    protected $city;

    /** @ORM\Column(type="string", nullable=false) **/
    protected $zip;


    /** @ORM\Column(type="json", nullable=true) **/
    protected $assetAttributes;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Data\Cbsa", inversedBy="loans")
     * @var string
     **/
    protected $msaCode;

    /** @ORM\Column(type="string", nullable=true) **/
    protected $paymentString;

    /** @ORM\Column(type="decimal", precision=14, scale=6, nullable = true) **/
    protected $servicingfee;

    /** @ORM\Column(type="decimal", precision=14, scale=6, nullable = true) **/
    protected $lpmiFee;

    /** @ORM\Column(type="decimal", precision=10, scale=4, nullable = true) **/
    protected $miCoverage;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\Loan\AmortAttribute", inversedBy="loans")
     * @var  \App\Entity\Loan\AmortAttribute */
    protected $amortization;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\Loan\DescAttribute", inversedBy="loans")
     * @var  \App\Entity\Loan\DescAttribute */
    protected $description;

    /**
     * @ORM\Column(type = "datetime", nullable=true)
     * @var \dateTime
     **/
    protected $foreclosureDate;

    /**
     * @ORM\Column(type = "datetime", nullable=true)
     * @var \dateTime
     **/
    protected $bankruptcyDate;

    /** @ORM\Column(type = "datetime", nullable=true)
     * @var \dateTime
     **/
    protected $reoDate;

    /**
     * @ORM\Column(type = "datetime", nullable=true)
     * @var \dateTime
     **/
    protected $zeroBalanceDate;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @var int $loanHasBeenModified
     */
    protected $loanHasBeenModified;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @var int $lengthOfModification
     */
    protected $endModPeriod;

    /** @ORM\Column(type="string", nullable=true) **/
    protected $channel;

    /** @ORM\Column(type="datetime", nullable=true) **/
    protected $lastPaymentDate;

    /** @ORM\Column(type="integer", nullable=true)   */
    protected $times_30;

    /** @ORM\Column(type="integer", nullable=true)   */
    protected $times_60;

    /** @ORM\Column(type="integer", nullable=true)   */
    protected $times_90;

    /** @ORM\Column(type="integer", nullable=true) **/
    protected $yearBuilt;

    /** @ORM\Column(type="string", nullable=true) **/
    protected $newVsUsed;

    /** @ORM\Column(type="decimal", precision=8, scale=2, nullable = true) **/
    protected $reserves;

    /** @ORM\Column(type="decimal", precision=8, scale=2, nullable = true) **/
    protected $dealerReserve;

    /** @ORM\Column(type="integer", nullable=true)   */
    protected $prepayPenaltyTerm;

    /** @ORM\Column(type="decimal", precision=8, scale=2, nullable = true) **/
    protected $prepayPenalty;

    /** @ORM\Column(type="json", nullable=true)
     * @var array
     **/
    protected $prepayStepDown;

    /** @ORM\ManyToMany(targetEntity="App\Entity\Bid", mappedBy="loans")   */
    protected $bids;

    /** @ORM\OneToMany(targetEntity="\App\Entity\Update\LoanUpdate", mappedBy="loan") */
    protected $updates;

    /** @ORM\ManyToMany(targetEntity="\App\Entity\Typed\ShelfSpecific\LoanSpecific", mappedBy="loans")   */
    protected $specifics;

    /** @ORM\ManyToMany(targetEntity="\App\Entity\Typed\Fee\LoanFee", mappedBy="loans")   */
    protected $fees;

    /** @ORM\ManyToMany(targetEntity="\App\Entity\Typed\Account\LoanAccount", mappedBy="loans")   */
    protected $accounts;

    /** @ORM\ManyToMany(targetEntity="\App\Entity\Typed\Trigger\LoanTrigger", mappedBy="loans")   */
    protected $triggers;

    /**
     * @ORM\OneToMany(targetEntity="\App\Entity\DealFile", mappedBy="loan")
     * @var ArrayCollection
     */
    protected $files;

    /**
     * @ORM\OneToMany(targetEntity="\App\Entity\DueDilLoanStatus", mappedBy="loan")
     * @var ArrayCollection
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
     * @return mixed
     */
    public function getId() { return $this->id; }

    /**
     * @return mixed
     */
    public function getLoanId() { return $this->loanId; }

    /**
     * @param mixed $loanId
     */
    public function setLoanId($loanId)
    {
        $this->implementChange($this,'loanId', $this->loanId, $loanId);
    }

    /**
     * @return Pool
     */
    public function getPool() { return $this->pool; }

    /**
     * @param Pool $pool
     */
    public function setPool(Pool $pool)
    {
        $this->implementChange($this,'pool', $this->pool, $pool);
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
    public function getCurrentBalance() { return $this->currentBalance; }

    /**
     * @param mixed $currentBalance
     */
    public function setCurrentBalance($currentBalance)
    {
        $this->implementChange($this,'currentBalance', $this->currentBalance, $currentBalance);
    }

    /**
     * @return mixed
     */
    public function getMonthlyPayment() { return $this->monthlyPayment; }

    /**
     * @param mixed $monthlyPayment
     */
    public function setMonthlyPayment($monthlyPayment)
    {
        $this->implementChange($this,'monthlyPayment', $this->monthlyPayment, $monthlyPayment);
    }

    /**
     * @return mixed
     */
    public function getIssuanceBalance() { return $this->issuanceBalance; }

    /**
     * @param mixed $issuanceBalance
     */
    public function setIssuanceBalance($issuanceBalance)
    {
        $this->implementChange($this,'issuanceBalance', $this->issuanceBalance, $issuanceBalance);
    }

    /**
     * @return mixed
     */
    public function getInitialRate() { return $this->initialRate; }

    /**
     * @param mixed $initialRate
     */
    public function setInitialRate($initialRate)
    {
        $this->implementChange($this,'initialRate', $this->initialRate, $initialRate);
    }

    /**
     * @return mixed
     */
    public function getCurrentRate() { return $this->currentRate; }

    /**
     * @param mixed $currentRate
     */
    public function setCurrentRate($currentRate)
    {
        $this->implementChange($this,'currentRate', $this->currentRate, $currentRate);
    }

    /**
     * @return \DateTime|null
     */
    public function getOriginationDate() { return $this->originationDate; }

    /**
     * @param \DateTime $originationDate
     */
    public function setOriginationDate(\DateTime $originationDate)
    {
        $this->implementChange($this,'originationDate', $this->originationDate, $originationDate);
    }

    /**
     * @return \DateTime | null
     */
    public function getCurrentDueforDate() { return $this->currentDueforDate; }

    /**
     * @param \DateTime $currentDueforDate
     */
    public function setCurrentDueforDate(\DateTime $currentDueforDate)
    {
        $this->implementChange($this,'currentDueforDate', $this->currentDueforDate, $currentDueforDate);
    }

    /**
     * @return mixed
     */
    public function getFirstPaymentDate() { return $this->firstPaymentDate; }

    /**
     * @param \DateTime $firstPaymentDate
     */
    public function setFirstPaymentDate(\DateTime $firstPaymentDate)
    {
        $this->implementChange($this,'firstPaymentDate', $this->firstPaymentDate, $firstPaymentDate);
    }

    /**
     * @return mixed
     */
    public function getLoanStatus() { return $this->loanStatus; }

    /**
     * @param mixed $loanStatus
     */
    public function setLoanStatus($loanStatus)
    {
        $this->implementChange($this,'loanStatus', $this->loanStatus, $loanStatus);
    }

    /**
     * @return \DateTime|null
     */
    public function getFinalDueforDate() { return $this->finalDueforDate; }

    /**
     * @param \DateTime $finalDueforDate
     */
    public function setFinalDueforDate(\DateTime $finalDueforDate)
    {
        $this->implementChange($this,'finalDueforDate', $this->finalDueforDate, $finalDueforDate);
    }

    /**
     * @return mixed
     */
    public function getOriginalTerm() { return $this->originalTerm; }

    /**
     * @param mixed $originalTerm
     */
    public function setOriginalTerm($originalTerm)
    {
        $this->implementChange($this,'originalTerm', $this->originalTerm, $originalTerm);
    }

    /**
     * @return mixed
     */
    public function getRemainingTerm() { return $this->remainingTerm; }

    /**
     * @param mixed $remainingTerm
     */
    public function setRemainingTerm($remainingTerm)
    {
        $this->implementChange($this,'remainingTerm', $this->remainingTerm, $remainingTerm);
    }

    /**
     * @return mixed
     */
    public function getAmortizationTerm() { return $this->amortizationTerm; }

    /**
     * @param mixed $amortizationTerm
     */
    public function setAmortizationTerm($amortizationTerm)
    {
        $this->implementChange($this,'amortizationTerm', $this->amortizationTerm, $amortizationTerm);
    }

    /**
     * @return mixed
     */
    public function getIoTerm() { return $this->ioTerm; }

    /**
     * @param mixed $ioTerm
     */
    public function setIoTerm($ioTerm)
    {
        $this->implementChange($this,'ioTerm', $this->ioTerm, $ioTerm);
    }

    /**
     * @return mixed
     */
    public function getBalloonPeriod() { return $this->balloonPeriod; }

    /**
     * @param mixed $balloonPeriod
     */
    public function setBalloonPeriod($balloonPeriod)
    {
        $this->implementChange($this,'balloonPeriod', $this->balloonPeriod, $balloonPeriod);
    }

    /**
     * @return mixed
     */
    public function getOriginalLtv() { return $this->originalLtv; }

    /**
     * @param mixed $originalLtv
     */
    public function setOriginalLtv($originalLtv)
    {
        $this->implementChange($this,'originalLtv', $this->originalLtv, $originalLtv);
    }

    /**
     * @return mixed
     */
    public function getOriginalCltv() { return $this->originalCltv; }

    /**
     * @param mixed $originalCltv
     */
    public function setOriginalCltv($originalCltv)
    {
        $this->implementChange($this,'originalCltv', $this->originalCltv, $originalCltv);
    }

    /**
     * @return mixed
     */
    public function getAppraisedValue() { return $this->appraisedValue; }

    /**
     * @param mixed $appraisedValue
     */
    public function setAppraisedValue($appraisedValue)
    {
        $this->implementChange($this,'appraisedValue', $this->appraisedValue, $appraisedValue);
    }

    /**
     * @return mixed
     */
    public function getCreditScore() { return $this->creditScore; }

    /**
     * @param mixed $creditScore
     */
    public function setCreditScore($creditScore)
    {
        $this->implementChange($this,'creditScore', $this->creditScore, $creditScore);
    }

    /**
     * @return number
     */
    public function getFrontDti() { return $this->frontDti; }

    /**
     * @param number $frontDti
     */
    public function setFrontDti($frontDti)
    {
        $this->implementChange($this,'frontDti', $this->frontDti, $frontDti);
    }

    /**
     * @return number
     */
    public function getBackDti() { return $this->backDti; }

    /**
     * @param number $backDti
     */
    public function setBackDti($backDti)
    {
        $this->implementChange($this,'backDti', $this->backDti, $backDti);
    }

    /**
     * @return mixed
     */
    public function getNumberOfBorrowers() { return $this->numberOfBorrowers; }

    /**
     * @param mixed $numberOfBorrowers
     */
    public function setNumberOfBorrowers($numberOfBorrowers)
    {
        $this->implementChange($this,'numberOfBorrowers', $this->numberOfBorrowers, $numberOfBorrowers);
    }

    /**
     * @return mixed
     */
    public function getFirstTimeBuyer() { return $this->firstTimeBuyer; }

    /**
     * @param mixed $firstTimeBuyer
     */
    public function setFirstTimeBuyer($firstTimeBuyer)
    {
        $this->implementChange($this,'firstTimeBuyer', $this->firstTimeBuyer, $firstTimeBuyer);
    }

    /**
     * @return mixed
     */
    public function getLienPosition() { return $this->lienPosition; }

    /**
     * @param mixed $lienPosition
     */
    public function setLienPosition($lienPosition)
    {
        $this->implementChange($this,'lienPosition', $this->lienPosition, $lienPosition);
    }

    /**
     * @return mixed
     */
    public function getNoteType() { return $this->noteType; }

    /**
     * @param mixed $noteType
     */
    public function setNoteType($noteType)
    {
        $this->implementChange($this,'noteType', $this->noteType, $noteType);
    }

    /**
     * @return mixed
     */
    public function getLoanType() { return $this->loanType; }

    /**
     * @param mixed $loanType
     */
    public function setLoanType($loanType)
    {
        $this->implementChange($this,'loanType', $this->loanType, $loanType);
    }

    /**
     * @return mixed
     */
    public function getDocumentation() { return $this->documentation; }

    /**
     * @param mixed $documentation
     */
    public function setDocumentation($documentation)
    {
        $this->implementChange($this,'documentation', $this->documentation, $documentation);
    }

    /**
     * @return mixed
     */
    public function getPurpose() { return $this->purpose; }

    /**
     * @param mixed $purpose
     */
    public function setPurpose($purpose)
    {
        $this->implementChange($this,'purpose', $this->purpose, $purpose);
    }

    /**
     * @return mixed
     */
    public function getOccupancy() { return $this->occupancy; }

    /**
     * @param mixed $occupancy
     */
    public function setOccupancy($occupancy)
    {
        $this->implementChange($this,'occupancy', $this->occupancy, $occupancy);
    }

    /**
     * @return mixed
     */
    public function getDwelling() { return $this->dwelling; }

    /**
     * @param mixed $dwelling
     */
    public function setDwelling($dwelling)
    {
        $this->implementChange($this,'dwelling', $this->dwelling, $dwelling);
    }

    /**
     * @return mixed
     */
    public function getAddress() { return $this->address; }

    /**
     * @param mixed $address
     */
    public function setAddress($address)
    {
        $this->implementChange($this,'address', $this->address, $address);
    }

    /**
     * @return mixed
     */
    public function getState()
    { return $this->state; }

    /**
     * @param mixed $state
     */
    public function setState($state)
    {
        $this->implementChange($this,'state', $this->state, $state);
    }

    /**
     * @return mixed
     */
    public function getCity() { return $this->city; }

    /**
     * @param mixed $city
     */
    public function setCity($city)
    {
        $this->implementChange($this,'city', $this->city, $city);
    }

    /**
     * @return mixed
     */
    public function getZip() { return $this->zip; }

    /**
     * @param mixed $zip
     */
    public function setZip($zip)
    {
        $this->implementChange($this,'zip', $this->zip, $zip);
    }

    /**
     * @return string
     */
    public function getMsaCode() { return $this->msaCode; }

    /**
     * @param string $msaCode
     */
    public function setMsaCode($msaCode)
    {
        $this->implementChange($this,'msaCode', $this->msaCode, $msaCode);
    }

    /**
     * @return mixed
     */
    public function getPaymentString() { return $this->paymentString; }

    /**
     * @param mixed $paymentString
     */
    public function setPaymentString($paymentString)
    {
        $this->implementChange($this,'paymentString', $this->paymentString, $paymentString);
    }

    /**
     * @return mixed
     */
    public function getServicingfee() { return $this->servicingfee; }

    /**
     * @param mixed $servicingfee
     */
    public function setServicingfee($servicingfee)
    {
        $this->implementChange($this,'servicingfee', $this->servicingfee, $servicingfee);
    }

    /**
     * @return mixed
     */
    public function getLpmiFee() { return $this->lpmiFee; }

    /**
     * @param mixed $lpmiFee
     */
    public function setLpmiFee($lpmiFee)
    {
        $this->implementChange($this,'lpmiFee', $this->lpmiFee, $lpmiFee);
    }

    /**
     * @return mixed
     */
    public function getMiCoverage() { return $this->miCoverage; }

    /**
     * @param mixed $miCoverage
     */
    public function setMiCoverage($miCoverage)
    {
        $this->implementChange($this,'miCoverage', $this->miCoverage, $miCoverage);
    }

    /**
     * @return string
     */
    public function getAmortization() { return $this->amortization; }

    /**
     * @param $amortization
     * @throws \Exception
     */
    public function setAmortization($amortization)
    {
        if(!array_key_exists(ucfirst(strtolower($amortization)), self::$amortTypes)){
            throw new \Exception("An amortization type: $amortization does not exist.");
        }
        $this->implementChange($this,'amortization', $this->amortization, $amortization);
    }

    /**
     * @return string
     */
    public function getDescription() { return $this->description; }

    /**
     * @param $description
     * @throws \Exception
     */
    public function setDescription($description)
    {
        if(!array_key_exists(ucfirst(strtolower($description)), self::$descriptions)){
            throw new \Exception("A loan description type: $description does not exist.");
        }
        $this->description = $description;
    }

    /**
     * @return \dateTime
     */
    public function getForeclosureDate() { return $this->foreclosureDate; }

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
    public function getBankruptcyDate() { return $this->bankruptcyDate; }

    /**
     * @param \DateTime $bankruptcyDate
     */
    public function setBankruptcyDate(\DateTime $bankruptcyDate)
    {
        $this->implementChange($this,'bankruptcyDate', $this->bankruptcyDate, $bankruptcyDate);
    }

    /**
     * @return \DateTime|null
     */
    public function getReoDate() { return $this->reoDate; }

    /**
     * @param mixed $reoDate
     */
    public function setReoDate(\DateTime $reoDate)
    {
        $this->implementChange($this,'reoDate', $this->reoDate, $reoDate);
    }

    /**
     * @return \dateTime
     */
    public function getZeroBalanceDate() { return $this->zeroBalanceDate; }

    /**
     * @param \dateTime $zeroBalanceDate
     */
    public function setZeroBalanceDate(\DateTime $zeroBalanceDate)
    {
        $this->implementChange($this,'zeroBalanceDate', $this->zeroBalanceDate, $zeroBalanceDate);
    }

    /**
     * @return mixed
     */
    public function getUpdates() { return $this->updates; }

    /**
     * @param mixed $updates
     */
    public function setUpdates($updates) { $this->updates = $updates; }

    /**
     * @return mixed
     */
    public function getSeasoning() { return $this->seasoning; }

    /**
     * @param mixed $seasoning
     */
    public function setSeasoning($seasoning)
    {
        $this->implementChange($this,'seasoning', $this->seasoning, $seasoning);
    }

    /**
     * @return mixed
     */
    public function getBids() { return $this->bids; }

    /**
     * @param mixed $bids
     */
    public function setBids($bids) { $this->bids = $bids; }

    /**
     * @return ArrayCollection
     */
    public function getIssues() { return $this->issues; }

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
     * @return number
     */
    public function getEndModPeriod(): int { return $this->endModPeriod; }

    /**
     * @param number $endModPeriod
     */
    public function setEndModPeriod(int $endModPeriod)
    {
        $this->implementChange($this,'endModPeriod', $this->endModPeriod, $endModPeriod);
    }

    /**
     * @return mixed
     */
    public function getChannel() { return $this->channel; }

    /**
     * @param mixed $channel
     */
    public function setChannel($channel)
    {
        $this->implementChange($this,'channel', $this->channel, $channel);
    }

    /**
     * @return mixed
     */
    public function getLastPaymentDate() { return $this->lastPaymentDate; }

    /**
     * @param mixed $lastPaymentDate
     */
    public function setLastPaymentDate($lastPaymentDate)
    {
        $this->implementChange($this,'lastPaymentDate', $this->lastPaymentDate, $lastPaymentDate);
    }

    /**
     * @return mixed
     */
    public function getTimes30() { return $this->times_30; }

    /**
     * @param mixed $times_30
     */
    public function setTimes30($times_30)
    {
        $this->implementChange($this,'times_30', $this->times_30, $times_30);
    }

    /**
     * @return mixed
     */
    public function getTimes60() { return $this->times_60; }

    /**
     * @param mixed $times_60
     */
    public function setTimes60($times_60)
    {
        $this->implementChange($this,'times_60', $this->times_60, $times_60);
    }

    /**
     * @return mixed
     */
    public function getTimes90() { return $this->times_90; }

    /**
     * @param mixed $times_90
     */
    public function setTimes90($times_90)
    {
        $this->implementChange($this,'times_90', $this->times_90, $times_90);
    }

    /**
     * @return mixed
     */
    public function getYearBuilt() { return $this->yearBuilt; }

    /**
     * @param mixed $yearBuilt
     */
    public function setYearBuilt($yearBuilt)
    {
        $this->yearBuilt = $yearBuilt;
    }

    /**
     * @return mixed
     */
    public function getNewVsUsed() { return $this->newVsUsed; }

    /**
     * @param mixed $newVsUsed
     */
    public function setNewVsUsed($newVsUsed)
    {
        $this->newVsUsed = $newVsUsed;
    }

    /**
     * @return mixed
     */
    public function getReserves() { return $this->reserves; }

    /**
     * @param mixed $reserves
     */
    public function setReserves($reserves)
    {
        $this->reserves = $reserves;
    }

    /**
     * @return mixed
     */
    public function getDealerReserve() { return $this->dealerReserve; }

    /**
     * @param mixed $dealerReserve
     */
    public function setDealerReserve($dealerReserve)
    {
        $this->dealerReserve = $dealerReserve;
    }

    /**
     * @return mixed
     */
    public function getReviewStatuses() { return $this->reviewStatuses; }

    /**
     * @return mixed
     */
    public function getPrepayPenaltyTerm() { return $this->prepayPenaltyTerm; }

    /**
     * @param mixed $prepayPenaltyTerm
     */
    public function setPrepayPenaltyTerm($prepayPenaltyTerm)
    {
        $this->implementChange($this,'prepayPenaltyTerm', $this->prepayPenaltyTerm, $prepayPenaltyTerm);
    }

    /**
     * @return mixed
     */
    public function getPrepayPenalty(){  return $this->prepayPenalty; }

    /**
     * @param mixed $prepayPenalty
     */
    public function setPrepayPenalty($prepayPenalty)
    {
        $this->implementChange($this,'prepayPenalty', $this->prepayPenalty, $prepayPenalty);
    }

    /**
     * @return array
     */
    public function getPrepayStepDown(): array { return $this->prepayStepDown; }

    /**
     * @param array $prepayStepDown
     */
    public function setPrepayStepDown(array $prepayStepDown)
    {
        $string = json_encode($prepayStepDown);
        $this->implementChange($this,'prepayStepDown', $this->prepayStepDown, $string);
    }

    /**
     * @return Loan\ArmAttribute|null
     */
    public function getArmAttributes() { return $this->armAttributes; }

    /**
     * @return Loan\CommAttribute|null
     */
    public function getCommAttributes() { return $this->commAttributes; }

    /**
     * @return Loan\SaleAttribute|null
     */
    public function getSaleAttributes() { return $this->saleAttributes; }


}