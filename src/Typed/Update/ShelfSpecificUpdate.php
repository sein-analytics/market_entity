<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 * Date: 6/15/16
 * Time: 2:04 PM
 */

namespace App\Entity\Typed\Update;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\Period;
use App\Entity\Typed\ShelfSpecific;
use Doctrine\ORM\Mapping\ChangeTrackingPolicy;
/**
 *
 * @ORM\Entity
 * @ORM\Table(name="ShelfSpecificUpdate")
 * @ChangeTrackingPolicy("NOTIFY")
 */
class ShelfSpecificUpdate extends AbstractTypeUpdate
{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @var \App\Entity\Typed\ShelfSpecific $shelfSpecific
     * @ORM\ManyToOne(targetEntity="\App\Entity\Typed\ShelfSpecific", inversedBy="updates") **/
    protected $shelfSpecific;

    /**
     * @var \App\Entity\Period $period
     * @ORM\ManyToOne(targetEntity="\App\Entity\Period", inversedBy="shelfSpecifics") **/
    protected $period;

    /**
     * @var double $amountDue
     * @ORM\Column(type = "decimal", precision=14, scale=2) **/
    public $amountDue = 0;

    /**
     * @var double $amountPaid
     * @ORM\Column(type = "decimal", precision=14, scale=2) **/
    public $amountPaid = 0;

    /**
     * @var double $currentAmountUnpaid
     * @ORM\Column(type = "decimal", precision=14, scale=2) **/
    public $currentAmountUnpaid = 0;

    /**
     * @var double $cumulativeAmountUnpaid
     * @ORM\Column(type = "decimal", precision=14, scale=2) **/
    public $cumulativeAmountUnpaid = 0;

    /**
     * @var double $cumulativeAmountUnpaid
     * @ORM\Column(type = "decimal", precision=14, scale=2) **/
    public $beginningBalance = 0;

    /**
     * @var double $cumulativeAmountUnpaid
     * @ORM\Column(type = "decimal", precision=14, scale=2) **/
    public $endingBalance = 0;

    /**
     * @var double $interestRate
     * @ORM\Column(type = "decimal", precision=14, scale=2, nullable=true) **/
    public $interestRate;

    /**
     * @var double $interestRate
     * @ORM\Column(type = "decimal", precision=14, scale=2, nullable=true) **/
    public $deferredAmount;

    /**
     * @var double $calculatedInterest
     * @ORM\Column(type = "decimal", precision=14, scale=2, nullable=true) **/
    public $calculatedInterest;

    /**
     * @var double $interestPaid
     * @ORM\Column(type = "decimal", precision=14, scale=2, nullable=true) **/
    public $interestPaid;

    /**
     * @var double $unpaidInterest
     * @ORM\Column(type = "decimal", precision=14, scale=2, nullable=true) **/
    public $unpaidInterest;

    public function getId()
    {
        return $this->id;
    }

    /**
     * @return \App\Entity\Typed\ShelfSpecific
     */
    public function getShelfSpecific()
    {
        return $this->shelfSpecific;
    }

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

    /**
     * @param \App\Entity\Typed\ShelfSpecific $shelfSpecific
     */
    public function setShelfSpecific(ShelfSpecific $shelfSpecific)
    {
        $this->_onPropertyChanged('shelfSpecific', $this->shelfSpecific, $shelfSpecific);
        $this->shelfSpecific = $shelfSpecific;
    }

    /**
     * @return float
     */
    public function getAmountDue()
    {
        return $this->amountDue;
    }

    /**
     * @param float $amountDue
     */
    public function setAmountDue($amountDue)
    {
        $this->_onPropertyChanged('amountDue', $this->amountDue, $amountDue);
        $this->amountDue = $amountDue;
    }

    /**
     * @return float
     */
    public function getAmountPaid()
    {
        return $this->amountPaid;
    }

    /**
     * @param float $amountPaid
     */
    public function setAmountPaid($amountPaid)
    {
        $this->_onPropertyChanged('amountPaid', $this->amountPaid, $amountPaid);
        $this->amountPaid = $amountPaid;
    }

    /**
     * @return float
     */
    public function getCurrentAmountUnpaid()
    {
        return $this->currentAmountUnpaid;
    }

    /**
     * @param float $currentAmountUnpaid
     */
    public function setCurrentAmountUnpaid($currentAmountUnpaid)
    {
        $this->_onPropertyChanged('currentAmountUnpaid', $this->currentAmountUnpaid, $currentAmountUnpaid);
        $this->currentAmountUnpaid = $currentAmountUnpaid;
    }

    /**
     * @return float
     */
    public function getCumulativeAmountUnpaid()
    {
        return $this->cumulativeAmountUnpaid;
    }

    /**
     * @param float $cumulativeAmountUnpaid
     */
    public function setCumulativeAmountUnpaid($cumulativeAmountUnpaid)
    {
        $this->_onPropertyChanged('cumulativeAmountUnpaid', $this->cumulativeAmountUnpaid, $cumulativeAmountUnpaid);
        $this->cumulativeAmountUnpaid = $cumulativeAmountUnpaid;
    }

    /**
     * @return float
     */
    public function getBeginningBalance()
    {
        return $this->beginningBalance;
    }

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
    public function getEndingBalance()
    {
        return $this->endingBalance;
    }

    /**
     * @param float $endingBalance
     */
    public function setEndingBalance($endingBalance)
    {
        $this->_onPropertyChanged('endingBalance', $this->endingBalance, $endingBalance);
        $this->endingBalance = $endingBalance;
    }

    /**
     * @return float
     */
    public function getInterestRate()
    {
        return $this->interestRate;
    }

    /**
     * @param float $interestRate
     */
    public function setInterestRate($interestRate)
    {
        $this->_onPropertyChanged('interestRate', $this->interestRate, $interestRate);
        $this->interestRate = $interestRate;
    }

    /**
     * @return float
     */
    public function getDeferredAmount()
    {
        return $this->deferredAmount;
    }

    /**
     * @param float $deferredAmount
     */
    public function setDeferredAmount($deferredAmount)
    {
        $this->_onPropertyChanged('deferredAmount', $this->deferredAmount, $deferredAmount);
        $this->deferredAmount = $deferredAmount;
    }

    /**
     * @return float
     */
    public function getCalculatedInterest()
    {
        return $this->calculatedInterest;
    }

    /**
     * @param float $calculatedInterest
     */
    public function setCalculatedInterest($calculatedInterest)
    {
        $this->_onPropertyChanged('calculatedInterest', $this->calculatedInterest, $calculatedInterest);
        $this->calculatedInterest = $calculatedInterest;
    }

    /**
     * @return float
     */
    public function getInterestPaid()
    {
        return $this->interestPaid;
    }

    /**
     * @param float $interestPaid
     */
    public function setInterestPaid($interestPaid)
    {
        $this->_onPropertyChanged('interestPaid', $this->interestPaid, $interestPaid);
        $this->interestPaid = $interestPaid;
    }

    /**
     * @return float
     */
    public function getUnpaidInterest()
    {
        return $this->unpaidInterest;
    }

    /**
     * @param float $unpaidInterest
     */
    public function setUnpaidInterest($unpaidInterest)
    {
        $this->_onPropertyChanged('unpaidInterest', $this->unpaidInterest, $unpaidInterest);
        $this->unpaidInterest = $unpaidInterest;
    }
    

}