<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 * Date: 6/16/16
 * Time: 3:24 PM
 */

namespace App\Entity\Update;

use App\Entity\NotifyChangeTrait;
use App\Entity\Period;
use App\Service\CreatePropertiesArrayTrait;
use Doctrine\Common\NotifyPropertyChanged;
use Doctrine\ORM\Mapping\ChangeTrackingPolicy;
use App\Entity\Loan;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="\App\Repository\Update\LoanUpdate")
 * @ChangeTrackingPolicy("NOTIFY")
 * @ORM\Table(name="LoanUpdate")
 */
class LoanUpdate implements NotifyPropertyChanged
{
    use NotifyChangeTrait, CreatePropertiesArrayTrait;

    /** @ORM\Id @ORM\Column(type="integer") @ORM\GeneratedValue **/
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\Loan", inversedBy="updates")
     * @ORM\JoinColumn(name="loan_id", referencedColumnName="id", nullable=false)
     * @var \App\Entity\Loan
     **/
    protected $loan;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\Update\PoolUpdate", inversedBy="loans")
     * @var \App\Entity\Update\PoolUpdate
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
    protected $beginningBalance = 0.0;

    /**
     * @ORM\Column(type="decimal", precision=14, scale=4)
     * @var float
     **/
    protected $endingBalance = 0.0;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @var \DateTime
     **/
    protected $dueforDate;

    /**
     * @ORM\Column(type="decimal", precision=7, scale=4, nullable=true)
     * @var float
     **/
    protected $currentRate = 0.0;

    /** @ORM\Column(type="decimal", precision=14, scale=4, nullable=true) **/
    protected $monthlyPayment = 0.0;

    /**
     * @ORM\Column(type="decimal", precision=14, scale=4, nullable=true)
     * @var float
     **/
    protected $principalPayment = 0.0;

    /**
     * @ORM\Column(type="decimal", precision=14, scale=4, nullable=true)
     * @var float
     **/
    protected $interestPayment = 0.0;

    /**
     * @ORM\Column(type="decimal", precision=14, scale=4, nullable=true)
     * @var float
     **/
    protected $tiPayment = 0.0;

    /**
     * @ORM\Column(type="decimal", precision=14, scale=4, nullable=true)
     * @var float
     **/
    protected $lossAmount = 0.0;

    /**
     * @ORM\Column(type="decimal", precision=14, scale=4, nullable=true)
     * @var float
     **/
    protected $prepaymentAmount = 0.0;

    /**
     * @ORM\Column(type="decimal", precision=14, scale=4, nullable=true)
     * @var float
     **/
    protected $defaultingAmount = 0.0;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var string
     **/
    protected $delinquencyReason = '';

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @var \DateTime
     **/
    protected $nextRateResetDate;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @var \DateTime
     **/
    protected $nextPaymentResetDate;

    /** @ORM\Column(type = "integer", nullable=true) **/
    protected $nextRateAdjustmentPeriod;

    /** @ORM\Column(type = "integer", nullable=true) **/
    protected $nextPaymentAdjustmentPeriod;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @var float
     **/
    protected $netRate= 0.0;

    /** @ORM\Column(type="decimal", precision=14, scale=4, nullable=true) **/
    protected $unsupportedIntShortfall;

    /**
     * @ORM\Column(type="decimal", precision=14, scale=4, nullable=true)
     * @var float
     **/
    protected $servicingDues = 0.0;

    /**
     * @ORM\Column(type="decimal", precision=14, scale=4, nullable=true)
     * @var float
     **/
    protected $latePaymentDues = 0.0;

    /**
     * @ORM\Column(type="decimal", precision=14, scale=4, nullable=true)
     * @var float
     **/
    protected $recoveries = 0.0;

    /**
     * @ORM\Column(type="decimal", precision=14, scale=4, nullable=true)
     * @var float
     **/
    protected $interestShortfall = 0.0;

    /**
     * @ORM\Column(type="decimal", precision=14, scale=4, nullable=true)
     * @var float
     **/
    protected $compensatingInterest = 0.0;

    /** @ORM\Column(type = "integer", nullable=true) **/
    protected $loanDelinquencyStatus;

    /**
     * @ORM\Column(type="decimal", precision=14, scale=4, nullable=true)
     * @var float
     **/
    protected $escrowBalance = 0.0;

    /**
     * @ORM\Column(type = "string", nullable=true)
     * @var string
     **/
    protected $servicingComments = '';

    /**
     * @return mixed
     */
    public function getId() { return $this->id; }

    /**
     * @return Loan
     */
    public function getLoan() { return $this->loan; }

    /**
     * @param Loan $loan
     */
    public function setLoan(Loan $loan)
    {
        $this->_onPropertyChanged('loan', $this->loan, $loan);
        $this->loan = $loan;
    }

    /**
     * @return PoolUpdate
     */
    public function getPool() { return $this->pool; }

    /**
     * @param PoolUpdate $pool
     */
    public function setPool(PoolUpdate $pool)
    {
        $this->_onPropertyChanged('pool', $this->pool, $pool);
        $this->pool = $pool;
    }

    /**
     * @return float
     */
    public function getBeginningBalance() : float { return $this->beginningBalance; }

    /**
     * @param float $beginningBalance
     */
    public function setBeginningBalance($beginningBalance)
    {
        $this->_onPropertyChanged('beginningBalance', $this->beginningBalance, $beginningBalance);
        $this->beginningBalance = $beginningBalance;
    }

    /**
     * @return float
     */
    public function getEndingBalance() : float { return $this->endingBalance; }

    /**
     * @param float $endingBalance
     */
    public function setEndingBalance(float $endingBalance)
    {
        $this->_onPropertyChanged('endingBalance', $this->endingBalance, $endingBalance);
        $this->endingBalance = $endingBalance;
    }

    /**
     * @return \DateTime
     */
    public function getDueforDate() { return $this->dueforDate; }

    /**
     * @param \DateTime $dueforDate
     */
    public function setDueforDate(\DateTime $dueforDate)
    {
        $this->_onPropertyChanged('dueforDate', $this->dueforDate, $dueforDate);
        $this->dueforDate = $dueforDate;
    }

    /**
     * @return float
     */
    public function getMonthlyPayment() : float { return $this->monthlyPayment; }

    /**
     * @param float $monthlyPayment
     */
    public function setMonthlyPayment(float $monthlyPayment)
    {
        $this->_onPropertyChanged('monthlyPayment', $this->monthlyPayment, $monthlyPayment);
        $this->monthlyPayment = $monthlyPayment;
    }

    /**
     * @return float
     */
    public function getPrincipalPayment() : float { return $this->principalPayment; }

    /**
     * @param float $principalPayment
     */
    public function setPrincipalPayment(float $principalPayment)
    {
        $this->_onPropertyChanged('principalPayment', $this->principalPayment, $principalPayment);
        $this->principalPayment = $principalPayment;
    }

    /**
     * @return mixed
     */
    public function getInterestPayment() : float { return $this->interestPayment; }

    /**
     * @param float $interestPayment
     */
    public function setInterestPayment(float $interestPayment)
    {
        $this->_onPropertyChanged('interestPayment', $this->interestPayment, $interestPayment);
        $this->interestPayment = $interestPayment;
    }

    /**
     * @return float
     */
    public function getTiPayment() : float { return $this->tiPayment; }

    /**
     * @param float $tiPayment
     */
    public function setTiPayment(float $tiPayment)
    {
        $this->_onPropertyChanged('tiPayment', $this->tiPayment, $tiPayment);
        $this->tiPayment = $tiPayment;
    }

    /**
     * @return float
     */
    public function getLossAmount() : float { return $this->lossAmount; }

    /**
     * @param float $lossAmount
     */
    public function setLossAmount(float $lossAmount)
    {
        $this->_onPropertyChanged('lossAmount', $this->lossAmount, $lossAmount);
        $this->lossAmount = $lossAmount;
    }

    /**
     * @return float
     */
    public function getPrepaymentAmount() :float { return $this->prepaymentAmount; }

    /**
     * @param float $prepaymentAmount
     */
    public function setPrepaymentAmount(float $prepaymentAmount)
    {
        $this->_onPropertyChanged('prepaymentAmount', $this->prepaymentAmount, $prepaymentAmount);
        $this->prepaymentAmount = $prepaymentAmount;
    }

    /**
     * @return float
     */
    public function getDefaultingAmount() : float { return $this->defaultingAmount; }

    /**
     * @param float $defaultingAmount
     */
    public function setDefaultingAmount(float $defaultingAmount)
    {
        $this->_onPropertyChanged('defaultingAmount', $this->defaultingAmount, $defaultingAmount);
        $this->defaultingAmount = $defaultingAmount;
    }

    /**
     * @return string
     */
    public function getDelinquencyReason() :string { return $this->delinquencyReason; }

    /**
     * @param string $delinquencyReason
     */
    public function setDelinquencyReason(string $delinquencyReason)
    {
        $this->_onPropertyChanged('delinquencyReason', $this->delinquencyReason, $delinquencyReason);
        $this->delinquencyReason = $delinquencyReason;
    }

    /**
     * @return \DateTime
     */
    public function getNextRateResetDate() { return $this->nextRateResetDate; }

    /**
     * @param \DateTime $nextRateResetDate
     */
    public function setNextRateResetDate(\DateTime $nextRateResetDate)
    {
        $this->_onPropertyChanged('nextRateResetDate', $this->nextRateResetDate, $nextRateResetDate);
        $this->nextRateResetDate = $nextRateResetDate;
    }

    /**
     * @return mixed
     */
    public function getNextPaymentResetDate() { return $this->nextPaymentResetDate; }

    /**
     * @param \DateTime $nextPaymentResetDate
     */
    public function setNextPaymentResetDate(\DateTime $nextPaymentResetDate)
    {
        $this->_onPropertyChanged('nextPaymentResetDate', $this->nextPaymentResetDate, $nextPaymentResetDate);
        $this->nextPaymentResetDate = $nextPaymentResetDate;
    }

    /**
     * @return mixed
     */
    public function getNextRateAdjustmentPeriod() { return $this->nextRateAdjustmentPeriod; }

    /**
     * @param mixed $nextRateAdjustmentPeriod
     */
    public function setNextRateAdjustmentPeriod($nextRateAdjustmentPeriod)
    {
        $this->_onPropertyChanged('nextRateAdjustmentPeriod', $this->nextRateAdjustmentPeriod, $nextRateAdjustmentPeriod);
        $this->nextRateAdjustmentPeriod = $nextRateAdjustmentPeriod;
    }

    /**
     * @return mixed
     */
    public function getNextPaymentAdjustmentPeriod() { return $this->nextPaymentAdjustmentPeriod; }

    /**
     * @param mixed $nextPaymentAdjustmentPeriod
     */
    public function setNextPaymentAdjustmentPeriod($nextPaymentAdjustmentPeriod)
    {
        $this->_onPropertyChanged('nextPaymentAdjustmentPeriod', $this->nextPaymentAdjustmentPeriod, $nextPaymentAdjustmentPeriod);
        $this->nextPaymentAdjustmentPeriod = $nextPaymentAdjustmentPeriod;
    }

    /**
     * @return float
     */
    public function getNetRate() : float { return $this->netRate; }

    /**
     * @param float $netRate
     */
    public function setNetRate(float $netRate)
    {
        $this->_onPropertyChanged('netRate', $this->netRate, $netRate);
        $this->netRate = $netRate;
    }

    /**
     * @return float
     */
    public function getUnsupportedIntShortfall() : float { return $this->unsupportedIntShortfall; }

    /**
     * @param float $unsupportedIntShortfall
     */
    public function setUnsupportedIntShortfall(float $unsupportedIntShortfall)
    {
        $this->_onPropertyChanged('unsupportedIntShortfall', $this->unsupportedIntShortfall, $unsupportedIntShortfall);
        $this->unsupportedIntShortfall = $unsupportedIntShortfall;
    }

    /**
     * @return float
     */
    public function getServicingDues() : float { return $this->servicingDues; }

    /**
     * @param float $servicingDues
     */
    public function setServicingDues(float $servicingDues)
    {
        $this->_onPropertyChanged('servicingDues', $this->servicingDues, $servicingDues);
        $this->servicingDues = $servicingDues;
    }

    /**
     * @return float
     */
    public function getLatePaymentDues() :float { return $this->latePaymentDues; }

    /**
     * @param float $latePaymentDues
     */
    public function setLatePaymentDues(float $latePaymentDues)
    {
        $this->_onPropertyChanged('latePaymentDues', $this->latePaymentDues, $latePaymentDues);
        $this->latePaymentDues = $latePaymentDues;
    }

    /**
     * @return float
     */
    public function getRecoveries() : float { return $this->recoveries; }

    /**
     * @param float $recoveries
     */
    public function setRecoveries(float $recoveries)
    {
        $this->_onPropertyChanged('recoveries', $this->recoveries, $recoveries);
        $this->recoveries = $recoveries;
    }

    /**
     * @return float
     */
    public function getInterestShortfall() : float { return $this->interestShortfall; }

    /**
     * @param float $interestShortfall
     */
    public function setInterestShortfall(float $interestShortfall)
    {
        $this->_onPropertyChanged('interestShortfall', $this->interestShortfall, $interestShortfall);
        $this->interestShortfall = $interestShortfall;
    }

    /**
     * @return mixed
     */
    public function getCompensatingInterest()
    {
        return $this->compensatingInterest;
    }

    /**
     * @param float $compensatingInterest
     */
    public function setCompensatingInterest(float $compensatingInterest)
    {
        $this->_onPropertyChanged('compensatingInterest', $this->compensatingInterest, $compensatingInterest);
        $this->compensatingInterest = $compensatingInterest;
    }

    /**
     * @return mixed
     */
    public function getLoanDelinquencyStatus() { return $this->loanDelinquencyStatus; }

    /**
     * @param mixed $loanDelinquencyStatus
     */
    public function setLoanDelinquencyStatus($loanDelinquencyStatus)
    {
        $this->_onPropertyChanged('loanDelinquencyStatus', $this->loanDelinquencyStatus, $loanDelinquencyStatus);
        $this->loanDelinquencyStatus = $loanDelinquencyStatus;
    }

    /**
     * @return mixed
     */
    public function getCurrentRate()
    {
        return $this->currentRate;
    }

    /**
     * @param mixed $currentRate
     */
    public function setCurrentRate($currentRate)
    {
        $this->currentRate = $currentRate;
    }

    /**
     * @return float
     */
    public function getEscrowBalance(): float { return $this->escrowBalance; }

    /**
     * @param float $escrowBalance
     */
    public function setEscrowBalance(float $escrowBalance)
    {
        $this->escrowBalance = $escrowBalance;
    }

    /**
     * @return string
     */
    public function getServicingComments() : string { return $this->servicingComments; }

    /**
     * @param string $servicingComments
     */
    public function setServicingComments(string $servicingComments)
    {
        $this->servicingComments = $servicingComments;
    }




}