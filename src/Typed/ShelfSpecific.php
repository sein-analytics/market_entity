<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 * Date: 6/22/16
 * Time: 5:02 PM
 */

namespace App\Entity\Typed;


use Doctrine\ORM\Mapping as ORM;
use App\Entity\Deal;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping\MappedSuperclass;
use App\Entity\Typed\Update\ShelfSpecificUpdate;
use App\Entity\Typed\Update\TypedUpdateInterface;

/**
 *
 * @MappedSuperclass
 * @ORM\Entity
 * @ORM\Table(name="ShelfSpecific")
 * @ORM\DiscriminatorColumn(name="specificClass", type="string")
 * @ORM\DiscriminatorMap({"bond" = "\App\Entity\Typed\ShelfSpecific\BondSpecific",
 *                        "pool" = "\App\Entity\Typed\ShelfSpecific\PoolSpecific",
 *                        "loan" = "\App\Entity\Typed\ShelfSpecific\LoanSpecific"
 * })
 */
abstract class ShelfSpecific extends AbstractTyped
{

    abstract public function addAttached(TypedInterface $entity);

    /**
     * @var integer $id
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue *
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\Deal", inversedBy = "shelfSpecifics")
     * @var \App\Entity\Deal
     */
    protected $deal;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\Typed\ShelfSpecificType", inversedBy="shelfSpecifics")
     * @var \App\Entity\Typed\ShelfSpecificType
     */
    protected $type;

    /**
     * @ORM\OneToMany(targetEntity="\App\Entity\Typed\Update\ShelfSpecificUpdate", mappedBy="shelfSpecific")
     * @var ArrayCollection
     */
    protected $updates;

    /**
     * @ORM\OneToOne(targetEntity = "\App\Entity\Typed\Update\ShelfSpecificUpdate", fetch="EAGER")
     * @var \App\Entity\Typed\Update\ShelfSpecificUpdate
     */
    protected $latestUpdate;

    /**
     * @var string $shelfDesignation
     * @ORM\Column(type = "string", nullable=true) **/
    protected $shelfDesignation;

    /**
     * @var integer $isFeeHedge | Default = 1 Fixed;
     * @ORM\Column(type="integer") *
     */
    protected $rateType = self::CALC_FIXED;

    /**
     * @var double $fixedRAte
     * @ORM\Column(type = "decimal", precision=7, scale=6, nullable=true) **/
    protected $fixedRate;

    /**
     * @var string $rateFormula
     * @ORM\Column(type = "string", nullable=true) **/
    protected $rateFormula;

    /**
     * @var string $rateFormula
     * @ORM\Column(type = "string", nullable=true) **/
    protected $directToBond;

    /**
     * @var string $rateIndex
     * @ORM\Column(type = "string", nullable=true) **/
    protected $rateIndex;

    /**
     * @var string $indexMaturity
     * @ORM\Column(type = "string", nullable=true) **/
    protected $indexMaturity;

    /**
     * @var string $basis
     * @ORM\Column(type = "string", nullable=true) **/
    protected $basis;

    /**
     *
     * @ORM\Column(type = "decimal", precision=14, scale=2, nullable=true) **/
    protected $originalBalance;

    public function __construct()
    {
        $this->updates = new ArrayCollection();
    }

    /**
     * @return \App\Entity\Deal
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
     * @return DefineTypeInterface
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param DefineTypeInterface $type
     */
    public function setType(DefineTypeInterface $type)
    {
        $this->type = $type;
    }

    /**
     * @return ArrayCollection
     */
    public function getUpdates()
    {
        return $this->updates;
    }

    /**
     * @return TypedUpdateInterface
     */
    public function getLatestUpdate()
    {
        return $this->latestUpdate;
    }

    /**
     * @param TypedUpdateInterface $latestUpdate
     */
    public function setLatestUpdate(TypedUpdateInterface $latestUpdate)
    {
        $this->_onPropertyChanged('latestUpdate', $this->latestUpdate, $latestUpdate);
        $this->latestUpdate = $latestUpdate;
    }
    
    /**
     * @param ShelfSpecificUpdate $specificsUpdate
     * @return $this
     * @throws \Exception
     */
    public function addShelfSpecificUpdate(ShelfSpecificUpdate $specificsUpdate)
    {
        return $this->addUpdate($specificsUpdate);

    }

    /**
     * @return string
     */
    public function getShelfDesignation()
    {
        return $this->shelfDesignation;
    }

    /**
     * @param string $shelfDesignation
     */
    public function setShelfDesignation($shelfDesignation)
    {
        $this->_onPropertyChanged('shelfDesignation', $this->shelfDesignation, $shelfDesignation);
        $this->shelfDesignation = $shelfDesignation;
    }

    /**
     * @return int
     */
    public function getRateType()
    {
        return $this->rateType;
    }

    /**
     * @param int $rateType
     */
    public function setRateType($rateType)
    {
        $this->_onPropertyChanged('rateType', $this->rateType, $rateType);
        $this->rateType = $rateType;
    }

    /**
     * @return float
     */
    public function getFixedRate()
    {
        return $this->fixedRate;
    }

    /**
     * @param float $fixedRate
     */
    public function setFixedRate($fixedRate)
    {
        $this->_onPropertyChanged('fixedRate', $this->fixedRate, $fixedRate);
        $this->fixedRate = $fixedRate;
    }

    /**
     * @return string
     */
    public function getRateFormula()
    {
        return $this->rateFormula;
    }

    /**
     * @param string $rateFormula
     */
    public function setRateFormula($rateFormula)
    {
        $this->_onPropertyChanged('rateFormula', $this->rateFormula, $rateFormula);
        $this->rateFormula = $rateFormula;
    }

    /**
     * @return string
     */
    public function getDirectToBond()
    {
        return $this->directToBond;
    }

    /**
     * @param string $directToBond
     */
    public function setDirectToBond($directToBond)
    {
        $this->_onPropertyChanged('directToBond', $this->directToBond, $directToBond);
        $this->directToBond = $directToBond;
    }

    /**
     * @return string
     */
    public function getRateIndex()
    {
        return $this->rateIndex;
    }

    /**
     * @param string $rateIndex
     */
    public function setRateIndex($rateIndex)
    {
        $this->_onPropertyChanged('rateIndex', $this->rateIndex, $rateIndex);
        $this->rateIndex = $rateIndex;
    }

    /**
     * @return string
     */
    public function getIndexMaturity()
    {
        return $this->indexMaturity;
    }

    /**
     * @param string $indexMaturity
     */
    public function setIndexMaturity($indexMaturity)
    {
        $this->_onPropertyChanged('indexMaturity', $this->indexMaturity, $indexMaturity);
        $this->indexMaturity = $indexMaturity;
    }

    /**
     * @return string
     */
    public function getBasis()
    {
        return $this->basis;
    }

    /**
     * @param string $basis
     */
    public function setBasis($basis)
    {
        $this->_onPropertyChanged('basis', $this->basis, $basis);
        $this->basis = $basis;
    }

    /**
     * @return string
     */
    public function getOriginalBalance()
    {
        return $this->originalBalance;
    }

    /**
     * @param string $originalBalance
     */
    public function setOriginalBalance($originalBalance)
    {
        $this->_onPropertyChanged('originalBalance', $this->originalBalance, $originalBalance);
        $this->originalBalance = $originalBalance;
    }


}