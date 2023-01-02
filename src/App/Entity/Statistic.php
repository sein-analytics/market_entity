<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 * Date: 6/28/16
 * Time: 7:21 AM
 */

namespace App\Entity;

use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\OneToOne;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\ManyToMany;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\JoinColumns;
use Doctrine\ORM\Mapping\JoinTable;
use Doctrine\ORM\Mapping\GeneratedValue;

use Doctrine\ORM\Mapping\DiscriminatorColumn;
use Doctrine\ORM\Mapping\DiscriminatorMap;

use Doctrine\ORM\Mapping\Index;
use Doctrine\ORM\Mapping\ChangeTrackingPolicy;

use Doctrine\ORM\Mapping as ORM;

/**
 * \Doctrine\ORM\Mapping\Entity(repositoryClass="\App\Repository\Statistic")
 * \Doctrine\ORM\Mapping\Table(name="Statistic")
 * \Doctrine\ORM\Mapping\ChangeTrackingPolicy("NOTIFY")
 */
class Statistic extends DomainObject
{

    /**
     * \Doctrine\ORM\Mapping\Id
     * \Doctrine\ORM\Mapping\Column(type="integer")
     * \Doctrine\ORM\Mapping\GeneratedValue
     **/
    protected int $id;

    /**
     * \Doctrine\ORM\Mapping\OneToOne(targetEntity="\App\Entity\Deal", inversedBy="stats")
     * \Doctrine\ORM\Mapping\JoinColumn(name="deal_id", referencedColumnName="id", nullable=false)
     * @var Deal
     **/
    protected $deal;

    /**
     * \Doctrine\ORM\Mapping\Column(type="json", nullable=true)
     * @var array|string|null
     **/
    protected array|string|null $states;

    /**
     * \Doctrine\ORM\Mapping\Column(type="json", nullable=true)
     * @var array|string|null
     **/
    protected array|string|null $summaryStates;

    /**
     * \Doctrine\ORM\Mapping\Column(type="json", nullable=true)
     * @var  array|string|null
     **/
    protected array|string|null $ltv;

    /**
     * \Doctrine\ORM\Mapping\Column(type="json", nullable=true)
     * @var  array|string|null
     **/
    protected array|string|null $summaryLtv;

    /**
     * \Doctrine\ORM\Mapping\Column(type="json", nullable=true)
     * @var  array|string|null
     **/
    protected array|string|null $balance;

    /**
     * \Doctrine\ORM\Mapping\Column(type="json", nullable=true)
     * @var array|string|null
     **/
    protected array|string|null $summaryBalance;

    /**
     * \Doctrine\ORM\Mapping\Column(type="json", nullable=true)
     * @var array|string|null
     **/
    protected array|string|null $rate;

    /**
     * \Doctrine\ORM\Mapping\Column(type="json", nullable=true)
     * @var array|string|null
     **/
    protected array|string|null $summaryRate;

    /**
     * \Doctrine\ORM\Mapping\Column(type="json", nullable=true)
     * @var array|string|null
     **/
    protected array|string|null $loanType;

    /**
     * \Doctrine\ORM\Mapping\Column(type="json", nullable=true)
     * @var array|string|null
     **/
    protected array|string|null $propertyType;

    /**
     * \Doctrine\ORM\Mapping\Column(type="json", nullable=true)
     * @var array|string|null
     **/
    protected array|string|null $occupancy;

    /**
     * \Doctrine\ORM\Mapping\Column(type="json", nullable=true)
     * @var array|string|null
     **/
    protected array|string|null $maturity;

    /**
     * \Doctrine\ORM\Mapping\Column(type="json", nullable=true)
     * @var array|string|null
     **/
    protected array|string|null $summaryMaturity;

    /**
     * \Doctrine\ORM\Mapping\Column(type="json", nullable=true)
     * @var array|string|null
     **/
    protected array|string|null $credit;

    /**
     * \Doctrine\ORM\Mapping\Column(type="json", nullable=true)
     * @var array|string|null
     **/
    protected array|string|null $summaryCredit;

    /**
     * \Doctrine\ORM\Mapping\Column(type="json", nullable=true)
     * @var array|string|null
     */
    protected array|string|null $filterData;

    /**
     * @return int
     */
    public function getId():int { return $this->id; }

    /**
     * @return Deal
     */
    public function getDeal():Deal { return $this->deal; }

    /**
     * @param Deal $deal
     */
    public function setDeal(Deal $deal):void
    {
        $this->implementChange($this,'deal', $this->deal, $deal);
    }

    protected function arrayToString(array|string $newValue):string
    {
        if (is_array($newValue))
            return json_encode($newValue);
        return $newValue;
    }

    /**
     * @return array|string|null
     */
    public function getStates():array|string|null
    { return $this->states; }

    /**
     * @param array|string $states
     */
    public function setStates(array|string $states):void
    {
        $this->implementChange($this,'states', $this->states,
            $this->arrayToString($states));
    }

    /**
     * @return array|string|null
     */
    public function getSummaryStates():array|string|null { return $this->summaryStates; }

    /**
     * @param array|string $summaryStates
     */
    public function setSummaryStates(array|string $summaryStates):void
    {
        $this->implementChange($this,'summaryStates', $this->summaryStates,
            $this->arrayToString($summaryStates));
    }

    /**
     * @return array|string|null
     */
    public function getLtv():array|string|null { return $this->ltv; }

    /**
     * @param array|string $ltv
     */
    public function setLtv(array|string $ltv):void
    {
        $this->implementChange($this,'ltv', $this->ltv,
            $this->arrayToString($ltv));
    }

    /**
     * @return array|string|null
     */
    public function getSummaryLtv():array|string|null
    { return $this->summaryLtv; }

    /**
     * @param array|string $summaryLtv
     */
    public function setSummaryLtv(array|string $summaryLtv):void
    {
        $this->implementChange($this,'summaryLtv', $this->summaryLtv,
            $this->arrayToString($summaryLtv));
    }

    /**
     * @return array|string|null
     */
    public function getBalance():array|string|null
    { return $this->balance; }

    /**
     * @param array|string $balance
     */
    public function setBalance(array|string $balance):void
    {
        $this->implementChange($this,'balance', $this->balance,
            $this->arrayToString($balance));
    }

    /**
     * @return array|string|null
     */
    public function getSummaryBalance():array|string|null
    { return $this->summaryBalance; }

    /**
     * @param array|string $summaryBalance
     */
    public function setSummaryBalance(array|string $summaryBalance):void
    {
        $this->implementChange($this,'summaryBalance', $this->summaryBalance,
            $this->arrayToString($summaryBalance));
    }

    /**
     * @return array|string|null
     */
    public function getRate():array|string|null { return $this->rate; }

    /**
     * @param array|string $rate
     */
    public function setRate(array|string $rate):void
    {
        $this->implementChange($this,'rate', $this->rate,
            $this->arrayToString($rate));
    }

    /**
     * @return array|string|null
     */
    public function getSummaryRate():array|string|null { return $this->summaryRate; }

    /**
     * @param array|string $summaryRate
     */
    public function setSummaryRate(array|string $summaryRate):void
    {
        $this->implementChange($this,'summaryRate', $this->summaryRate,
            $this->arrayToString($summaryRate));
    }

    /**
     * @return array|string|null
     */
    public function getLoanType():array|string|null
    { return $this->loanType; }

    /**
     * @param array|string $loanType
     */
    public function setLoanType(array|string $loanType):void
    {
        $this->implementChange($this,'loanType', $this->loanType,
            $this->arrayToString($loanType));
    }

    /**
     * @return array|string|null
     */
    public function getPropertyType():array|string|null
    { return $this->propertyType; }

    /**
     * @param array|string $propertyType
     */
    public function setPropertyType(array|string $propertyType):void
    {
        $this->implementChange($this,'propertyType', $this->propertyType,
            $this->arrayToString($propertyType));
    }

    /**
     * @return array|string|null
     */
    public function getOccupancy():array|string|null { return $this->occupancy; }

    /**
     * @param array|string $occupancy
     */
    public function setOccupancy(array|string $occupancy):void
    {
        $this->implementChange($this,'occupancy', $this->occupancy,
            $this.$this->arrayToString($occupancy));
    }

    /**
     * @return array|string|null
     */
    public function getMaturity():array|string|null { return $this->maturity; }

    /**
     * @param array|string $maturity
     */
    public function setMaturity(array|string $maturity):void
    {
        $this->implementChange($this,'maturity', $this->maturity,
            $this->arrayToString($maturity));
    }

    /**
     * @return array|string|null
     */
    public function getSummaryMaturity():array|string|null { return $this->summaryMaturity; }

    /**
     * @param array|string $summaryMaturity
     */
    public function setSummaryMaturity(array|string $summaryMaturity):void
    {
        $this->implementChange($this,'summaryMaturity', $this->summaryMaturity,
            $this->arrayToString($summaryMaturity));
    }

    /**
     * @return array|string|null
     */
    public function getCredit():array|string|null { return $this->credit; }

    /**
     * @param array|string $credit
     */
    public function setCredit(array|string $credit):void
    {
        $this->implementChange($this,'credit', $this->credit,
            $this->arrayToString($credit));
    }

    /**
     * @return array|string|null
     */
    public function getSummaryCredit():array|string|null { return $this->summaryCredit; }

    /**
     * @param array|string $summaryCredit
     */
    public function setSummaryCredit(array|string $summaryCredit):void
    {
        $json_string = json_encode($summaryCredit);
        $this->implementChange($this, 'summaryCredit', $this->summaryCredit,
            $this->arrayToString($summaryCredit));
    }

    /**
     * @return array|string|null
     */
    public function getFilterData():array|string|null { return $this->filterData; }

    /**
     * @param array|string $filterData
     */
    public function setFilterData(array|string $filterData):void
    {
        $this->implementChange($this, 'filterData', $this->filterData,
            $this->arrayToString($filterData));
    }


}