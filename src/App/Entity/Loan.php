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

/**
 * @ORM\Entity(repositoryClass="\App\Repository\Loan")
 * @ORM\MappedSuperClass
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
abstract class Loan implements NotifyPropertyChanged
{
    use NotifyChangeTrait, CreatePropertiesArrayTrait;

    abstract public function getAssetAttributes();

    const AMORTIZING = 'Amortizing';
    const REVOLVING  = 'Revolving';
    const PARTIAL    = 'RevolvingToAmortizing';

    const ASSUMED = 'Assumed';
    const ACTUAL  = 'Actual';


    protected static $amortTypes = array(
        self::AMORTIZING => 'Amortizing',
        self::REVOLVING  =>  'Revolving',
        self::AMORTIZING => 'Amortizing',
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

    /** @ORM\Column(type="decimal", precision=10, scale=6, nullable=false) **/
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
     * @ORM\Column(type="decimal", precision=8, scale=4, nullable=false)
     *
     **/
    protected $originalCltv;

    /**
     * @ORM\Column(type="decimal", precision=16, scale=4, nullable=false)
     *
     **/
    protected $appraisedValue;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=4, nullable=false)
     **/
    protected $creditScore;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=4, nullable=true)
     * @var number
     **/
    protected $frontDti;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=4, nullable=false)
     * @var number
     **/
    protected $backDti;

    /** @ORM\Column(type = "integer", nullable=true) **/
    protected $numberOfBorrowers;

    /** @ORM\Column(type = "integer", nullable=true) **/
    protected $firstTimeBuyer;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\LienType", inversedBy="loans")
     * @ORM\JoinColumn(name="lien_position", referencedColumnName="id", nullable=false)
     * @var LienType
     **/
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


    /** @ORM\Column(type="string", nullable=true) **/
    protected $assetAttributes = '';

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
     * @var number $loanHasBeenModified
     */
    protected $loanHasBeenModified;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @var number $lengthOfModification
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
     * @ORM\OneToMany(targetEntity="\App\Entity\Message", mappedBy="loan")
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
    }

    function addIssue(Message $issue)
    {
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
        $this->_onPropertyChanged('loanId', $this->loanId, $loanId);
        $this->loanId = $loanId;
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
        $this->_onPropertyChanged('pool', $this->pool, $pool);
        $this->pool = $pool;
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
    public function getCurrentBalance() { return $this->currentBalance; }

    /**
     * @param mixed $currentBalance
     */
    public function setCurrentBalance($currentBalance)
    {
        $this->_onPropertyChanged('currentBalance', $this->currentBalance, $currentBalance);
        $this->currentBalance = $currentBalance;
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
        $this->_onPropertyChanged('monthlyPayment', $this->monthlyPayment, $monthlyPayment);
        $this->monthlyPayment = $monthlyPayment;
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
        $this->_onPropertyChanged('issuanceBalance', $this->issuanceBalance, $issuanceBalance);
        $this->issuanceBalance = $issuanceBalance;
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
        $this->_onPropertyChanged('initialRate', $this->initialRate, $initialRate);
        $this->initialRate = $initialRate;
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
        $this->_onPropertyChanged('currentRate', $this->currentRate, $currentRate);
        $this->currentRate = $currentRate;
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
        $this->_onPropertyChanged('originationDate', $this->originationDate, $originationDate);
        $this->originationDate = $originationDate;
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
        $this->_onPropertyChanged('currentDueforDate', $this->currentDueforDate, $currentDueforDate);
        $this->currentDueforDate = $currentDueforDate;
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
        $this->_onPropertyChanged('firstPaymentDate', $this->firstPaymentDate, $firstPaymentDate);
        $this->firstPaymentDate = $firstPaymentDate;
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
        $this->_onPropertyChanged('loanStatus', $this->loanStatus, $loanStatus);
        $this->loanStatus = $loanStatus;
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
        $this->_onPropertyChanged('finalDueforDate', $this->finalDueforDate, $finalDueforDate);
        $this->finalDueforDate = $finalDueforDate;
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
        $this->_onPropertyChanged('originalTerm', $this->originalTerm, $originalTerm);
        $this->originalTerm = $originalTerm;
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
        $this->_onPropertyChanged('remainingTerm', $this->remainingTerm, $remainingTerm);
        $this->remainingTerm = $remainingTerm;
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
        $this->_onPropertyChanged('amortizationTerm', $this->amortizationTerm, $amortizationTerm);
        $this->amortizationTerm = $amortizationTerm;
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
        $this->_onPropertyChanged('ioTerm', $this->ioTerm, $ioTerm);
        $this->ioTerm = $ioTerm;
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
        $this->_onPropertyChanged('balloonPeriod', $this->balloonPeriod, $balloonPeriod);
        $this->balloonPeriod = $balloonPeriod;
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
        $this->_onPropertyChanged('originalLtv', $this->originalLtv, $originalLtv);
        $this->originalLtv = $originalLtv;
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
        $this->_onPropertyChanged('originalCltv', $this->originalCltv, $originalCltv);
        $this->originalCltv = $originalCltv;
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
        $this->_onPropertyChanged('appraisedValue', $this->appraisedValue, $appraisedValue);
        $this->appraisedValue = $appraisedValue;
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
        $this->_onPropertyChanged('creditScore', $this->creditScore, $creditScore);
        $this->creditScore = $creditScore;
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
        $this->_onPropertyChanged('frontDti', $this->frontDti, $frontDti);
        $this->frontDti = $frontDti;
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
        $this->_onPropertyChanged('backDti', $this->backDti, $backDti);
        $this->backDti = $backDti;
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
        $this->_onPropertyChanged('numberOfBorrowers', $this->numberOfBorrowers, $numberOfBorrowers);
        $this->numberOfBorrowers = $numberOfBorrowers;
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
        $this->_onPropertyChanged('firstTimeBuyer', $this->firstTimeBuyer, $firstTimeBuyer);
        $this->firstTimeBuyer = $firstTimeBuyer;
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
        $this->_onPropertyChanged('lienPosition', $this->lienPosition, $lienPosition);
        $this->lienPosition = $lienPosition;
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
        $this->_onPropertyChanged('noteType', $this->noteType, $noteType);
        $this->noteType = $noteType;
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
        $this->_onPropertyChanged('loanType', $this->loanType, $loanType);
        $this->loanType = $loanType;
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
        $this->_onPropertyChanged('documentation', $this->documentation, $documentation);
        $this->documentation = $documentation;
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
        $this->_onPropertyChanged('purpose', $this->purpose, $purpose);
        $this->purpose = $purpose;
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
        $this->_onPropertyChanged('occupancy', $this->occupancy, $occupancy);
        $this->occupancy = $occupancy;
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
        $this->_onPropertyChanged('dwelling', $this->dwelling, $dwelling);
        $this->dwelling = $dwelling;
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
        $this->_onPropertyChanged('address', $this->address, $address);
        $this->address = $address;
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
        $this->_onPropertyChanged('state', $this->state, $state);
        $this->state = $state;
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
        $this->_onPropertyChanged('city', $this->city, $city);
        $this->city = $city;
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
        $this->_onPropertyChanged('zip', $this->zip, $zip);
        $this->zip = $zip;
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
        $this->_onPropertyChanged('msaCode', $this->msaCode, $msaCode);
        $this->msaCode = $msaCode;
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
        $this->_onPropertyChanged('paymentString', $this->paymentString, $paymentString);
        $this->paymentString = $paymentString;
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
        $this->_onPropertyChanged('servicingfee', $this->servicingfee, $servicingfee);
        $this->servicingfee = $servicingfee;
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
        $this->_onPropertyChanged('lpmiFee', $this->lpmiFee, $lpmiFee);
        $this->lpmiFee = $lpmiFee;
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
        $this->_onPropertyChanged('miCoverage', $this->miCoverage, $miCoverage);
        $this->miCoverage = $miCoverage;
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
        $this->_onPropertyChanged('amortization', $this->amortization, $amortization);
        $this->amortization = $amortization;
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
        $this->_onPropertyChanged('foreclosureDate', $this->foreclosureDate, $foreclosureDate);
        $this->foreclosureDate = $foreclosureDate;
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
        $this->_onPropertyChanged('bankruptcyDate', $this->bankruptcyDate, $bankruptcyDate);
        $this->bankruptcyDate = $bankruptcyDate;
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
        $this->_onPropertyChanged('reoDate', $this->reoDate, $reoDate);
        $this->reoDate = $reoDate;
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
        $this->_onPropertyChanged('zeroBalanceDate', $this->zeroBalanceDate, $zeroBalanceDate);
        $this->zeroBalanceDate = $zeroBalanceDate;
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
        $this->_onPropertyChanged('seasoning', $this->seasoning, $seasoning);
        $this->seasoning = $seasoning;
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
    public function getLoanHasBeenModified(): number { return $this->loanHasBeenModified; }

    /**
     * @param number $loanHasBeenModified
     */
    public function setLoanHasBeenModified(number $loanHasBeenModified)
    {
        $this->_onPropertyChanged('loanHasBeenModified', $this->loanHasBeenModified, $loanHasBeenModified);
        $this->loanHasBeenModified = $loanHasBeenModified;
    }

    /**
     * @return number
     */
    public function getEndModPeriod(): number { return $this->endModPeriod; }

    /**
     * @param number $endModPeriod
     */
    public function setEndModPeriod(number $endModPeriod)
    {
        $this->_onPropertyChanged('endModPeriod', $this->endModPeriod, $endModPeriod);
        $this->endModPeriod = $endModPeriod;
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
        $this->_onPropertyChanged('channel', $this->channel, $channel);
        $this->channel = $channel;
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
        $this->_onPropertyChanged('lastPaymentDate', $this->lastPaymentDate, $lastPaymentDate);
        $this->lastPaymentDate = $lastPaymentDate;
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
        $this->_onPropertyChanged('times_30', $this->times_30, $times_30);
        $this->times_30 = $times_30;
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
        $this->_onPropertyChanged('times_60', $this->times_60, $times_60);
        $this->times_60 = $times_60;
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
        $this->_onPropertyChanged('times_90', $this->times_90, $times_90);
        $this->times_90 = $times_90;
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





}