<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 * Date: 6/16/16
 * Time: 1:30 PM
 */

namespace App\Entity\Update;

use App\Entity\DomainObject;
use App\Entity\NotifyChangeTrait;
use App\Service\CreatePropertiesArrayTrait;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\NotifyPropertyChanged;
use Doctrine\ORM\Mapping\ChangeTrackingPolicy;
use App\Entity\Period;
use App\Entity\Pool;
use Doctrine\Common\Collections\ArrayCollection;
/**
 * @ORM\Entity
 * @ORM\Table(name="PoolUpdate", indexes={@ORM\Index(name="period_pool_idx", columns={"period_id", "pool_id"})})
 * @ORM\ChangeTrackingPolicy("NOTIFY")
 */
class PoolUpdate extends DomainObject
{
    use CreatePropertiesArrayTrait;

    /** @ORM\Id @ORM\GeneratedValue @ORM\Column(type="integer") **/
    protected $id;

    /** 
     * @ORM\ManyToOne(targetEntity="\App\Entity\Pool", inversedBy="poolUpdates")
     * @var Pool
     **/
    protected $pool;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\Period", inversedBy="poolUpdates")
     * @var Period
     **/
    protected $period;

    /** @ORM\OneToMany(targetEntity="\App\Entity\Update\LoanUpdate", mappedBy="pool")
     * @var ArrayCollection
     **/
    protected $loans;

    /**
     * @ORM\Column(type="datetime")
     * @var \DateTime
     **/
    protected $reportDate;

    /** @ORM\Column(type="decimal", precision=14, scale=2, nullable=true) **/
    protected $endingBalance;

    /** @ORM\Column(type="decimal", precision=14, scale=2, nullable=true) **/
    protected $startingBalance;

    /** @ORM\Column(type="decimal", precision=14, scale=2, nullable=true) **/
    protected $cumulativeLosses;

    /**
     * Period starting gross weighted average coupon
     * @ORM\Column(type="decimal", precision=9, scale=5, nullable=true)
     **/
    protected $groupGrossWac;

    /**
     * Current Period's scheduled principal payments received
     * @ORM\Column(type="decimal", precision=12, scale=2, nullable=true)
     **/
    protected $scheduledPrincipal;

    /**
     * Current Period's interest payments received
     * @ORM\Column(type="decimal", precision=12, scale=2, nullable=true)
     **/
    protected $interestCollections;

    /**
     * Current Period's liquidated balance
     * @ORM\Column(type="decimal", precision=12, scale=2, nullable=true)
     **/
    protected $liquidations;

    /**
     * Current Period's recoveries from liquidated loans
     * @ORM\Column(type="decimal", precision=12, scale=2, nullable=true)
     **/
    protected $recoveries;

    /**
     * Current Period's prepayed balance
     * @ORM\Column(type="decimal", precision=12, scale=2, nullable=true)
     **/
    protected $prepayedBalance;

    /**
     * Current Period's number of loans prepaying
     * @ORM\Column(type="decimal", precision=12, scale=3, nullable=true)
     **/
    protected $prepayedLoans;

    /**
     * regular principal calculation--expected principal to be paid to the notes
     * @ORM\Column(type="decimal", precision=15, scale=3, nullable=true)
     **/
    protected $bondRegularPrincipalCalc;

    /**
     * supplemental principal calculation--in addition to the regular principal
     * @ORM\Column(type="decimal", precision=15, scale=3, nullable=true)
     **/
    protected $unscheduledPrincipalCalc;

    /**
     * Holds total interest payments to the notes for each forecast period
     * in the deal waterfall engine calculate()
     * @var double
     */
    protected $bondInterestPayments;

    /**
     * Actual amount of regular principal paid to the notes
     * @ORM\Column(type="decimal", precision=15, scale=3, nullable=true)
     **/
    protected $regularPrincipalPaid;

    /**
     * Actual amount of regular principal paid to the notes
     * @ORM\Column(type="decimal", precision=15, scale=3, nullable=true)
     **/
    protected $unscheduledPrincipalPaid;

    /**
     * @ORM\Column(type="integer", nullable=false)
     **/
    protected $updateStatus = 1;

    /** @ORM\Column(type="decimal", precision=10, scale=7, nullable=true) **/
    protected $groupNetWac;

    /** @ORM\Column(type="integer", nullable=true) **/
    protected $receivablesCount;

    /**
     * @ORM\Column(type="decimal", precision=14, scale=2, nullable=true)
     */
    protected $groupSeniorPct;

    /**
     * @ORM\Column(type="decimal", precision=14, scale=2, nullable=true)
     */
    protected $groupSubPct;

    /**
     * Indicate whether collateral is historic or forecast
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $isHistory = 0;
    
    /** 
     * @ORM\OneToOne(targetEntity="\App\Entity\Update\Delinquency", inversedBy="poolUpdate")
     * @var Delinquency   
     */
    protected $delinquency;
    
    public function __construct()
    {
        $this->loans = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Pool
     */
    public function getPool()
    {
        return $this->pool;
    }

    /**
     * @param Pool $pool
     */
    public function setPool(Pool $pool)
    {
        $this->implementChange($this,'pool', $this->pool, $pool);
    }

    /**
     * @return Period
     */
    public function getPeriod()
    {
        return $this->period;
    }

    /**
     * @param Period $period
     */
    public function setPeriod(Period $period)
    {
        $this->implementChange($this,'period', $this->period, $period);
    }

    /**
     * @return ArrayCollection
     */
    public function getLoans()
    {
        return $this->loans;
    }

    /**
     * @param LoanUpdate $loanUpdate
     */
    public function addLoanUpdate(LoanUpdate $loanUpdate){
        /** @var  $loans ArrayCollection */
        $loans = $this->getLoans();
        $loanCollection = $loans->filter(function(LoanUpdate $l) use ($loanUpdate){
            return $l->getId() == $loanUpdate->getId();
        });
        if ($loanCollection->first()){
            return;
        }
        $this->getLoans()->add($loanUpdate);
    }

    /**
     * @return \DateTime | null
     */
    public function getReportDate()
    {
        return $this->reportDate;
    }

    /**
     * @param \DateTime $reportDate
     */
    public function setReportDate(\DateTime $reportDate)
    {
        $this->implementChange($this,'reportDate', $this->reportDate, $reportDate);
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
        $this->implementChange($this,'endingBalance', $this->endingBalance, $endingBalance);
    }

    /**
     * @return mixed
     */
    public function getStartingBalance()
    {
        return $this->startingBalance;
    }

    /**
     * @param mixed $startingBalance
     */
    public function setStartingBalance($startingBalance)
    {
        $this->implementChange($this,'startingBalance', $this->startingBalance, $startingBalance);
    }

    /**
     * @return mixed
     */
    public function getGroupGrossWac()
    {
        return $this->groupGrossWac;
    }

    /**
     * @param mixed $groupGrossWac
     */
    public function setGroupGrossWac($groupGrossWac)
    {
        $this->implementChange($this,'groupGrossWac', $this->groupGrossWac, $groupGrossWac);
    }

    /**
     * @return mixed
     */
    public function getScheduledPrincipal()
    {
        return $this->scheduledPrincipal;
    }

    /**
     * @param mixed $scheduledPrincipal
     */
    public function setScheduledPrincipal($scheduledPrincipal)
    {
        $this->implementChange($this,'scheduledPrincipal', $this->scheduledPrincipal, $scheduledPrincipal);
    }

    /**
     * @return mixed
     */
    public function getInterestCollections()
    {
        return $this->interestCollections;
    }

    /**
     * @param mixed $interestCollections
     */
    public function setInterestCollections($interestCollections)
    {
        $this->implementChange($this,'interestCollections', $this->interestCollections, $interestCollections);
    }

    /**
     * @return mixed
     */
    public function getLiquidations()
    {
        return $this->liquidations;
    }

    /**
     * @param mixed $liquidations
     */
    public function setLiquidations($liquidations)
    {
        $this->implementChange($this,'liquidations', $this->liquidations, $liquidations);
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
        $this->implementChange($this,'recoveries', $this->recoveries, $recoveries);
    }

    /**
     * @return mixed
     */
    public function getPrepayedBalance()
    {
        return $this->prepayedBalance;
    }

    /**
     * @param mixed $prepayedBalance
     */
    public function setPrepayedBalance($prepayedBalance)
    {
        $this->implementChange($this,'prepayedBalance', $this->prepayedBalance, $prepayedBalance);
    }

    /**
     * @return mixed
     */
    public function getPrepayedLoans()
    {
        return $this->prepayedLoans;
    }

    /**
     * @param mixed $prepayedLoans
     */
    public function setPrepayedLoans($prepayedLoans)
    {
        $this->implementChange($this,'prepayedLoans', $this->prepayedLoans, $prepayedLoans);
    }

    /**
     * @return mixed
     */
    public function getBondRegularPrincipalCalc()
    {
        return $this->bondRegularPrincipalCalc;
    }

    /**
     * @param mixed $bondRegularPrincipalCalc
     */
    public function setBondRegularPrincipalCalc($bondRegularPrincipalCalc)
    {
        $this->implementChange($this,'bondRegularPrincipalCalc', $this->bondRegularPrincipalCalc, $bondRegularPrincipalCalc);
    }

    /**
     * @return mixed
     */
    public function getUnscheduledPrincipalCalc()
    {
        return $this->unscheduledPrincipalCalc;
    }

    /**
     * @param mixed $unscheduledPrincipalCalc
     */
    public function setUnscheduledPrincipalCalc($unscheduledPrincipalCalc)
    {
        $this->implementChange($this,'unscheduledPrincipalCalc', $this->unscheduledPrincipalCalc, $unscheduledPrincipalCalc);
    }

    /**
     * @return float
     */
    public function getBondInterestPayments()
    {
        return $this->bondInterestPayments;
    }

    /**
     * @param float $bondInterestPayments
     */
    public function setBondInterestPayments($bondInterestPayments)
    {
        $this->implementChange($this,'bondInterestPayments', $this->bondInterestPayments, $bondInterestPayments);
    }

    /**
     * @return mixed
     */
    public function getRegularPrincipalPaid()
    {
        return $this->regularPrincipalPaid;
    }

    /**
     * @param mixed $regularPrincipalPaid
     */
    public function setRegularPrincipalPaid($regularPrincipalPaid)
    {
        $this->implementChange($this,'regularPrincipalPaid', $this->regularPrincipalPaid, $regularPrincipalPaid);
    }

    /**
     * @return mixed
     */
    public function getUnscheduledPrincipalPaid()
    {
        return $this->unscheduledPrincipalPaid;
    }

    /**
     * @param mixed $unscheduledPrincipalPaid
     */
    public function setUnscheduledPrincipalPaid($unscheduledPrincipalPaid)
    {
        $this->implementChange($this,'unscheduledPrincipalPaid', $this->unscheduledPrincipalPaid, $unscheduledPrincipalPaid);
    }

    /**
     * @return mixed
     */
    public function getUpdateStatus()
    {
        return $this->updateStatus;
    }

    /**
     * @param mixed $updateStatus
     */
    public function setUpdateStatus($updateStatus)
    {
        $this->implementChange($this,'updateStatus', $this->updateStatus, $updateStatus);
    }

    /**
     * @return mixed
     */
    public function getGroupNetWac()
    {
        return $this->groupNetWac;
    }

    /**
     * @param mixed $groupNetWac
     */
    public function setGroupNetWac($groupNetWac)
    {
        $this->implementChange($this,'groupNetWac', $this->groupNetWac, $groupNetWac);
    }

    /**
     * @return mixed
     */
    public function getReceivablesCount()
    {
        return $this->receivablesCount;
    }

    /**
     * @param mixed $receivablesCount
     */
    public function setReceivablesCount($receivablesCount)
    {
        $this->implementChange($this,'receivablesCount', $this->receivablesCount, $receivablesCount);
    }

    /**
     * @return mixed
     */
    public function getGroupSeniorPct()
    {
        return $this->groupSeniorPct;
    }

    /**
     * @param mixed $groupSeniorPct
     */
    public function setGroupSeniorPct($groupSeniorPct)
    {
        $this->implementChange($this,'groupSeniorPct', $this->groupSeniorPct, $groupSeniorPct);
    }

    /**
     * @return mixed
     */
    public function getGroupSubPct()
    {
        return $this->groupSubPct;
    }

    /**
     * @param mixed $groupSubPct
     */
    public function setGroupSubPct($groupSubPct)
    {
        $this->implementChange($this,'groupSubPct', $this->groupSubPct, $groupSubPct);
    }

    /**
     * @return mixed
     */
    public function getIsHistory()
    {
        return $this->isHistory;
    }

    /**
     * @param mixed $isHistory
     */
    public function setIsHistory($isHistory)
    {
        $this->implementChange($this,'isHistory', $this->isHistory, $isHistory);
    }

    /**
     * @return Delinquency
     */
    public function getDelinquency()
    {
        return $this->delinquency;
    }

    /**
     * @param Delinquency $delinquency
     */
    public function setDelinquency(Delinquency $delinquency)
    {
        $this->implementChange($this,'delinquency', $this->delinquency, $delinquency);
    }



}