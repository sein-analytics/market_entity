<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 */

namespace App\Entity\Typed\Update;

use App\Entity\Typed\Fee;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Period;
use Doctrine\ORM\Mapping\ChangeTrackingPolicy;
/**
 * @ORM\Entity
 * @ORM\Table(name="FeeUpdate")
 * @ORM\ChangeTrackingPolicy("NOTIFY")
 */
class FeeUpdate extends AbstractTypeUpdate
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     **/
    protected int $id;
    
    /**
     * @var Fee
     * @ORM\ManyToOne(targetEntity="\App\Entity\Typed\Fee", inversedBy="updates")
     * */
    protected $fee;

    /**
     * @var Period $period
     * @ORM\ManyToOne(targetEntity="\App\Entity\Period", inversedBy="fees")
     **/
    protected $period;

    /**
     * @var float|null $amountOwed
     * @ORM\Column(type="float", precision=14, scale=3, nullable=true)
     **/
    public float|null $amountDue;

    /**
     * @var float|null $amountPaid
     * @ORM\Column(type="float", precision=14, scale=3, nullable=true)
     **/
    public float|null $amountPaid;

    /**
     * @var float|null $currentAmountPaid
     * @ORM\Column(type="float", precision=14, scale=3, nullable=true)
     **/
    public float|null $currentAmountUnpaid;

    /**
     * @var float|null $cumulativeUnpaidAmount
     * @ORM\Column(type="float", precision=14, scale=3, nullable=true)
     **/
    public float|null $cumulativeAmountUnpaid;

    /**
     * @var float|null $unpaidReimbursed
     * @ORM\Column(type="float", precision=14, scale=3, nullable = true)
     **/
    public float|null $unpaidAmountReimbursed;
    

    public function getId():int
    {
        return $this->id;
    }

    /**
     * @return Period $period
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

    /** @return float|null $amountDue */
    public function getAmountDue():float|null {
        return $this->amountDue;
    }

    /** @return float|null $amountPaid */
    public function getAmountPaid():float|null {
        return $this->amountPaid;
    }

    /** @return float|null $currentAmountUnpaid */
    public function getCurrentAmountUnpaid():float|null {
        return $this->currentAmountUnpaid;
    }

    /** @return float|null $cumulativeAmountUnpaid */
    public function getCumulativeAmountUnpaid():float|null {
        return $this->cumulativeAmountUnpaid;
    }

    /** @return float|null $unpaidAmountReimbursed */
    public function getUnpaidAmountReimbursed():float|null {
        return $this->unpaidAmountReimbursed;
    }
    

    /** @param float $amountDue */
    public function setAmountDue(float $amountDue):void {
        $this->implementChange($this,'amountDue', $this->amountDue, $amountDue);
    }

    /** @param float $amountPaid */
    public function setAmountPaid(float $amountPaid):void {
        $this->implementChange($this,'amountPaid', $this->amountPaid, $amountPaid);
    }

    /** @param float $currentAmountUnpaid */
    public function setCurrentAmountUnpaid(float $currentAmountUnpaid):void {
        $this->implementChange($this,'currentAmountUnpaid', $this->currentAmountUnpaid, $currentAmountUnpaid);
    }

    /** @param float $cumulativeAmountUnpaid */
    public function setCumulativeAmountUnpaid(float $cumulativeAmountUnpaid):void {
        $this->implementChange($this,'cumulativeAmountUnpaid', $this->cumulativeAmountUnpaid, $cumulativeAmountUnpaid);
    }

    /** @param float $unpaidAmountReimbursed */
    public function setUnpaidReimbursed(float $unpaidAmountReimbursed):void {
        $this->implementChange($this,'unpaidAmountReimbursed', $this->unpaidAmountReimbursed, $unpaidAmountReimbursed);
    }

    /**
     * @param mixed $fee
     */
    public function setFee(Fee $fee)
    {
        $this->fee = $fee;
    }
}