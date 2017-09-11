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
 * @ChangeTrackingPolicy("NOTIFY")
 */
class FeeUpdate extends AbstractTypeUpdate
{

    /**
     * @ORM\Id @ORM\Column(type="integer")
     * @ORM\GeneratedValue **/
    protected $id;
    
    /**
     * @var \App\Entity\Typed\Fee
     * @ORM\ManyToOne(targetEntity="\App\Entity\Typed\Fee", inversedBy="updates")
     * */
    protected $fee;

    /**
     * @var \App\Entity\Period $period
     * @ORM\ManyToOne(targetEntity="\App\Entity\Period", inversedBy="fees") **/
    protected $period;

    /**
     * @var number $amountOwed
     * @ORM\Column(type="decimal", precision=14, scale=3, nullable=true) **/
    public $amountDue;

    /**
     * @var number $amountPaid
     * @ORM\Column(type="decimal", precision=14, scale=3, nullable=true) **/
    public $amountPaid;

    /**
     * @var number $currentAmountPaid
     * @ORM\Column(type="decimal", precision=14, scale=3, nullable=true) **/
    public $currentAmountUnpaid;

    /**
     * @var number $cumulativeUnpaidAmount
     * @ORM\Column(type="decimal", precision=14, scale=3, nullable=true) **/
    public $cumulativeAmountUnpaid;

    /**
     * @var number $unpaidReimbursed
     * @ORM\Column(type="decimal", precision=14, scale=3, nullable = true) **/
    public $unpaidAmountReimbursed;
    

    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Period $period
     */
    public function getPeriod() {
        return $this->period;
    }

    /**
     * @param Period $period
     */
    public function setPeriod(Period $period) {
        $this->_onPropertyChanged('period', $this->period, $period);
        $this->period = $period;
    }

    /** @return number $amountDue */
    public function getAmountDue() {
        return $this->amountDue;
    }

    /** @return number $amountPaid */
    public function getAmountPaid() {
        return $this->amountPaid;
    }

    /** @return number $currentAmountUnpaid */
    public function getCurrentAmountUnpaid() {
        return $this->currentAmountUnpaid;
    }

    /** @return number $cumulativeAmountUnpaid */
    public function getCumulativeAmountUnpaid() {
        return $this->cumulativeAmountUnpaid;
    }

    /** @return number $unpaidAmountReimbursed */
    public function getUnpaidAmountReimbursed() {
        return $this->unpaidAmountReimbursed;
    }
    

    /** @param number $amountDue */
    public function setAmountDue($amountDue) {
        $this->_onPropertyChanged('amountDue', $this->amountDue, $amountDue);
        $this->amountDue = $amountDue;
    }

    /** @param double $amountPaid */
    public function setAmountPaid($amountPaid) {
        $this->_onPropertyChanged('amountPaid', $this->amountPaid, $amountPaid);
        $this->amountPaid = $amountPaid;
    }

    /** @param double $currentAmountUnpaid */
    public function setCurrentAmountUnpaid($currentAmountUnpaid) {
        $this->_onPropertyChanged('currentAmountUnpaid', $this->currentAmountUnpaid, $currentAmountUnpaid);
        $this->currentAmountUnpaid = $currentAmountUnpaid;
    }

    /** @param double $cumulativeAmountUnpaid */
    public function setCumulativeAmountUnpaid($cumulativeAmountUnpaid) {
        $this->_onPropertyChanged('cumulativeAmountUnpaid', $this->cumulativeAmountUnpaid, $cumulativeAmountUnpaid);
        $this->cumulativeAmountUnpaid = $cumulativeAmountUnpaid;
    }

    /** @param double $unpaidAmountReimbursed */
    public function setUnpaidReimbursed($unpaidAmountReimbursed) {
        $this->_onPropertyChanged('unpaidAmountReimbursed', $this->unpaidAmountReimbursed, $unpaidAmountReimbursed);
        $this->unpaidAmountReimbursed = $unpaidAmountReimbursed;
    }

    /**
     * @param mixed $fee
     */
    public function setFee(Fee $fee)
    {
        $this->fee = $fee;
    }


}