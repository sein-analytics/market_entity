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
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\ChangeTrackingPolicy;
use App\Entity\Bond;
use App\Entity\Period;

/**
 * @author Samuel Belu-John
 *
 * @ORM\Entity
 * @ORM\Table(name="BondUpdate")
 * @ChangeTrackingPolicy("NOTIFY")
 */
class BondUpdate extends DomainObject
{   
    use CreatePropertiesArrayTrait;

    /**
     * @ORM\Id @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     * @var int
     **/
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\Bond", inversedBy="updates")
     * @var \App\Entity\Bond
     **/
    protected $bond;

    /** @ORM\Column(type="decimal", precision=14, scale=2) **/
    protected $startingBalance = 0;

    /** @ORM\Column(type="decimal", precision=14, scale=2) **/
    protected $endingBalance = 0;

    /** @ORM\Column(name="reportDate", type = "datetime")
     * @var \DateTime
     **/
    protected $reportDate;

    /** @ORM\Column(type="decimal", precision=14, scale=2, nullable=true) **/
    protected $calculatedInterest;

    /** @ORM\Column(type="decimal", precision=14, scale=2) **/
    protected $interestPaid = 0;

    /** @ORM\Column(type="decimal", precision=14, scale=2, nullable=true) **/
    protected $scheduledPrincipalPayment;

    /** @ORM\Column(type="decimal", precision=14, scale=2, nullable=true) **/
    protected $principalPaid;

    /** @ORM\Column(type="decimal", precision=14, scale=2, nullable=true) **/
    protected $unscheduledPrincipalPayment;

    /** @ORM\Column(type="decimal", precision=14, scale=2) **/
    protected $principalLoss = 0;

    /** @ORM\Column(type="decimal", precision=14, scale=2, nullable=true) **/
    protected $interestLoss;

    /** @ORM\Column(type="decimal", precision=14, scale=2, nullable=true) **/
    protected $unpaidInterest;

    /** @ORM\Column(type="decimal", precision=14, scale=2, nullable=true) **/
    protected $deferredInterest;

    /** @ORM\Column(type="decimal", precision=14, scale=2, nullable=true) **/
    protected $interestCarry;

    /** @ORM\Column(type="decimal", precision=14, scale=2, nullable=true) **/
    protected $cumulativeRealizedLosses;

    /** @ORM\Column(type="decimal", precision=8, scale=7, nullable=true) **/
    protected $bondFactor;

    /** @ORM\Column(type="decimal", precision=8, scale=7, nullable=true) **/
    protected $currentOC;

    /** @ORM\Column(type="decimal", precision=8, scale=7, nullable=true) **/
    protected $interestShortfall;

    /** @ORM\Column(type="decimal", precision=8, scale=7, nullable=true) **/
    protected $unsupportedIntShortfall;

    /**
     * @ORM\OneToMany(targetEntity="\App\Entity\Bond\ComponentUpdate", mappedBy="bondUpdate")
     * @var ArrayCollection
     **/
    protected $components;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\Period", inversedBy="bondUpdates")
     * @var \App\Entity\Period
     **/
    protected $period;

    /** @ORM\Column(type="decimal", precision=14, scale=2, nullable=true) **/
    protected $startReserveBalance;

    /** @ORM\Column(type="decimal", precision=14, scale=2, nullable=true) **/
    protected $reserveDraw;

    /** @ORM\Column(type="decimal", precision=14, scale=2, nullable=true) **/
    protected $reserveDeposit;

    /** @ORM\Column(type="decimal", precision=14, scale=2, nullable=true) **/
    protected $endReserveBalance;

    /** @ORM\Column(type="integer", nullable=true)  **/
    protected $isHistory = 0;

    /** @ORM\Column(type="decimal", precision=14, scale=2, nullable=true)  **/
    protected $netHedge;

    /** @ORM\Column(type="decimal", precision=14, scale=2, nullable=true)  **/
    protected $accretionAmount;

    /**
     * @ORM\Column(type="integer", nullable=false)
     **/
    protected $updateStatus = 1;

    public function __construct()
    {
        $this->components = new ArrayCollection();
        parent::__construct();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Bond
     */
    public function getBond()
    {
        return $this->bond;
    }

    /**
     * @param Bond $bond
     */
    public function setBond(Bond $bond)
    {
        $this->implementChange($this,'bond', $this->bond, $bond);
    }

    /**
     * @return mixed
     */
    public function getStartingBalance()
    {
        return $this->startingBalance;
    }

    /**
     * @param double $startingBalance
     */
    public function setStartingBalance($startingBalance)
    {
        $this->implementChange($this,'startingBalance', $this->startingBalance, $startingBalance);
    }

    /**
     * @return double
     */
    public function getEndingBalance()
    {
        return $this->endingBalance;
    }

    /**
     * @param double $endingBalance
     */
    public function setEndingBalance($endingBalance)
    {
        $this->implementChange($this,'endingBalance', $this->endingBalance, $endingBalance);
    }

    /**
     * @return \DateTime
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
     * @return double
     */
    public function getCalculatedInterest()
    {
        return $this->calculatedInterest;
    }

    /**
     * @param double $calculatedInterest
     */
    public function setCalculatedInterest($calculatedInterest)
    {
        $this->implementChange($this,'calculatedInterest', $this->calculatedInterest, $calculatedInterest);
    }

    /**
     * @return double
     */
    public function getInterestPaid()
    {
        return $this->interestPaid;
    }

    /**
     * @param double $interestPaid
     */
    public function setInterestPaid($interestPaid)
    {
        $this->implementChange($this,'interestPaid', $this->interestPaid, $interestPaid);
    }

    /**
     * @return double
     */
    public function getScheduledPrincipalPayment()
    {
        return $this->scheduledPrincipalPayment;
    }

    /**
     * @param double $scheduledPrincipalPayment
     */
    public function setScheduledPrincipalPayment($scheduledPrincipalPayment)
    {
        $this->implementChange($this,'scheduledPrincipalPayment', $this->scheduledPrincipalPayment, $scheduledPrincipalPayment);
    }

    /**
     * @return double
     */
    public function getPrincipalPaid()
    {
        return $this->principalPaid;
    }

    /**
     * @param double $principalPaid
     */
    public function setPrincipalPaid($principalPaid)
    {
        $this->implementChange($this,'principalPaid', $this->principalPaid, $principalPaid);
    }

    /**
     * @return double
     */
    public function getUnscheduledPrincipalPayment()
    {
        return $this->unscheduledPrincipalPayment;
    }

    /**
     * @param double $unscheduledPrincipalPayment
     */
    public function setUnscheduledPrincipalPayment($unscheduledPrincipalPayment)
    {
        $this->implementChange($this,'unscheduledPrincipalPayment', $this->unscheduledPrincipalPayment, $unscheduledPrincipalPayment);
    }

    /**
     * @return double
     */
    public function getPrincipalLoss()
    {
        return $this->principalLoss;
    }

    /**
     * @param double $principalLoss
     */
    public function setPrincipalLoss($principalLoss)
    {
        $this->implementChange($this,'principalLoss', $this->principalLoss, $principalLoss);
    }

    /**
     * @return mixed
     */
    public function getInterestLoss()
    {
        return $this->interestLoss;
    }

    /**
     * @param mixed $interestLoss
     */
    public function setInterestLoss($interestLoss)
    {
        $this->implementChange($this,'interestLoss', $this->interestLoss, $interestLoss);
    }

    /**
     * @return mixed
     */
    public function getUnpaidInterest()
    {
        return $this->unpaidInterest;
    }

    /**
     * @param mixed $unpaidInterest
     */
    public function setUnpaidInterest($unpaidInterest)
    {
        $this->implementChange($this,'unpaidInterest', $this->unpaidInterest, $unpaidInterest);
    }

    /**
     * @return mixed
     */
    public function getDeferredInterest()
    {
        return $this->deferredInterest;
    }

    /**
     * @param mixed $deferredInterest
     */
    public function setDeferredInterest($deferredInterest)
    {
        $this->implementChange($this,'deferredInterest', $this->deferredInterest, $deferredInterest);
    }

    /**
     * @return mixed
     */
    public function getInterestCarry()
    {
        return $this->interestCarry;
    }

    /**
     * @param mixed $interestCarry
     */
    public function setInterestCarry($interestCarry)
    {
        $this->implementChange($this,'interestCarry', $this->interestCarry, $interestCarry);
    }

    /**
     * @return mixed
     */
    public function getCumulativeRealizedLosses()
    {
        return $this->cumulativeRealizedLosses;
    }

    /**
     * @param mixed $cumulativeRealizedLosses
     */
    public function setCumulativeRealizedLosses($cumulativeRealizedLosses)
    {
        $this->implementChange($this,'cumulativeRealizedLosses', $this->cumulativeRealizedLosses, $cumulativeRealizedLosses);
    }

    /**
     * @return mixed
     */
    public function getBondFactor()
    {
        return $this->bondFactor;
    }

    /**
     * @param mixed $bondFactor
     */
    public function setBondFactor($bondFactor)
    {
        $this->implementChange($this,'bondFactor', $this->bondFactor, $bondFactor);
    }

    /**
     * @return mixed
     */
    public function getCurrentOC()
    {
        return $this->currentOC;
    }

    /**
     * @param mixed $currentOC
     */
    public function setCurrentOC($currentOC)
    {
        $this->implementChange($this,'currentOC', $this->currentOC, $currentOC);
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
        $this->implementChange($this,'interestShortfall', $this->interestShortfall, $interestShortfall);
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
        $this->implementChange($this,'unsupportedIntShortfall', $this->unsupportedIntShortfall, $unsupportedIntShortfall);
    }

    /**
     * @return ArrayCollection
     */
    public function getComponents()
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
    public function getPeriod()
    {
        return $this->period;
    }

    /**
     * @param Period $period
     */
    public function setPeriod(Period $period)
    {
        $this->period = $period;
    }

    /**
     * @return mixed
     */
    public function getStartReserveBalance()
    {
        return $this->startReserveBalance;
    }

    /**
     * @param mixed $startReserveBalance
     */
    public function setStartReserveBalance($startReserveBalance)
    {
        $this->startReserveBalance = $startReserveBalance;
    }

    /**
     * @return mixed
     */
    public function getReserveDraw()
    {
        return $this->reserveDraw;
    }

    /**
     * @param mixed $reserveDraw
     */
    public function setReserveDraw($reserveDraw)
    {
        $this->reserveDraw = $reserveDraw;
    }

    /**
     * @return mixed
     */
    public function getReserveDeposit()
    {
        return $this->reserveDeposit;
    }

    /**
     * @param mixed $reserveDeposit
     */
    public function setReserveDeposit($reserveDeposit)
    {
        $this->reserveDeposit = $reserveDeposit;
    }

    /**
     * @return mixed
     */
    public function getEndReserveBalance()
    {
        return $this->endReserveBalance;
    }

    /**
     * @param mixed $endReserveBalance
     */
    public function setEndReserveBalance($endReserveBalance)
    {
        $this->endReserveBalance = $endReserveBalance;
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
        $this->isHistory = $isHistory;
    }

    /**
     * @return mixed
     */
    public function getNetHedge()
    {
        return $this->netHedge;
    }

    /**
     * @param mixed $netHedge
     */
    public function setNetHedge($netHedge)
    {
        $this->netHedge = $netHedge;
    }

    /**
     * @return mixed
     */
    public function getAccretionAmount()
    {
        return $this->accretionAmount;
    }

    /**
     * @param mixed $accretionAmount
     */
    public function setAccretionAmount($accretionAmount)
    {
        $this->accretionAmount = $accretionAmount;
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
        $this->updateStatus = $updateStatus;
    }

}