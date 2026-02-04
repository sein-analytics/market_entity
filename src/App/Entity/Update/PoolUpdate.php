<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 * Date: 6/16/16
 * Time: 1:30 PM
 */

namespace App\Entity\Update;

use DateTime;
use App\Entity\DomainObject;
use App\Service\CreatePropertiesArrayTrait;
use App\Entity\Period;
use App\Entity\Pool;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
#[ORM\Table(name: 'PoolUpdate')]
#[ORM\Index(name: 'period_pool_idx', columns: ['period_id', 'pool_id'])]
#[ORM\Entity]
#[ORM\ChangeTrackingPolicy('NOTIFY')]
class PoolUpdate extends DomainObject
{
    use CreatePropertiesArrayTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    protected int $id;

    /**
     * @var Pool
     **/
    #[ORM\ManyToOne(targetEntity:  Pool::class, inversedBy: 'poolUpdates')]
    protected $pool;

    /**
     * @var Period
     **/
    #[ORM\ManyToOne(targetEntity:  Period::class, inversedBy: 'poolUpdates')]
    protected $period;

    /**
     * @var ArrayCollection
     **/
    #[ORM\OneToMany(targetEntity:  LoanUpdate::class, mappedBy: 'pool')]
    protected $loans;

    /**
     * @var DateTime|null
     **/
    #[ORM\Column(type: 'datetime')]
    protected DateTime|null $reportDate;

    /**
     * @var float|null $endingBalance
     */
    #[ORM\Column(type: 'float', precision: 14, scale: 2, nullable: true)]
    protected float|null $endingBalance;

    /**
     * @var float|null $startingBalance
     */
    #[ORM\Column(type: 'float', precision: 14, scale: 2, nullable: true)]
    protected float|null $startingBalance;

    /**
     * @var float|null $cumulativeLosses
     */
    #[ORM\Column(type: 'float', precision: 14, scale: 2, nullable: true)]
    protected float|null $cumulativeLosses;

    /**
     * Period starting gross weighted average coupon
     * @var float|null $groupGrossWac
     **/
    #[ORM\Column(type: 'float', precision: 9, scale: 5, nullable: true)]
    protected float|null $groupGrossWac;

    /**
     * Current Period's scheduled principal payments received
     * @var float|null $scheduledPrincipal
     **/
    #[ORM\Column(type: 'float', precision: 12, scale: 2, nullable: true)]
    protected float|null $scheduledPrincipal;

    /**
     * Current Period's interest payments received
     * @var float|null $interestCollections
     **/
    #[ORM\Column(type: 'float', precision: 12, scale: 2, nullable: true)]
    protected float|null $interestCollections;

    /**
     * Current Period's liquidated balance
     * @var float|null $liquidations
     **/
    #[ORM\Column(type: 'float', precision: 12, scale: 2, nullable: true)]
    protected float|null $liquidations;

    /**
     * Current Period's recoveries from liquidated loans
     * @var float|null $recoveries
     **/
    #[ORM\Column(type: 'float', precision: 12, scale: 2, nullable: true)]
    protected float|null $recoveries;

    /**
     * Current Period's pre-payed balance
     * @var float|null $prepayedBalance
     **/
    #[ORM\Column(type: 'float', precision: 12, scale: 2, nullable: true)]
    protected float|null $prepayedBalance;

    /**
     * Current Period's number of loans prepaying
     * @var float|null $prepayedLoans
     **/
    #[ORM\Column(type: 'float', precision: 12, scale: 3, nullable: true)]
    protected float|null $prepayedLoans;

    /**
     * regular principal calculation--expected principal to be paid to the notes
     * @var float|null $bondRegularPrincipalCalc
     **/
    #[ORM\Column(type: 'float', precision: 15, scale: 3, nullable: true)]
    protected float|null $bondRegularPrincipalCalc;

    /**
     * supplemental principal calculation--in addition to the regular principal
     * @var float|null $unscheduledPrincipalCalc
     **/
    #[ORM\Column(type: 'float', precision: 15, scale: 3, nullable: true)]
    protected float|null $unscheduledPrincipalCalc;

    /**
     * Holds total interest payments to the notes for each forecast period
     * in the deal waterfall engine calculate()
     * @var float|null $bondInterestPayments
     */
    protected float|null $bondInterestPayments;

    /**
     * Actual amount of regular principal paid to the notes
     * @var float|null $regularPrincipalPaid
     **/
    #[ORM\Column(type: 'float', precision: 15, scale: 3, nullable: true)]
    protected float|null $regularPrincipalPaid;

    /**
     * Actual amount of regular principal paid to the notes
     * @var float|null $unscheduledPrincipalPaid
     **/
    #[ORM\Column(type: 'float', precision: 15, scale: 3, nullable: true)]
    protected float|null $unscheduledPrincipalPaid;

    /**
     * @var int $updateStatus
     **/
    #[ORM\Column(type: 'integer', nullable: false)]
    protected int $updateStatus = 1;

    /**
     * @var float|null $groupNetWac
     */
    #[ORM\Column(type: 'float', precision: 10, scale: 7, nullable: true)]
    protected float|null $groupNetWac;

    /**
     * @var int|null $receivablesCount
     */
    #[ORM\Column(type: 'integer', nullable: true)]
    protected int|null $receivablesCount;

    /**
     * @var float|null $groupSeniorPct
     */
    #[ORM\Column(type: 'float', precision: 14, scale: 2, nullable: true)]
    protected float|null $groupSeniorPct;

    /**
     * @var float|null $groupSubPct
     */
    #[ORM\Column(type: 'float', precision: 14, scale: 2, nullable: true)]
    protected float|null $groupSubPct;

    /**
     * Indicate whether collateral is historic or forecast
     * @var int|null $isHistory
     */
    #[ORM\Column(type: 'integer', nullable: true)]
    protected int|null $isHistory = 0;
    
    /**
     * @var Delinquency  
     */
    #[ORM\OneToOne(targetEntity:  Delinquency::class, inversedBy: 'poolUpdate')]
    protected $delinquency;
    
    public function __construct()
    {
        $this->loans = new ArrayCollection();
        parent::__construct();
    }

    /**
     * @return int
     */
    public function getId():int
    {
        return $this->id;
    }

    /**
     * @return Pool
     */
    public function getPool():Pool
    {
        return $this->pool;
    }

    /**
     * @param Pool $pool
     */
    public function setPool(Pool $pool):void
    {
        $this->implementChange($this,'pool', $this->pool, $pool);
    }

    /**
     * @return Period|null
     */
    public function getPeriod():?Pool
    {
        return $this->period;
    }

    /**
     * @param Period $period
     */
    public function setPeriod(Period $period):void
    {
        $this->implementChange($this,'period', $this->period, $period);
    }

    /**
     * @return ArrayCollection
     */
    public function getLoans():ArrayCollection
    {
        return $this->loans;
    }

    /**
     * @param LoanUpdate $loanUpdate
     */
    public function addLoanUpdate(LoanUpdate $loanUpdate):void{
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
     * @return DateTime|null
     */
    public function getReportDate():?DateTime
    {
        return $this->reportDate;
    }

    /**
     * @param DateTime $reportDate
     */
    public function setReportDate(DateTime $reportDate):void
    {
        $this->implementChange($this,'reportDate', $this->reportDate, $reportDate);
    }

    /**
     * @return float|null
     */
    public function getEndingBalance():?float
    {
        return $this->endingBalance;
    }

    /**
     * @param float  $endingBalance
     */
    public function setEndingBalance(float $endingBalance):void
    {
        $this->implementChange($this,'endingBalance', $this->endingBalance, $endingBalance);
    }

    /**
     * @return float|null
     */
    public function getStartingBalance():?float
    {
        return $this->startingBalance;
    }

    /**
     * @param float $startingBalance
     */
    public function setStartingBalance(float $startingBalance):void
    {
        $this->implementChange($this,'startingBalance', $this->startingBalance, $startingBalance);
    }

    /**
     * @return float|null
     */
    public function getGroupGrossWac():?float
    {
        return $this->groupGrossWac;
    }

    /**
     * @param float $groupGrossWac
     */
    public function setGroupGrossWac(float $groupGrossWac):void
    {
        $this->implementChange($this,'groupGrossWac', $this->groupGrossWac, $groupGrossWac);
    }

    /**
     * @return float|null
     */
    public function getScheduledPrincipal():?float
    {
        return $this->scheduledPrincipal;
    }

    /**
     * @param float $scheduledPrincipal
     */
    public function setScheduledPrincipal(float $scheduledPrincipal):void
    {
        $this->implementChange($this,'scheduledPrincipal', $this->scheduledPrincipal, $scheduledPrincipal);
    }

    /**
     * @return float|null
     */
    public function getInterestCollections():?float
    {
        return $this->interestCollections;
    }

    /**
     * @param float $interestCollections
     */
    public function setInterestCollections(float $interestCollections):void
    {
        $this->implementChange($this,'interestCollections', $this->interestCollections, $interestCollections);
    }

    /**
     * @return float|null
     */
    public function getLiquidations():?float
    {
        return $this->liquidations;
    }

    /**
     * @param float $liquidations
     */
    public function setLiquidations(float $liquidations):void
    {
        $this->implementChange($this,'liquidations', $this->liquidations, $liquidations);
    }

    /**
     * @return float|null
     */
    public function getRecoveries():?float
    {
        return $this->recoveries;
    }

    /**
     * @param float $recoveries
     */
    public function setRecoveries(float $recoveries):void
    {
        $this->implementChange($this,'recoveries', $this->recoveries, $recoveries);
    }

    /**
     * @return float|null
     */
    public function getPrepayedBalance():?float
    {
        return $this->prepayedBalance;
    }

    /**
     * @param float $prepayedBalance
     */
    public function setPrepayedBalance(float $prepayedBalance):void
    {
        $this->implementChange($this,'prepayedBalance', $this->prepayedBalance, $prepayedBalance);
    }

    /**
     * @return float|null
     */
    public function getPrepayedLoans():?float
    {
        return $this->prepayedLoans;
    }

    /**
     * @param float $prepayedLoans
     */
    public function setPrepayedLoans(float $prepayedLoans):void
    {
        $this->implementChange($this,'prepayedLoans', $this->prepayedLoans, $prepayedLoans);
    }

    /**
     * @return float|null
     */
    public function getBondRegularPrincipalCalc():?float
    {
        return $this->bondRegularPrincipalCalc;
    }

    /**
     * @param float $bondRegularPrincipalCalc
     */
    public function setBondRegularPrincipalCalc(float $bondRegularPrincipalCalc):void
    {
        $this->implementChange($this,'bondRegularPrincipalCalc', $this->bondRegularPrincipalCalc, $bondRegularPrincipalCalc);
    }

    /**
     * @return float|null
     */
    public function getUnscheduledPrincipalCalc():?float
    {
        return $this->unscheduledPrincipalCalc;
    }

    /**
     * @param float $unscheduledPrincipalCalc
     */
    public function setUnscheduledPrincipalCalc(float $unscheduledPrincipalCalc):void
    {
        $this->implementChange($this,'unscheduledPrincipalCalc', $this->unscheduledPrincipalCalc, $unscheduledPrincipalCalc);
    }

    /**
     * @return float|null
     */
    public function getBondInterestPayments():?float
    {
        return $this->bondInterestPayments;
    }

    /**
     * @param float $bondInterestPayments
     */
    public function setBondInterestPayments(float $bondInterestPayments):void
    {
        $this->implementChange($this,'bondInterestPayments', $this->bondInterestPayments, $bondInterestPayments);
    }

    /**
     * @return float|null
     */
    public function getRegularPrincipalPaid():?float
    {
        return $this->regularPrincipalPaid;
    }

    /**
     * @param float $regularPrincipalPaid
     */
    public function setRegularPrincipalPaid(float $regularPrincipalPaid):void
    {
        $this->implementChange($this,'regularPrincipalPaid', $this->regularPrincipalPaid, $regularPrincipalPaid);
    }

    /**
     * @return float|null
     */
    public function getUnscheduledPrincipalPaid():?float
    {
        return $this->unscheduledPrincipalPaid;
    }

    /**
     * @param float $unscheduledPrincipalPaid
     */
    public function setUnscheduledPrincipalPaid(float $unscheduledPrincipalPaid):void
    {
        $this->implementChange($this,'unscheduledPrincipalPaid', $this->unscheduledPrincipalPaid, $unscheduledPrincipalPaid);
    }

    /**
     * @return int
     */
    public function getUpdateStatus():int
    {
        return $this->updateStatus;
    }

    /**
     * @param int $updateStatus
     */
    public function setUpdateStatus(int $updateStatus):void
    {
        $this->implementChange($this,'updateStatus', $this->updateStatus, $updateStatus);
    }

    /**
     * @return float|null
     */
    public function getGroupNetWac():?float
    {
        return $this->groupNetWac;
    }

    /**
     * @param float  $groupNetWac
     */
    public function setGroupNetWac(float $groupNetWac):void
    {
        $this->implementChange($this,'groupNetWac', $this->groupNetWac, $groupNetWac);
    }

    /**
     * @return int|null
     */
    public function getReceivablesCount():?int
    {
        return $this->receivablesCount;
    }

    /**
     * @param int $receivablesCount
     */
    public function setReceivablesCount(int $receivablesCount):void
    {
        $this->implementChange($this,'receivablesCount', $this->receivablesCount, $receivablesCount);
    }

    /**
     * @return float|null
     */
    public function getGroupSeniorPct():?float
    {
        return $this->groupSeniorPct;
    }

    /**
     * @param float $groupSeniorPct
     */
    public function setGroupSeniorPct(float $groupSeniorPct):void
    {
        $this->implementChange($this,'groupSeniorPct', $this->groupSeniorPct, $groupSeniorPct);
    }

    /**
     * @return float|null
     */
    public function getGroupSubPct():?float
    {
        return $this->groupSubPct;
    }

    /**
     * @param float $groupSubPct
     */
    public function setGroupSubPct(float $groupSubPct):void
    {
        $this->implementChange($this,'groupSubPct', $this->groupSubPct, $groupSubPct);
    }

    /**
     * @return int|null
     */
    public function getIsHistory():?int
    {
        return $this->isHistory;
    }

    /**
     * @param int $isHistory
     */
    public function setIsHistory(int $isHistory):void
    {
        $this->implementChange($this,'isHistory', $this->isHistory, $isHistory);
    }

    /**
     * @return Delinquency|null
     */
    public function getDelinquency():?Delinquency
    {
        return $this->delinquency;
    }

    /**
     * @param Delinquency $delinquency
     */
    public function setDelinquency(Delinquency $delinquency):void
    {
        $this->implementChange($this,'delinquency', $this->delinquency, $delinquency);
    }



}