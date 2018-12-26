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
 * @ORM\Entity(repositoryClass="\App\Repository\Statistic")
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

    /**
     * @ORM\OneToOne(targetEntity="\App\Entity\Deal", inversedBy="stats")
     * @ORM\JoinColumn(name="deal_id", referencedColumnName="id", nullable=false)
     * @var \App\Entity\Deal
     **/
    protected $deal;

    /** @ORM\Column(type="json", nullable=true)
     * @var array
     **/
    protected $states;

    /** @ORM\Column(type="json", nullable=true)
     * @var array
     **/
    protected $summaryStates;

    /** @ORM\Column(type="json", nullable=true)
     * @var array
     **/
    protected $ltv;

    /** @ORM\Column(type="json", nullable=true)
     * @var array
     **/
    protected $summaryLtv;

    /** @ORM\Column(type="json", nullable=true)
     * @var array
     **/
    protected $balance;

    /** @ORM\Column(type="json", nullable=true)
     * @var array
     **/
    protected $summaryBalance;

    /** @ORM\Column(type="json", nullable=true)
     * @var array
     **/
    protected $rate;

    /** @ORM\Column(type="json", nullable=true)
     * @var array
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

    /** @ORM\Column(type="json", nullable=true)
     * @var array
     **/
    protected $summaryMaturity;

    /** @ORM\Column(type="json", nullable=true)
     * @var array
     **/
    protected $credit;

    /** @ORM\Column(type="json", nullable=true)
     * @var array
     **/
    protected $summaryCredit;

    /**
     * @ORM\Column(type="json", nullable=true)
     * @var array
     */
    protected $filterData;

    /**
     * @return mixed
     */
    public function getId() { return $this->id; }

    /**
     * @return Deal
     */
    public function getDeal() { return $this->deal; }

    /**
     * @param Deal $deal
     */
    public function setDeal(Deal $deal)
    {
        $this->_onPropertyChanged('deal', $this->deal, $deal);
        $this->deal = $deal;
    }

    /**
     * @return array
     */
    public function getStates() { return $this->states; }

    /**
     * @param array $states
     */
    public function setStates(array $states)
    {
        $json_string = json_encode($states);
        $this->_onPropertyChanged('states', $this->states, $json_string);
        $this->states = $json_string;
    }

    /**
     * @return array
     */
    public function getSummaryStates() { return $this->summaryStates; }

    /**
     * @param array $summaryStates
     */
    public function setSummaryStates(array $summaryStates)
    {
        $json_string = json_encode($summaryStates);
        $this->_onPropertyChanged('summaryStates', $this->summaryStates, $json_string);
        $this->summaryStates = $json_string;
    }

    /**
     * @return array
     */
    public function getLtv() { return $this->ltv; }

    /**
     * @param string $ltv
     */
    public function setLtv(string $ltv)
    {
        $this->_onPropertyChanged('ltv', $this->ltv, $ltv);
        $this->ltv = $ltv;
    }

    /**
     * @return array
     */
    public function getSummaryLtv() { return $this->summaryLtv; }

    /**
     * @param array $summaryLtv
     */
    public function setSummaryLtv(array $summaryLtv)
    {
        $json_string = json_encode($summaryLtv);
        $this->_onPropertyChanged('summaryLtv', $this->summaryLtv, $json_string);
        $this->summaryLtv = $json_string;
    }

    /**
     * @return array
     */
    public function getBalance() { return $this->balance; }

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
     * @return array
     */
    public function getSummaryBalance() { return $this->summaryBalance; }

    /**
     * @param array $summaryBalance
     */
    public function setSummaryBalance(array $summaryBalance)
    {
        $json_string = json_encode($summaryBalance);
        $this->_onPropertyChanged('summaryBalance', $this->summaryBalance, $json_string);
        $this->summaryBalance = $json_string;
    }

    /**
     * @return array
     */
    public function getRate() { return $this->rate; }

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
     * @return array
     */
    public function getSummaryRate() { return $this->summaryRate; }

    /**
     * @param array $summaryRate
     */
    public function setSummaryRate(array $summaryRate)
    {
        $json_string = json_encode($summaryRate);
        $this->_onPropertyChanged('summaryRate', $this->summaryRate, $json_string);
        $this->summaryRate = $json_string;
    }

    /**
     * @return array
     */
    public function getLoanType() { return $this->loanType; }

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
    public function getPropertyType() { return $this->propertyType; }

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
    public function getOccupancy() { return $this->occupancy; }

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
    public function getMaturity() { return $this->maturity; }

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
     * @return array
     */
    public function getSummaryMaturity() { return $this->summaryMaturity; }

    /**
     * @param array $summaryMaturity
     */
    public function setSummaryMaturity(array $summaryMaturity)
    {
        $json_string = json_encode($summaryMaturity);
        $this->_onPropertyChanged('summaryMaturity', $this->summaryMaturity, $json_string);
        $this->summaryMaturity = $json_string;
    }

    /**
     * @return array
     */
    public function getCredit() { return $this->credit; }

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
     * @return array
     */
    public function getSummaryCredit() { return $this->summaryCredit; }

    /**
     * @param array $summaryCredit
     */
    public function setSummaryCredit(array $summaryCredit)
    {
        $json_string = json_encode($summaryCredit);
        $this->_onPropertyChanged('summaryCredit', $this->summaryCredit, $json_string);
        $this->summaryCredit = $json_string;
    }

    /**
     * @return array
     */
    public function getFilterData() { return $this->filterData; }

    /**
     * @param array $filterData
     */
    public function setFilterData(array $filterData)
    {
        $json_string = json_encode($filterData);
        $this->_onPropertyChanged('filterData', $this->filterData, $json_string);
        $this->filterData = $json_string;
    }


}