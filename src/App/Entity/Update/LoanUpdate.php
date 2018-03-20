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
 * @ORM\Entity
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

    /** @ORM\Column(type="decimal", precision=14, scale=4) **/
    protected $beginningBalance = 0.0;

    /** @ORM\Column(type="decimal", precision=14, scale=4) **/
    protected $endingBalance = 0.0;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @var \DateTime
     **/
    protected $dueforDate;

    /** @ORM\Column(type="decimal", precision=7, scale=4, nullable=true) **/
    protected $currentRate = 0.0;

    /** @ORM\Column(type="decimal", precision=14, scale=4, nullable=true) **/
    protected $monthlyPayment = 0.0;

    /** @ORM\Column(type="decimal", precision=14, scale=4, nullable=true) **/
    protected $principalPayment = 0.0;

    /** @ORM\Column(type="decimal", precision=14, scale=4, nullable=true) **/
    protected $interestPayment = 0.0;

    /** @ORM\Column(type="decimal", precision=14, scale=4, nullable=true) **/
    protected $tiPayment = 0.0;

    /** @ORM\Column(type="decimal", precision=14, scale=4, nullable=true) **/
    protected $lossAmount = 0.0;

    /** @ORM\Column(type="decimal", precision=14, scale=4, nullable=true) **/
    protected $prepaymentAmount = 0.0;

    /** @ORM\Column(type="decimal", precision=14, scale=4, nullable=true) **/
    protected $defaultingAmount;

    /** @ORM\Column(type="string", nullable=true) **/
    protected $delinquencyReason;

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

    /** @ORM\Column(type="integer", nullable=true)  **/
    protected $netRate= 0.0;

    /** @ORM\Column(type="decimal", precision=14, scale=4, nullable=true) **/
    protected $unsupportedIntShortfall;

    /** @ORM\Column(type="decimal", precision=14, scale=4, nullable=true) **/
    protected $servicingDues = 0.0;

    /** @ORM\Column(type="decimal", precision=14, scale=4, nullable=true) **/
    protected $latePaymentDues;

    /** @ORM\Column(type="decimal", precision=14, scale=4, nullable=true) **/
    protected $recoveries;

    /** @ORM\Column(type="decimal", precision=14, scale=4, nullable=true) **/
    protected $interestShortfall;

    /** @ORM\Column(type="decimal", precision=14, scale=4, nullable=true) **/
    protected $compensatingInterest;

    /** @ORM\Column(type = "integer", nullable=true) **/
    protected $loanDelinquencyStatus;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Loan
     */
    public function getLoan()
    {
        return $this->loan;
    }

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
    public function getPool() {
        return $this->pool;
    }

    /**
     * @param PoolUpdate $pool
     */
    public function setPool(PoolUpdate $pool)
    {
        $this->_onPropertyChanged('pool', $this->pool, $pool);
        $this->pool = $pool;
    }

    /**
     * @return mixed
     */
    public function getBeginningBalance()
    {
        return $this->beginningBalance;
    }

    /**
     * @param mixed $beginningBalance
     */
    public function setBeginningBalance($beginningBalance)
    {
        $this->_onPropertyChanged('beginningBalance', $this->beginningBalance, $beginningBalance);
        $this->beginningBalance = $beginningBalance;
    }

    /**
     * @return mixed
     */
    public function getEndingBalance()
    {
        return $this->endingBalance;
    }

    /**
     * @param mixed $endingBalance
     */
    public function setEndingBalance($endingBalance)
    {
        $this->_onPropertyChanged('endingBalance', $this->endingBalance, $endingBalance);
        $this->endingBalance = $endingBalance;
    }

    /**
     * @return \DateTime
     */
    public function getDueforDate()
    {
        return $this->dueforDate;
    }

    /**
     * @param \DateTime $dueforDate
     */
    public function setDueforDate(\DateTime $dueforDate)
    {
        $this->_onPropertyChanged('dueforDate', $this->dueforDate, $dueforDate);
        $this->dueforDate = $dueforDate;
    }

    /**
     * @return mixed
     */
    public function getMonthlyPayment()
    {
        return $this->monthlyPayment;
    }

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
    public function getPrincipalPayment()
    {
        return $this->principalPayment;
    }

    /**
     * @param mixed $principalPayment
     */
    public function setPrincipalPayment($principalPayment)
    {
        $this->_onPropertyChanged('principalPayment', $this->principalPayment, $principalPayment);
        $this->principalPayment = $principalPayment;
    }

    /**
     * @return mixed
     */
    public function getInterestPayment()
    {
        return $this->interestPayment;
    }

    /**
     * @param mixed $interestPayment
     */
    public function setInterestPayment($interestPayment)
    {
        $this->_onPropertyChanged('interestPayment', $this->interestPayment, $interestPayment);
        $this->interestPayment = $interestPayment;
    }

    /**
     * @return mixed
     */
    public function getTiPayment()
    {
        return $this->tiPayment;
    }

    /**
     * @param mixed $tiPayment
     */
    public function setTiPayment($tiPayment)
    {
        $this->_onPropertyChanged('tiPayment', $this->tiPayment, $tiPayment);
        $this->tiPayment = $tiPayment;
    }

    /**
     * @return mixed
     */
    public function getLossAmount()
    {
        return $this->lossAmount;
    }

    /**
     * @param mixed $lossAmount
     */
    public function setLossAmount($lossAmount)
    {
        $this->_onPropertyChanged('lossAmount', $this->lossAmount, $lossAmount);
        $this->lossAmount = $lossAmount;
    }

    /**
     * @return mixed
     */
    public function getPrepaymentAmount()
    {
        return $this->prepaymentAmount;
    }

    /**
     * @param mixed $prepaymentAmount
     */
    public function setPrepaymentAmount($prepaymentAmount)
    {
        $this->_onPropertyChanged('prepaymentAmount', $this->prepaymentAmount, $prepaymentAmount);
        $this->prepaymentAmount = $prepaymentAmount;
    }

    /**
     * @return mixed
     */
    public function getDefaultingAmount()
    {
        return $this->defaultingAmount;
    }

    /**
     * @param mixed $defaultingAmount
     */
    public function setDefaultingAmount($defaultingAmount)
    {
        $this->_onPropertyChanged('defaultingAmount', $this->defaultingAmount, $defaultingAmount);
        $this->defaultingAmount = $defaultingAmount;
    }

    /**
     * @return mixed
     */
    public function getDelinquencyReason()
    {
        return $this->delinquencyReason;
    }

    /**
     * @param mixed $delinquencyReason
     */
    public function setDelinquencyReason($delinquencyReason)
    {
        $this->_onPropertyChanged('delinquencyReason', $this->delinquencyReason, $delinquencyReason);
        $this->delinquencyReason = $delinquencyReason;
    }

    /**
     * @return \DateTime
     */
    public function getNextRateResetDate()
    {
        return $this->nextRateResetDate;
    }

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
    public function getNextPaymentResetDate()
    {
        return $this->nextPaymentResetDate;
    }

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
    public function getNextRateAdjustmentPeriod()
    {
        return $this->nextRateAdjustmentPeriod;
    }

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
    public function getNextPaymentAdjustmentPeriod()
    {
        return $this->nextPaymentAdjustmentPeriod;
    }

    /**
     * @param mixed $nextPaymentAdjustmentPeriod
     */
    public function setNextPaymentAdjustmentPeriod($nextPaymentAdjustmentPeriod)
    {
        $this->_onPropertyChanged('nextPaymentAdjustmentPeriod', $this->nextPaymentAdjustmentPeriod, $nextPaymentAdjustmentPeriod);
        $this->nextPaymentAdjustmentPeriod = $nextPaymentAdjustmentPeriod;
    }

    /**
     * @return mixed
     */
    public function getNetRate()
    {
        return $this->netRate;
    }

    /**
     * @param mixed $netRate
     */
    public function setNetRate($netRate)
    {
        $this->_onPropertyChanged('netRate', $this->netRate, $netRate);
        $this->netRate = $netRate;
    }

    /**
     * @return mixed
     */
    public function getUnsupportedIntShortfall()
    {
        return $this->unsupportedIntShortfall;
    }

    /**
     * @param mixed $unsupportedIntShortfall
     */
    public function setUnsupportedIntShortfall($unsupportedIntShortfall)
    {
        $this->_onPropertyChanged('unsupportedIntShortfall', $this->unsupportedIntShortfall, $unsupportedIntShortfall);
        $this->unsupportedIntShortfall = $unsupportedIntShortfall;
    }

    /**
     * @return mixed
     */
    public function getServicingDues()
    {
        return $this->servicingDues;
    }

    /**
     * @param mixed $servicingDues
     */
    public function setServicingDues($servicingDues)
    {
        $this->_onPropertyChanged('servicingDues', $this->servicingDues, $servicingDues);
        $this->servicingDues = $servicingDues;
    }

    /**
     * @return mixed
     */
    public function getLatePaymentDues()
    {
        return $this->latePaymentDues;
    }

    /**
     * @param mixed $latePaymentDues
     */
    public function setLatePaymentDues($latePaymentDues)
    {
        $this->_onPropertyChanged('latePaymentDues', $this->latePaymentDues, $latePaymentDues);
        $this->latePaymentDues = $latePaymentDues;
    }

    /**
     * @return mixed
     */
    public function getRecoveries()
    {
        return $this->recoveries;
    }

    /**
     * @param mixed $recoveries
     */
    public function setRecoveries($recoveries)
    {
        $this->_onPropertyChanged('recoveries', $this->recoveries, $recoveries);
        $this->recoveries = $recoveries;
    }

    /**
     * @return mixed
     */
    public function getInterestShortfall()
    {
        return $this->interestShortfall;
    }

    /**
     * @param mixed $interestShortfall
     */
    public function setInterestShortfall($interestShortfall)
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
     * @param mixed $compensatingInterest
     */
    public function setCompensatingInterest($compensatingInterest)
    {
        $this->_onPropertyChanged('compensatingInterest', $this->compensatingInterest, $compensatingInterest);
        $this->compensatingInterest = $compensatingInterest;
    }

    /**
     * @return mixed
     */
    public function getLoanDelinquencyStatus()
    {
        return $this->loanDelinquencyStatus;
    }

    /**
     * @param mixed $loanDelinquencyStatus
     */
    public function setLoanDelinquencyStatus($loanDelinquencyStatus)
    {
        $this->_onPropertyChanged('loanDelinquencyStatus', $this->loanDelinquencyStatus, $loanDelinquencyStatus);
        $this->loanDelinquencyStatus = $loanDelinquencyStatus;
    }


}