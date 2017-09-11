<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 * Date: 6/28/16
 * Time: 7:21 AM
 */

namespace App\Entity;

use Doctrine\Common\NotifyPropertyChanged;
use Doctrine\ORM\Mapping\ChangeTrackingPolicy;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="Statistic")
 * @ChangeTrackingPolicy("NOTIFY")
 */
class Statistic implements NotifyPropertyChanged
{
    use NotifyChangeTrait;

    /**
     * @ORM\Id @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     **/
    protected $id;

    /** @ORM\OneToOne(targetEntity="\App\Entity\Deal", inversedBy="stats")
     * @var \App\Entity\Deal
     **/
    protected $deal;

    /** @ORM\Column(type="decimal", precision=14, scale=2)
     * @var number
     **/
    protected $upb;

    /** @ORM\Column(type="json_array", nullable=true)
     * @var string
     **/
    protected $states;

    /** @ORM\Column(type="string", nullable=true)
     * @var string
     **/
    protected $summaryStates;

    /** @ORM\Column(type="string", nullable=true)
     * @var string
     **/
    protected $ltv;

    /** @ORM\Column(type="decimal", precision=5, scale=2, nullable=true)
     * @var number
     **/
    protected $summaryLtv;

    /** @ORM\Column(type="string", nullable=true)
     * @var string
     **/
    protected $balance;

    /** @ORM\Column(type="string", nullable=true)
     * @var string
     **/
    protected $summaryBalance;

    /** @ORM\Column(type="string", nullable=true)
     * @var string
     **/
    protected $rate;

    /** @ORM\Column(type="decimal", precision=5, scale=3, nullable=true)
     * @var number
     **/
    protected $summaryRate;

    /** @ORM\Column(type="string", nullable=true) **/
    protected $loanType;

    /** @ORM\Column(type="string", nullable=true)
     * @var string
     **/
    protected $propertyType;

    /** @ORM\Column(type="string", nullable=true)
     * @var string
     **/
    protected $occupancy;

    /** @ORM\Column(type="string", nullable=true)
     * @var string
     **/
    protected $maturity;

    /** @ORM\Column(type="decimal", precision=4, scale=0, nullable=true)
     * @var number
     **/
    protected $summaryMaturity;

    /** @ORM\Column(type="string", nullable=true)
     * @var string
     **/
    protected $credit;

    /** @ORM\Column(type="decimal", precision=4, scale=0, nullable=true)
     * @var number
     **/
    protected $summaryCredit;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Deal
     */
    public function getDeal()
    {
        return $this->deal;
    }

    /**
     * @param Deal $deal
     */
    public function setDeal(Deal $deal)
    {
        $this->_onPropertyChanged('deal', $this->deal, $deal);
        $this->deal = $deal;
    }

    /**
     * @return mixed
     */
    public function getUpb()
    {
        return $this->upb;
    }

    /**
     * @param mixed $upb
     */
    public function setUpb($upb)
    {
        $this->_onPropertyChanged('upb', $this->upb, $upb);
        $this->upb = $upb;
    }

    /**
     * @return mixed
     */
    public function getStates()
    {
        return $this->states;
    }

    /**
     * @param mixed $states
     */
    public function setStates($states)
    {
        $this->_onPropertyChanged('states', $this->states, $states);
        $this->states = $states;
    }

    /**
     * @return string
     */
    public function getSummaryStates()
    {
        return $this->summaryStates;
    }

    /**
     * @param string $summaryStates
     */
    public function setSummaryStates(string $summaryStates)
    {
        $this->_onPropertyChanged('summaryStates', $this->summaryStates, $summaryStates);
        $this->summaryStates = $summaryStates;
    }

    /**
     * @return string
     */
    public function getLtv(): string
    {
        return $this->ltv;
    }

    /**
     * @param string $ltv
     */
    public function setLtv(string $ltv)
    {
        $this->_onPropertyChanged('ltv', $this->ltv, $ltv);
        $this->ltv = $ltv;
    }

    /**
     * @return number
     */
    public function getSummaryLtv()
    {
        return $this->summaryLtv;
    }

    /**
     * @param number $summaryLtv
     */
    public function setSummaryLtv(number $summaryLtv)
    {
        $this->_onPropertyChanged('summaryLtv', $this->summaryLtv, $summaryLtv);
        $this->summaryLtv = $summaryLtv;
    }

    /**
     * @return string
     */
    public function getBalance()
    {
        return $this->balance;
    }

    /**
     * @param string $balance
     */
    public function setBalance(string $balance)
    {
        $this->_onPropertyChanged('balance', $this->balance, $balance);
        $this->balance = $balance;
    }

    /**
     * @return string
     */
    public function getSummaryBalance()
    {
        return $this->summaryBalance;
    }

    /**
     * @param string $summaryBalance
     */
    public function setSummaryBalance(string $summaryBalance)
    {
        $this->_onPropertyChanged('summaryBalance', $this->summaryBalance, $summaryBalance);
        $this->summaryBalance = $summaryBalance;
    }

    /**
     * @return string
     */
    public function getRate(): string
    {
        return $this->rate;
    }

    /**
     * @param string $rate
     */
    public function setRate(string $rate)
    {
        $this->_onPropertyChanged('rate', $this->rate, $rate);
        $this->rate = $rate;
    }

    /**
     * @return number
     */
    public function getSummaryRate(): number
    {
        return $this->summaryRate;
    }

    /**
     * @param number $summaryRate
     */
    public function setSummaryRate(number $summaryRate)
    {
        $this->_onPropertyChanged('summaryRate', $this->summaryRate, $summaryRate);
        $this->summaryRate = $summaryRate;
    }

    /**
     * @return mixed
     */
    public function getLoanType()
    {
        return $this->loanType;
    }

    /**
     * @param mixed $loanType
     */
    public function setLoanType($loanType)
    {
        $this->_onPropertyChanged('loanType', $this->loanType, $loanType);
        $this->loanType = $loanType;
    }

    /**
     * @return string
     */
    public function getPropertyType()
    {
        return $this->propertyType;
    }

    /**
     * @param string $propertyType
     */
    public function setPropertyType(string $propertyType)
    {
        $this->_onPropertyChanged('propertyType', $this->propertyType, $propertyType);
        $this->propertyType = $propertyType;
    }

    /**
     * @return string
     */
    public function getOccupancy()
    {
        return $this->occupancy;
    }

    /**
     * @param string $occupancy
     */
    public function setOccupancy(string $occupancy)
    {
        $this->_onPropertyChanged('occupancy', $this->occupancy, $occupancy);
        $this->occupancy = $occupancy;
    }

    /**
     * @return string
     */
    public function getMaturity()
    {
        return $this->maturity;
    }

    /**
     * @param string $maturity
     */
    public function setMaturity(string $maturity)
    {
        $this->_onPropertyChanged('maturity', $this->maturity, $maturity);
        $this->maturity = $maturity;
    }

    /**
     * @return number
     */
    public function getSummaryMaturity()
    {
        return $this->summaryMaturity;
    }

    /**
     * @param number $summaryMaturity
     */
    public function setSummaryMaturity(number $summaryMaturity)
    {
        $this->_onPropertyChanged('summaryMaturity', $this->summaryMaturity, $summaryMaturity);
        $this->summaryMaturity = $summaryMaturity;
    }

    /**
     * @return string
     */
    public function getCredit()
    {
        return $this->credit;
    }

    /**
     * @param string $credit
     */
    public function setCredit(string $credit)
    {
        $this->_onPropertyChanged('credit', $this->credit, $credit);
        $this->credit = $credit;
    }

    /**
     * @return number
     */
    public function getSummaryCredit()
    {
        return $this->summaryCredit;
    }

    /**
     * @param number $summaryCredit
     */
    public function setSummaryCredit(number $summaryCredit)
    {
        $this->_onPropertyChanged('summaryCredit', $this->summaryCredit, $summaryCredit);
        $this->summaryCredit = $summaryCredit;
    }


}