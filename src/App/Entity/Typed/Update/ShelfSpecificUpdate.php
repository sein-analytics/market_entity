<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 * Date: 6/15/16
 * Time: 2:04 PM
 */

namespace App\Entity\Typed\Update;

//use Doctrine\ORM\Mapping as ORM;
use App\Entity\Period;
use App\Entity\Typed\ShelfSpecific;
//use Doctrine\ORM\Mapping\ChangeTrackingPolicy;
/**
 * \Doctrine\ORM\Mapping\Entity
 * \Doctrine\ORM\Mapping\Table(name="ShelfSpecificUpdate")
 * \Doctrine\ORM\Mapping\ChangeTrackingPolicy("NOTIFY")
 */
class ShelfSpecificUpdate extends AbstractTypeUpdate
{

    /**
     * \Doctrine\ORM\Mapping\Id
     * \Doctrine\ORM\Mapping\GeneratedValue(strategy="AUTO")
     * \Doctrine\ORM\Mapping\Column(type="integer")
     */
    protected int $id;

    /**
     * @var ShelfSpecific $shelfSpecific
     * \Doctrine\ORM\Mapping\ManyToOne(targetEntity="\App\Entity\Typed\ShelfSpecific", inversedBy="updates")
     **/
    protected $shelfSpecific;

    /**
     * @var Period $period
     * \Doctrine\ORM\Mapping\ManyToOne(targetEntity="\App\Entity\Period", inversedBy="shelfSpecifics")
     **/
    protected $period;

    /**
     * @var float $amountDue
     * \Doctrine\ORM\Mapping\Column(type = "decimal", precision=14, scale=2)
     **/
    public float $amountDue = 0;

    /**
     * @var float $amountPaid
     * \Doctrine\ORM\Mapping\Column(type = "decimal", precision=14, scale=2)
     **/
    public float $amountPaid = 0;

    /**
     * @var float $currentAmountUnpaid
     * \Doctrine\ORM\Mapping\Column(type = "decimal", precision=14, scale=2)
     **/
    public float $currentAmountUnpaid = 0;

    /**
     * @var float $cumulativeAmountUnpaid
     * \Doctrine\ORM\Mapping\Column(type = "decimal", precision=14, scale=2)
     **/
    public float $cumulativeAmountUnpaid = 0;

    /**
     * @var float $cumulativeAmountUnpaid
     * \Doctrine\ORM\Mapping\Column(type = "decimal", precision=14, scale=2)
     **/
    public float $beginningBalance = 0;

    /**
     * @var float $cumulativeAmountUnpaid
     * \Doctrine\ORM\Mapping\Column(type = "decimal", precision=14, scale=2)
     **/
    public float $endingBalance = 0;

    /**
     * @var float|null $interestRate
     * \Doctrine\ORM\Mapping\Column(type = "decimal", precision=14, scale=2, nullable=true)
     **/
    public float|null $interestRate;

    /**
     * @var float|null $interestRate
     * \Doctrine\ORM\Mapping\Column(type = "decimal", precision=14, scale=2, nullable=true)
     **/
    public float|null $deferredAmount;

    /**
     * @var float|null $calculatedInterest
     * \Doctrine\ORM\Mapping\Column(type = "decimal", precision=14, scale=2, nullable=true)
     **/
    public float|null $calculatedInterest;

    /**
     * @var float|null $interestPaid
     * \Doctrine\ORM\Mapping\Column(type = "decimal", precision=14, scale=2, nullable=true)
     **/
    public float|null $interestPaid;

    /**
     * @var float|null $unpaidInterest
     * \Doctrine\ORM\Mapping\Column(type = "decimal", precision=14, scale=2, nullable=true)
     **/
    public float|null $unpaidInterest;

    public function getId():int
    {
        return $this->id;
    }

    /**
     * @return ShelfSpecific
     */
    public function getShelfSpecific():ShelfSpecific
    {
        return $this->shelfSpecific;
    }

    /**
     * @return Period
     */
    public function getPeriod():Period {
        return $this->period;
    }

    /**
     * @param Period $period
     */
    public function setPeriod(Period $period):void {
        $this->implementChange($this,'period', $this->period, $period);
    }

    /**
     * @param ShelfSpecific $shelfSpecific
     */
    public function setShelfSpecific(ShelfSpecific $shelfSpecific):void
    {
        $this->implementChange($this,'shelfSpecific', $this->shelfSpecific, $shelfSpecific);
    }

    /**
     * @return float|null
     */
    public function getAmountDue():?float
    {
        return $this->amountDue;
    }

    /**
     * @param float $amountDue
     */
    public function setAmountDue(float $amountDue):void
    {
        $this->implementChange($this,'amountDue', $this->amountDue, $amountDue);
    }

    /**
     * @return float|null
     */
    public function getAmountPaid():?float
    {
        return $this->amountPaid;
    }

    /**
     * @param float $amountPaid
     */
    public function setAmountPaid(float $amountPaid):void
    {
        $this->implementChange($this,'amountPaid', $this->amountPaid, $amountPaid);
    }

    /**
     * @return float
     */
    public function getCurrentAmountUnpaid():float
    {
        return $this->currentAmountUnpaid;
    }

    /**
     * @param float $currentAmountUnpaid
     */
    public function setCurrentAmountUnpaid(float $currentAmountUnpaid):void
    {
        $this->implementChange($this,'currentAmountUnpaid', $this->currentAmountUnpaid, $currentAmountUnpaid);
    }

    /**
     * @return float
     */
    public function getCumulativeAmountUnpaid():float
    {
        return $this->cumulativeAmountUnpaid;
    }

    /**
     * @param float $cumulativeAmountUnpaid
     */
    public function setCumulativeAmountUnpaid(float $cumulativeAmountUnpaid):void
    {
        $this->implementChange($this,'cumulativeAmountUnpaid', $this->cumulativeAmountUnpaid, $cumulativeAmountUnpaid);
    }

    /**
     * @return float
     */
    public function getBeginningBalance():float
    {
        return $this->beginningBalance;
    }

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
     * @return float|null
     */
    public function getInterestRate():?float
    {
        return $this->interestRate;
    }

    /**
     * @param float $interestRate
     */
    public function setInterestRate(float $interestRate):void
    {
        $this->implementChange($this,'interestRate', $this->interestRate, $interestRate);
    }

    /**
     * @return float|null
     */
    public function getDeferredAmount():?float
    {
        return $this->deferredAmount;
    }

    /**
     * @param float $deferredAmount
     */
    public function setDeferredAmount(float $deferredAmount):void
    {
        $this->implementChange($this,'deferredAmount', $this->deferredAmount, $deferredAmount);
    }

    /**
     * @return float|null
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
     * @return float|null
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
     * @return float|null
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
    

}