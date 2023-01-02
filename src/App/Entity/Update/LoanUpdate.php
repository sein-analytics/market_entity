<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 * Date: 6/16/16
 * Time: 3:24 PM
 */

namespace App\Entity\Update;

use App\Entity\DomainObject;
use App\Entity\Period;
use App\Service\CreatePropertiesArrayTrait;
use App\Entity\Loan;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\ChangeTrackingPolicy;

/**
 * @ORM\Entity(repositoryClass="\App\Repository\Update\LoanUpdate")
 * @ORM\ChangeTrackingPolicy("NOTIFY")
 * @ORM\Table(name="LoanUpdate")
 */
class LoanUpdate extends DomainObject
{
    use CreatePropertiesArrayTrait;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue *
     */
    protected int $id;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\Loan", inversedBy="updates")
     * @ORM\JoinColumn(name="loan_id", referencedColumnName="id", nullable=false)
     * @var Loan
     **/
    protected $loan;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\Update\PoolUpdate", inversedBy="loans")
     * @var PoolUpdate
     **/
    protected $pool;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\Period", inversedBy="loanUpdates")
     * @var Period
     **/
    protected $period;

    /**
     * @ORM\Column(type="decimal", precision=14, scale=4)
     * @var float
     **/
    protected float $beginningBalance = 0.0;

    /**
     * @ORM\Column(type="decimal", precision=14, scale=4)
     * @var float
     **/
    protected float $endingBalance = 0.0;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @var \DateTime|null
     **/
    protected ?\DateTime $dueforDate;

    /**
     * @ORM\Column(type="decimal", precision=7, scale=4, nullable=true)
     * @var float
     **/
    protected float $currentRate = 0.0;

    /**
     * @ORM\Column(type="decimal", precision=14, scale=4, nullable=true)
     * @var ?float
     */
    protected ?float $monthlyPayment = 0.0;

    /**
     * @ORM\Column(type="decimal", precision=14, scale=4, nullable=true)
     * @var float|null
     **/
    protected ?float $principalPayment = 0.0;

    /**
     * @ORM\Column(type="decimal", precision=14, scale=4, nullable=true)
     * @var ?float
     **/
    protected ?float $interestPayment = 0.0;

    /**
     * @ORM\Column(type="decimal", precision=14, scale=4, nullable=true)
     * @var ?float
     **/
    protected ?float $tiPayment = 0.0;

    /**
     * @ORM\Column(type="decimal", precision=14, scale=4, nullable=true)
     * @var ?float
     **/
    protected ?float $lossAmount = 0.0;

    /**
     * @ORM\Column(type="decimal", precision=14, scale=4, nullable=true)
     * @var ?float
     **/
    protected ?float $prepaymentAmount = 0.0;

    /**
     * @ORM\Column(type="decimal", precision=14, scale=4, nullable=true)
     * @var ?float
     **/
    protected ?float $defaultingAmount = 0.0;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var ?string
     **/
    protected ?string $delinquencyReason = '';

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @var ?\DateTime
     **/
    protected ?\DateTime $nextRateResetDate;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @var ?\DateTime
     **/
    protected ?\DateTime $nextPaymentResetDate;

    /**
     * @ORM\Column(type = "integer", nullable=true)
     * @var ?int
     */
    protected ?int $nextRateAdjustmentPeriod;

    /**
     * @ORM\Column(type = "integer", nullable=true)
     * @var ?int
     */
    protected ?int $nextPaymentAdjustmentPeriod;

    /**
     * @ORM\Column(type="decimal", precision=14, scale=4, nullable=true)
     * @var ?float
     **/
    protected ?float $netRate= 0.0;

    /**
     * @ORM\Column(type="decimal", precision=14, scale=4, nullable=true)
     * @var ?float
     **/
    protected ?float $unsupportedIntShortfall;

    /**
     * @ORM\Column(type="decimal", precision=14, scale=4, nullable=true)
     * @var ?float
     **/
    protected ?float $servicingDues = 0.0;

    /**
     * @ORM\Column(type="decimal", precision=14, scale=4, nullable=true)
     * @var ?float
     **/
    protected ?float $latePaymentDues = 0.0;

    /**
     * @ORM\Column(type="decimal", precision=14, scale=4, nullable=true)
     * @var ?float
     **/
    protected ?float $recoveries = 0.0;

    /**
     * @ORM\Column(type="decimal", precision=14, scale=4, nullable=true)
     * @var ?float
     **/
    protected ?float $interestShortfall = 0.0;

    /**
     * @ORM\Column(type="decimal", precision=14, scale=4, nullable=true)
     * @var ?float
     **/
    protected ?float $compensatingInterest = 0.0;

    /**
     * @ORM\Column(type = "integer", nullable=true)
     * @var ?int
     **/
    protected ?int $loanDelinquencyStatus;

    /**
     * @ORM\Column(type="decimal", precision=14, scale=4, nullable=true)
     * @var ?float
     **/
    protected ?float $escrowBalance = 0.0;

    /**
     * @ORM\Column(type = "string", nullable=true)
     * @var ?string
     **/
    protected ?string $servicingComments = '';

    /**
     * @return int
     */
    public function getId():int { return $this->id; }

    /**
     * @return Loan
     */
    public function getLoan():Loan { return $this->loan; }

    /**
     * @param Loan $loan
     */
    public function setLoan(Loan $loan):void
    {
        $this->implementChange($this,'loan', $this->loan, $loan);
    }

    /**
     * @return ?PoolUpdate
     */
    public function getPool():?PoolUpdate { return $this->pool; }

    /**
     * @param PoolUpdate $pool
     */
    public function setPool(PoolUpdate $pool):void
    {
        $this->implementChange($this,'pool', $this->pool, $pool);
    }

    /**
     * @return float
     */
    public function getBeginningBalance() : float { return $this->beginningBalance; }

    /**
     * @param float $beginningBalance
     */
    public function setBeginningBalance(float $beginningBalance):void
    {
        $this->implementChange($this,'beginningBalance', $this->beginningBalance, $beginningBalance);
    }

    /**
     * @return float
     */
    public function getEndingBalance() : float { return $this->endingBalance; }

    /**
     * @param float $endingBalance
     */
    public function setEndingBalance(float $endingBalance):void
    {
        $this->implementChange($this,'endingBalance', $this->endingBalance, $endingBalance);
    }

    /**
     * @return ?\DateTime
     */
    public function getDueforDate():?\DateTime { return $this->dueforDate; }

    /**
     * @param \DateTime $dueforDate
     */
    public function setDueforDate(\DateTime $dueforDate):void
    {
        $this->implementChange($this,'dueforDate', $this->dueforDate, $dueforDate);
    }

    /**
     * @return float
     */
    public function getMonthlyPayment() : float { return $this->monthlyPayment; }

    /**
     * @param float $monthlyPayment
     */
    public function setMonthlyPayment(float $monthlyPayment):void
    {
        $this->implementChange($this,'monthlyPayment', $this->monthlyPayment, $monthlyPayment);
    }

    /**
     * @return float
     */
    public function getPrincipalPayment() : float { return $this->principalPayment; }

    /**
     * @param float $principalPayment
     */
    public function setPrincipalPayment(float $principalPayment):void
    {
        $this->implementChange($this,'principalPayment', $this->principalPayment, $principalPayment);
    }

    /**
     * @return float
     */
    public function getInterestPayment() : float { return $this->interestPayment; }

    /**
     * @param float $interestPayment
     */
    public function setInterestPayment(float $interestPayment):void
    {
        $this->implementChange($this,'interestPayment', $this->interestPayment, $interestPayment);
    }

    /**
     * @return ?float
     */
    public function getTiPayment() : ?float { return $this->tiPayment; }

    /**
     * @param float $tiPayment
     */
    public function setTiPayment(float $tiPayment):void
    {
        $this->implementChange($this,'tiPayment', $this->tiPayment, $tiPayment);
    }

    /**
     * @return ?float
     */
    public function getLossAmount() : ?float { return $this->lossAmount; }

    /**
     * @param float $lossAmount
     */
    public function setLossAmount(float $lossAmount):void
    {
        $this->implementChange($this,'lossAmount', $this->lossAmount, $lossAmount);
    }

    /**
     * @return ?float
     */
    public function getPrepaymentAmount() :?float { return $this->prepaymentAmount; }

    /**
     * @param float $prepaymentAmount
     */
    public function setPrepaymentAmount(float $prepaymentAmount):void
    {
        $this->implementChange($this,'prepaymentAmount', $this->prepaymentAmount, $prepaymentAmount);
    }

    /**
     * @return ?float
     */
    public function getDefaultingAmount() : ?float { return $this->defaultingAmount; }

    /**
     * @param float $defaultingAmount
     */
    public function setDefaultingAmount(float $defaultingAmount):void
    {
        $this->implementChange($this,'defaultingAmount', $this->defaultingAmount, $defaultingAmount);
    }

    /**
     * @return ?string
     */
    public function getDelinquencyReason() :?string { return $this->delinquencyReason; }

    /**
     * @param string $delinquencyReason
     */
    public function setDelinquencyReason(string $delinquencyReason):void
    {
        $this->implementChange($this,'delinquencyReason', $this->delinquencyReason, $delinquencyReason);
    }

    /**
     * @return ?\DateTime
     */
    public function getNextRateResetDate():?\DateTime { return $this->nextRateResetDate; }

    /**
     * @param \DateTime $nextRateResetDate
     */
    public function setNextRateResetDate(\DateTime $nextRateResetDate)
    {
        $this->implementChange($this,'nextRateResetDate', $this->nextRateResetDate, $nextRateResetDate);
    }

    /**
     * @return ?\DateTime
     */
    public function getNextPaymentResetDate():?\DateTime { return $this->nextPaymentResetDate; }

    /**
     * @param \DateTime $nextPaymentResetDate
     */
    public function setNextPaymentResetDate(\DateTime $nextPaymentResetDate):void
    {
        $this->implementChange($this,'nextPaymentResetDate', $this->nextPaymentResetDate, $nextPaymentResetDate);
    }

    /**
     * @return ?int
     */
    public function getNextRateAdjustmentPeriod():?int { return $this->nextRateAdjustmentPeriod; }

    /**
     * @param int $nextRateAdjustmentPeriod
     */
    public function setNextRateAdjustmentPeriod(int $nextRateAdjustmentPeriod):void
    {
        $this->implementChange($this,'nextRateAdjustmentPeriod', $this->nextRateAdjustmentPeriod, $nextRateAdjustmentPeriod);
    }

    /**
     * @return ?int
     */
    public function getNextPaymentAdjustmentPeriod():?int { return $this->nextPaymentAdjustmentPeriod; }

    /**
     * @param int $nextPaymentAdjustmentPeriod
     */
    public function setNextPaymentAdjustmentPeriod(int $nextPaymentAdjustmentPeriod):void
    {
        $this->implementChange($this,'nextPaymentAdjustmentPeriod', $this->nextPaymentAdjustmentPeriod, $nextPaymentAdjustmentPeriod);
    }

    /**
     * @return ?float
     */
    public function getNetRate() : ?float { return $this->netRate; }

    /**
     * @param float $netRate
     */
    public function setNetRate(float $netRate):void
    {
        $this->implementChange($this,'netRate', $this->netRate, $netRate);
    }

    /**
     * @return ?float
     */
    public function getUnsupportedIntShortfall() : ?float { return $this->unsupportedIntShortfall; }

    /**
     * @param float $unsupportedIntShortfall
     */
    public function setUnsupportedIntShortfall(float $unsupportedIntShortfall):void
    {
        $this->implementChange($this,'unsupportedIntShortfall', $this->unsupportedIntShortfall, $unsupportedIntShortfall);
    }

    /**
     * @return ?float
     */
    public function getServicingDues() : ?float { return $this->servicingDues; }

    /**
     * @param float $servicingDues
     */
    public function setServicingDues(float $servicingDues):void
    {
        $this->implementChange($this,'servicingDues', $this->servicingDues, $servicingDues);
    }

    /**
     * @return ?float
     */
    public function getLatePaymentDues() :?float { return $this->latePaymentDues; }

    /**
     * @param float $latePaymentDues
     */
    public function setLatePaymentDues(float $latePaymentDues):void
    {
        $this->implementChange($this,'latePaymentDues', $this->latePaymentDues, $latePaymentDues);
    }

    /**
     * @return ?float
     */
    public function getRecoveries() : ?float { return $this->recoveries; }

    /**
     * @param float $recoveries
     */
    public function setRecoveries(float $recoveries):void
    {
        $this->implementChange($this,'recoveries', $this->recoveries, $recoveries);
    }

    /**
     * @return ?float
     */
    public function getInterestShortfall() : ?float { return $this->interestShortfall; }

    /**
     * @param float $interestShortfall
     */
    public function setInterestShortfall(float $interestShortfall):void
    {
        $this->implementChange($this,'interestShortfall', $this->interestShortfall, $interestShortfall);
    }

    /**
     * @return ?float
     */
    public function getCompensatingInterest():?float
    {
        return $this->compensatingInterest;
    }

    /**
     * @param float $compensatingInterest
     */
    public function setCompensatingInterest(float $compensatingInterest):void
    {
        $this->implementChange($this,'compensatingInterest', $this->compensatingInterest, $compensatingInterest);
    }

    /**
     * @return ?int
     */
    public function getLoanDelinquencyStatus():?int { return $this->loanDelinquencyStatus; }

    /**
     * @param int $loanDelinquencyStatus
     */
    public function setLoanDelinquencyStatus(int $loanDelinquencyStatus):void
    {
        $this->implementChange($this,'loanDelinquencyStatus', $this->loanDelinquencyStatus, $loanDelinquencyStatus);
    }

    /**
     * @return ?float
     */
    public function getCurrentRate():?float
    {
        return $this->currentRate;
    }

    /**
     * @param float $currentRate
     */
    public function setCurrentRate(float $currentRate):void
    {
        $this->currentRate = $currentRate;
    }

    /**
     * @return ?float
     */
    public function getEscrowBalance(): ?float { return $this->escrowBalance; }

    /**
     * @param float $escrowBalance
     */
    public function setEscrowBalance(float $escrowBalance):void
    {
        $this->escrowBalance = $escrowBalance;
    }

    /**
     * @return ?string
     */
    public function getServicingComments() : ?string { return $this->servicingComments; }

    /**
     * @param string $servicingComments
     */
    public function setServicingComments(string $servicingComments):void
    {
        $this->servicingComments = $servicingComments;
    }


}