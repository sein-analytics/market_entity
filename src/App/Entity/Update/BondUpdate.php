<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 * Date: 6/15/16
 * Time: 1:39 PM
 */

namespace App\Entity\Update;

use App\Entity\DomainObject;
use App\Service\CreatePropertiesArrayTrait;
use Doctrine\Common\Collections\ArrayCollection;
use App\Entity\Bond;
use App\Entity\Period;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\ChangeTrackingPolicy;

/**
 * @author Samuel Belu-John
 * @ORM\Entity
 * @ORM\Table(name="BondUpdate")
 * @ORM\ChangeTrackingPolicy("NOTIFY")
 */
class BondUpdate extends DomainObject
{   
    use CreatePropertiesArrayTrait;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     * @var int
     **/
    protected int $id;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\Bond", inversedBy="updates")
     * @var Bond
     **/
    protected $bond;

    /**
     * @ORM\Column(type="decimal", precision=14, scale=2)
     * @var  float
     **/
    protected float $startingBalance = 0.0;

    /**
     * @ORM\Column(type="decimal", precision=14, scale=2)
     * @var float
     **/
    protected float $endingBalance = 0.0;

    /**
     * @ORM\Column(name="reportDate", type = "datetime")
     * @var \DateTime
     **/
    protected  $reportDate;

    /**
     * @ORM\Column(type="decimal", precision=14, scale=2, nullable=true)
     * @var ?float
     **/
    protected ?float $calculatedInterest;

    /**
     * @ORM\Column(type="decimal", precision=14, scale=2)
     * @var float
     **/
    protected float $interestPaid = 0.0;

    /**
     * @ORM\Column(type="decimal", precision=14, scale=2, nullable=true)
     * @var ?float
     **/
    protected ?float $scheduledPrincipalPayment;

    /**
     * @ORM\Column(type="decimal", precision=14, scale=2, nullable=true)
     * @var ?float
     **/
    protected ?float $principalPaid;

    /**
     * @ORM\Column(type="decimal", precision=14, scale=2, nullable=true)
     * @var ?float
     **/
    protected ?float $unscheduledPrincipalPayment;

    /**
     * @ORM\Column(type="decimal", precision=14, scale=2)
     * @var float
     **/
    protected float $principalLoss = 0.0;

    /**
     * @ORM\Column(type="decimal", precision=14, scale=2, nullable=true)
     * @var ?float
     */
    protected ?float $interestLoss;

    /**
     * @ORM\Column(type="decimal", precision=14, scale=2, nullable=true)
     * @var ?float
     */
    protected ?float $unpaidInterest;

    /**
     * @ORM\Column(type="decimal", precision=14, scale=2, nullable=true)
     * @var ?float
     */
    protected ?float $deferredInterest;

    /**
     * @ORM\Column(type="decimal", precision=14, scale=2, nullable=true)
     * @var ?float
     */
    protected ?float $interestCarry;

    /**
     * @ORM\Column(type="decimal", precision=14, scale=2, nullable=true)
     * @var ?float
     */
    protected ?float $cumulativeRealizedLosses;

    /**
     * @ORM\Column(type="decimal", precision=8, scale=7, nullable=true)
     * @var ?float
     */
    protected ?float $bondFactor;

    /**
     * @ORM\Column(type="decimal", precision=8, scale=7, nullable=true)
     * @var ?float
     **/
    protected ?float $currentOC;

    /**
     * @ORM\Column(type="decimal", precision=8, scale=7, nullable=true)
     *@var ?float
     **/
    protected ?float $interestShortfall;

    /**
     * @ORM\Column(type="decimal", precision=8, scale=7, nullable=true)
     *@var ?float
     **/
    protected ?float $unsupportedIntShortfall;

    /**
     * @ORM\OneToMany(targetEntity="\App\Entity\Bond\ComponentUpdate", mappedBy="bondUpdate")
     * @var ArrayCollection
     **/
    protected $components;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\Period", inversedBy="bondUpdates")
     * @var Period
     **/
    protected $period;

    /**
     * @ORM\Column(type="decimal", precision=14, scale=2, nullable=true)
     * @var ?float
     */
    protected ?float $startReserveBalance;

    /**
     * @ORM\Column(type="decimal", precision=14, scale=2, nullable=true)
     * @var ?float
     **/
    protected ?float $reserveDraw;

    /**
     * @ORM\Column(type="decimal", precision=14, scale=2, nullable=true)
     * @var ?float
     **/
    protected ?float $reserveDeposit;

    /**
     * @ORM\Column(type="decimal", precision=14, scale=2, nullable=true)
     * @var ?float
     **/
    protected ?float $endReserveBalance;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @var ?int
     **/
    protected ?int $isHistory = 0;

    /**
     * @ORM\Column(type="decimal", precision=14, scale=2, nullable=true)
     * @var ?float
     **/
    protected ?float $netHedge;

    /**
     * @ORM\Column(type="decimal", precision=14, scale=2, nullable=true)
     * @var ?float
     **/
    protected ?float $accretionAmount;

    /**
     * @ORM\Column(type="integer", nullable=false)
     * @var int
     **/
    protected int $updateStatus = 1;

    public function __construct()
    {
        $this->components = new ArrayCollection();
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
     * @return ?Bond
     */
    public function getBond():?Bond
    {
        return $this->bond;
    }

    /**
     * @param Bond $bond
     */
    public function setBond(Bond $bond):void
    {
        $this->implementChange($this,'bond', $this->bond, $bond);
    }

    /**
     * @return float
     */
    public function getStartingBalance():float
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
     * @return float
     */
    public function getEndingBalance():float
    {
        return $this->endingBalance;
    }

    /**
     * @param float $endingBalance
     */
    public function setEndingBalance(float $endingBalance):void
    {
        $this->implementChange($this,'endingBalance', $this->endingBalance, $endingBalance);
    }

    /**
     * @return \DateTime
     */
    public function getReportDate():\DateTime
    {
        return $this->reportDate;
    }

    /**
     * @param \DateTime $reportDate
     */
    public function setReportDate(\DateTime $reportDate):void
    {
        $this->implementChange($this,'reportDate', $this->reportDate, $reportDate);
    }

    /**
     * @return ?float
     */
    public function getCalculatedInterest():?float
    {
        return $this->calculatedInterest;
    }

    /**
     * @param float $calculatedInterest
     */
    public function setCalculatedInterest(float $calculatedInterest):void
    {
        $this->implementChange($this,'calculatedInterest', $this->calculatedInterest, $calculatedInterest);
    }

    /**
     * @return ?float
     */
    public function getInterestPaid():?float
    {
        return $this->interestPaid;
    }

    /**
     * @param float $interestPaid
     */
    public function setInterestPaid(float $interestPaid):void
    {
        $this->implementChange($this,'interestPaid', $this->interestPaid, $interestPaid);
    }

    /**
     * @return ?float
     */
    public function getScheduledPrincipalPayment():?float
    {
        return $this->scheduledPrincipalPayment;
    }

    /**
     * @param float $scheduledPrincipalPayment
     */
    public function setScheduledPrincipalPayment(float $scheduledPrincipalPayment):void
    {
        $this->implementChange($this,'scheduledPrincipalPayment', $this->scheduledPrincipalPayment, $scheduledPrincipalPayment);
    }

    /**
     * @return ?float
     */
    public function getPrincipalPaid():?float
    {
        return $this->principalPaid;
    }

    /**
     * @param float $principalPaid
     */
    public function setPrincipalPaid(float $principalPaid):void
    {
        $this->implementChange($this,'principalPaid', $this->principalPaid, $principalPaid);
    }

    /**
     * @return ?float
     */
    public function getUnscheduledPrincipalPayment():?float
    {
        return $this->unscheduledPrincipalPayment;
    }

    /**
     * @param float $unscheduledPrincipalPayment
     */
    public function setUnscheduledPrincipalPayment(float $unscheduledPrincipalPayment):void
    {
        $this->implementChange($this,'unscheduledPrincipalPayment', $this->unscheduledPrincipalPayment, $unscheduledPrincipalPayment);
    }

    /**
     * @return float
     */
    public function getPrincipalLoss():float
    {
        return $this->principalLoss;
    }

    /**
     * @param float $principalLoss
     */
    public function setPrincipalLoss(float $principalLoss):void
    {
        $this->implementChange($this,'principalLoss', $this->principalLoss, $principalLoss);
    }

    /**
     * @return ?float
     */
    public function getInterestLoss():?float
    {
        return $this->interestLoss;
    }

    /**
     * @param float $interestLoss
     */
    public function setInterestLoss(float $interestLoss):void
    {
        $this->implementChange($this,'interestLoss', $this->interestLoss, $interestLoss);
    }

    /**
     * @return ?float
     */
    public function getUnpaidInterest():?float
    {
        return $this->unpaidInterest;
    }

    /**
     * @param float $unpaidInterest
     */
    public function setUnpaidInterest(float $unpaidInterest):void
    {
        $this->implementChange($this,'unpaidInterest', $this->unpaidInterest, $unpaidInterest);
    }

    /**
     * @return ?float
     */
    public function getDeferredInterest():?float
    {
        return $this->deferredInterest;
    }

    /**
     * @param float $deferredInterest
     */
    public function setDeferredInterest(float $deferredInterest):void
    {
        $this->implementChange($this,'deferredInterest', $this->deferredInterest, $deferredInterest);
    }

    /**
     * @return ?float
     */
    public function getInterestCarry():?float
    {
        return $this->interestCarry;
    }

    /**
     * @param float $interestCarry
     */
    public function setInterestCarry(float $interestCarry):void
    {
        $this->implementChange($this,'interestCarry', $this->interestCarry, $interestCarry);
    }

    /**
     * @return ?float
     */
    public function getCumulativeRealizedLosses():?float
    {
        return $this->cumulativeRealizedLosses;
    }

    /**
     * @param float $cumulativeRealizedLosses
     */
    public function setCumulativeRealizedLosses(float $cumulativeRealizedLosses):void
    {
        $this->implementChange($this,'cumulativeRealizedLosses', $this->cumulativeRealizedLosses, $cumulativeRealizedLosses);
    }

    /**
     * @return ?float
     */
    public function getBondFactor():?float
    {
        return $this->bondFactor;
    }

    /**
     * @param float $bondFactor
     */
    public function setBondFactor(float $bondFactor):void
    {
        $this->implementChange($this,'bondFactor', $this->bondFactor, $bondFactor);
    }

    /**
     * @return ?float
     */
    public function getCurrentOC():?float
    {
        return $this->currentOC;
    }

    /**
     * @param float $currentOC
     */
    public function setCurrentOC(float $currentOC):void
    {
        $this->implementChange($this,'currentOC', $this->currentOC, $currentOC);
    }

    /**
     * @return ?float
     */
    public function getInterestShortfall():?float
    {
        return $this->interestShortfall;
    }

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
    public function getUnsupportedIntShortfall():?float
    {
        return $this->unsupportedIntShortfall;
    }

    /**
     * @param float $unsupportedIntShortfall
     */
    public function setUnsupportedIntShortfall(float $unsupportedIntShortfall):void
    {
        $this->implementChange($this,'unsupportedIntShortfall', $this->unsupportedIntShortfall, $unsupportedIntShortfall);
    }

    /**
     * @return ?ArrayCollection
     */
    public function getComponents():?ArrayCollection
    {
        return $this->components;
    }

    /**
     * @param Bond\ComponentUpdate $component
     */
    public function setComponents(Bond\ComponentUpdate $component)
    {
        $this->getComponents()->add($component);
    }

    /**
     *
     * @return Period
     */
    public function getPeriod():Period
    {
        return $this->period;
    }

    /**
     * @param Period $period
     */
    public function setPeriod(Period $period):void
    {
        $this->period = $period;
    }

    /**
     * @return ?float
     */
    public function getStartReserveBalance():?float
    {
        return $this->startReserveBalance;
    }

    /**
     * @param float $startReserveBalance
     */
    public function setStartReserveBalance(float $startReserveBalance):void
    {
        $this->startReserveBalance = $startReserveBalance;
    }

    /**
     * @return ?float
     */
    public function getReserveDraw():?float
    {
        return $this->reserveDraw;
    }

    /**
     * @param float $reserveDraw
     */
    public function setReserveDraw(float $reserveDraw):void
    {
        $this->reserveDraw = $reserveDraw;
    }

    /**
     * @return ?float
     */
    public function getReserveDeposit():?float
    {
        return $this->reserveDeposit;
    }

    /**
     * @param float $reserveDeposit
     */
    public function setReserveDeposit(float $reserveDeposit):void
    {
        $this->reserveDeposit = $reserveDeposit;
    }

    /**
     * @return ?float
     */
    public function getEndReserveBalance():?float
    {
        return $this->endReserveBalance;
    }

    /**
     * @param float $endReserveBalance
     */
    public function setEndReserveBalance(float $endReserveBalance):void
    {
        $this->endReserveBalance = $endReserveBalance;
    }

    /**
     * @return ?int
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
        $this->isHistory = $isHistory;
    }

    /**
     * @return ?float
     */
    public function getNetHedge():?float
    {
        return $this->netHedge;
    }

    /**
     * @param float $netHedge
     */
    public function setNetHedge(float $netHedge):void
    {
        $this->netHedge = $netHedge;
    }

    /**
     * @return ?float
     */
    public function getAccretionAmount():?float
    {
        return $this->accretionAmount;
    }

    /**
     * @param float $accretionAmount
     */
    public function setAccretionAmount(float $accretionAmount):void
    {
        $this->accretionAmount = $accretionAmount;
    }

    /**
     * @return int
     */
    public function getUpdateStatus():int
    {
        return $this->updateStatus;
    }

    /**
     * @param int  $updateStatus
     */
    public function setUpdateStatus(int $updateStatus):void
    {
        $this->updateStatus = $updateStatus;
    }

}