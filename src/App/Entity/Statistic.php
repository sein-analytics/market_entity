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

    /** @ORM\Column(type="json", nullable=true)
     * @var array
     **/
    protected $states;

    /** @ORM\Column(type="string", nullable=true)
     * @var string
     **/
    protected $summaryStates;

    /** @ORM\Column(type="json", nullable=true)
     * @var array
     **/
    protected $ltv;

    /** @ORM\Column(type="decimal", precision=5, scale=2, nullable=true)
     * @var number
     **/
    protected $summaryLtv;

    /** @ORM\Column(type="json", nullable=true)
     * @var array
     **/
    protected $balance;

    /** @ORM\Column(type="decimal", precision=14, scale=2, nullable=true)
     * @var string
     **/
    protected $summaryBalance;

    /** @ORM\Column(type="json", nullable=true)
     * @var array
     **/
    protected $rate;

    /** @ORM\Column(type="decimal", precision=5, scale=3, nullable=true)
     * @var string
     **/
    protected $summaryRate;

    /** @ORM\Column(type="json", nullable=true)
     * @var array
     **/
    protected $loanType;

    /** @ORM\Column(type="json", nullable=true)
     * @var array
     **/
    protected $propertyType;

    /** @ORM\Column(type="json", nullable=true)
     * @var array
     **/
    protected $occupancy;

    /** @ORM\Column(type="json", nullable=true)
     * @var array
     **/
    protected $maturity;

    /** @ORM\Column(type="decimal", precision=4, scale=0, nullable=true)
     * @var string
     **/
    protected $summaryMaturity;

    /** @ORM\Column(type="json", nullable=true)
     * @var array
     **/
    protected $credit;

    /** @ORM\Column(type="decimal", precision=4, scale=0, nullable=true)
     * @var string
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
     * @return array
     */
    public function getLtv()
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
     * @return array
     */
    public function getBalance()
    {
        return $this->balance;
    }

    /**
     * @param array $balance
     */
    public function setBalance(array $balance)
    {
        $string = json_encode($balance);
        $this->_onPropertyChanged('balance', $this->balance, $string);
        $this->balance = $string;
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
     * @return array
     */
    public function getRate()
    {
        return $this->rate;
    }

    /**
     * @param array $rate
     */
    public function setRate(array $rate)
    {
        $string = json_encode($rate);
        $this->_onPropertyChanged('rate', $this->rate, $string);
        $this->rate = $string;
    }

    /**
     * @return string
     */
    public function getSummaryRate()
    {
        return $this->summaryRate;
    }

    /**
     * @param string $summaryRate
     */
    public function setSummaryRate(string $summaryRate)
    {
        $this->_onPropertyChanged('summaryRate', $this->summaryRate, $summaryRate);
        $this->summaryRate = $summaryRate;
    }

    /**
     * @return array
     */
    public function getLoanType()
    {
        return $this->loanType;
    }

    /**
     * @param array $loanType
     */
    public function setLoanType(array $loanType)
    {
        $string = json_encode($loanType);
        $this->_onPropertyChanged('loanType', $this->loanType, $string);
        $this->loanType = $string;
    }

    /**
     * @return array
     */
    public function getPropertyType()
    {
        return $this->propertyType;
    }

    /**
     * @param array $propertyType
     */
    public function setPropertyType(array $propertyType)
    {
        $json_string = json_encode($propertyType);
        $this->_onPropertyChanged('propertyType', $this->propertyType, $json_string);
        $this->propertyType = $json_string;
    }

    /**
     * @return array
     */
    public function getOccupancy()
    {
        return $this->occupancy;
    }

    /**
     * @param array $occupancy
     */
    public function setOccupancy(array $occupancy)
    {
        $json_string = json_encode($occupancy);
        $this->_onPropertyChanged('occupancy', $this->occupancy, $json_string);
        $this->occupancy = $json_string;
    }

    /**
     * @return array
     */
    public function getMaturity()
    {
        return $this->maturity;
    }

    /**
     * @param array $maturity
     */
    public function setMaturity(array $maturity)
    {
        $json_string = json_encode($maturity);
        $this->_onPropertyChanged('maturity', $this->maturity, $json_string);
        $this->maturity = $json_string;
    }

    /**
     * @return string
     */
    public function getSummaryMaturity()
    {
        return $this->summaryMaturity;
    }

    /**
     * @param string $summaryMaturity
     */
    public function setSummaryMaturity(string $summaryMaturity)
    {
        $this->_onPropertyChanged('summaryMaturity', $this->summaryMaturity, $summaryMaturity);
        $this->summaryMaturity = $summaryMaturity;
    }

    /**
     * @return array
     */
    public function getCredit()
    {
        return $this->credit;
    }

    /**
     * @param array $credit
     */
    public function setCredit(array $credit)
    {
        $json_string = json_encode($credit);
        $this->_onPropertyChanged('credit', $this->credit, $json_string);
        $this->credit = $json_string;
    }

    /**
     * @return string
     */
    public function getSummaryCredit()
    {
        return $this->summaryCredit;
    }

    /**
     * @param string $summaryCredit
     */
    public function setSummaryCredit(string $summaryCredit)
    {
        $this->_onPropertyChanged('summaryCredit', $this->summaryCredit, $summaryCredit);
        $this->summaryCredit = $summaryCredit;
    }


}