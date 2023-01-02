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
 * \Doctrine\ORM\Mapping\MappedSuperclass
 * \Doctrine\ORM\Mapping\Entity
 * \Doctrine\ORM\Mapping\Table(name="ShelfSpecific")
 * \Doctrine\ORM\Mapping\DiscriminatorColumn(name="specificClass", type="string")
 * \Doctrine\ORM\Mapping\DiscriminatorMap({"bond" = "\App\Entity\Typed\ShelfSpecific\BondSpecific",
 *                        "pool" = "\App\Entity\Typed\ShelfSpecific\PoolSpecific",
 *                        "loan" = "\App\Entity\Typed\ShelfSpecific\LoanSpecific"
 * })
 */
abstract class ShelfSpecific extends AbstractTyped
{

    abstract public function addAttached(TypedInterface $entity);

    /**
     * @var integer $id
     * \Doctrine\ORM\Mapping\Id
     * \Doctrine\ORM\Mapping\Column(type="integer")
     * \Doctrine\ORM\Mapping\GeneratedValue *
     */
    protected int $id;

    /**
     * \Doctrine\ORM\Mapping\ManyToOne(targetEntity="\App\Entity\Deal", inversedBy = "shelfSpecifics")
     * @var Deal
     */
    protected $deal;

    /**
     * \Doctrine\ORM\Mapping\ManyToOne(targetEntity="\App\Entity\Typed\ShelfSpecificType", inversedBy="shelfSpecifics")
     * @var ShelfSpecificType
     */
    protected $type;

    /**
     * \Doctrine\ORM\Mapping\OneToMany(targetEntity="\App\Entity\Typed\Update\ShelfSpecificUpdate", mappedBy="shelfSpecific")
     * @var ArrayCollection
     */
    protected $updates;

    /**
     * \Doctrine\ORM\Mapping\OneToOne(targetEntity = "\App\Entity\Typed\Update\ShelfSpecificUpdate", fetch="EAGER")
     * @var \App\Entity\Typed\Update\ShelfSpecificUpdate
     */
    protected $latestUpdate;

    /**
     * @var string|null $shelfDesignation
     * \Doctrine\ORM\Mapping\Column(type = "string", nullable=true)
     **/
    protected string|null $shelfDesignation;

    /**
     * @var integer $isFeeHedge | Default = 1 Fixed;
     * \Doctrine\ORM\Mapping\Column(type="integer") *
     */
    protected int $rateType = self::CALC_FIXED;

    /**
     * @var float|null $fixedRAte
     * \Doctrine\ORM\Mapping\Column(type = "decimal", precision=7, scale=6, nullable=true)
     **/
    protected float|null $fixedRate;

    /**
     * @var string|null $rateFormula
     * \Doctrine\ORM\Mapping\Column(type = "string", nullable=true)
     **/
    protected string|null $rateFormula;

    /**
     * @var string|null $rateFormula
     * \Doctrine\ORM\Mapping\Column(type = "string", nullable=true)
     **/
    protected string|null $directToBond;

    /**
     * @var string|null $rateIndex
     * \Doctrine\ORM\Mapping\Column(type = "string", nullable=true)
     **/
    protected string|null $rateIndex;

    /**
     * @var string|null $indexMaturity
     * \Doctrine\ORM\Mapping\Column(type = "string", nullable=true)
     **/
    protected string|null $indexMaturity;

    /**
     * @var string|null $basis
     * \Doctrine\ORM\Mapping\Column(type = "string", nullable=true)
     **/
    protected string|null $basis;

    /**
     * @var float|null $originalBalance
     * \Doctrine\ORM\Mapping\Column(type = "decimal", precision=14, scale=2, nullable=true)
     **/
    protected float|null $originalBalance;

    public function __construct()
    {
        $this->updates = new ArrayCollection();
        parent::__construct();
    }

    /**
     * @return Deal|null
     */
    public function getDeal():?Deal
    {
        return $this->deal;
    }

    /**
     * @param Deal $deal
     */
    public function setDeal(Deal $deal):void
    {
        $this->implementChange($this,'deal', $this->deal, $deal);
    }

    /**
     * @return ShelfSpecificType|null
     */
    public function getType():?ShelfSpecificType
    {
        return $this->type;
    }

    /**
     * @param DefineTypeInterface $type
     */
    public function setType(DefineTypeInterface $type):void
    {
        $this->type = $type;
    }

    /**
     * @return ArrayCollection|null
     */
    public function getUpdates():?ArrayCollection
    {
        return $this->updates;
    }

    /**
     * @return TypedUpdateInterface|ShelfSpecificUpdate
     */
    public function getLatestUpdate(): TypedUpdateInterface|ShelfSpecificUpdate
    {
        return $this->latestUpdate;
    }

    /**
     * @param TypedUpdateInterface $latestUpdate
     */
    public function setLatestUpdate(TypedUpdateInterface $latestUpdate):void
    {
        $this->implementChange($this,'latestUpdate', $this->latestUpdate, $latestUpdate);
    }
    
    /**
     * @param ShelfSpecificUpdate $specificsUpdate
     * @return $this
     * @throws \Exception
     */
    public function addShelfSpecificUpdate(ShelfSpecificUpdate $specificsUpdate): static
    {
        return $this->addUpdate($specificsUpdate);

    }

    /**
     * @return string|null
     */
    public function getShelfDesignation(): ?string
    {
        return $this->shelfDesignation;
    }

    /**
     * @param string $shelfDesignation
     */
    public function setShelfDesignation(string $shelfDesignation):void
    {
        $this->implementChange($this,'shelfDesignation', $this->shelfDesignation, $shelfDesignation);
    }

    /**
     * @return int
     */
    public function getRateType():int
    {
        return $this->rateType;
    }

    /**
     * @param int $rateType
     */
    public function setRateType(int $rateType):void
    {
        $this->implementChange($this,'rateType', $this->rateType, $rateType);
    }

    /**
     * @return float|null
     */
    public function getFixedRate():?float
    {
        return $this->fixedRate;
    }

    /**
     * @param float $fixedRate
     */
    public function setFixedRate(float $fixedRate):void
    {
        $this->implementChange($this,'fixedRate', $this->fixedRate, $fixedRate);
    }

    /**
     * @return string|null
     */
    public function getRateFormula():?string
    {
        return $this->rateFormula;
    }

    /**
     * @param string $rateFormula
     */
    public function setRateFormula(string $rateFormula):void
    {
        $this->implementChange($this,'rateFormula', $this->rateFormula, $rateFormula);
    }

    /**
     * @return string|null
     */
    public function getDirectToBond():?string
    {
        return $this->directToBond;
    }

    /**
     * @param string $directToBond
     */
    public function setDirectToBond(string $directToBond):void
    {
        $this->implementChange($this,'directToBond', $this->directToBond, $directToBond);
    }

    /**
     * @return string|null
     */
    public function getRateIndex():?string
    {
        return $this->rateIndex;
    }

    /**
     * @param string $rateIndex
     */
    public function setRateIndex(string $rateIndex):void
    {
        $this->implementChange($this,'rateIndex', $this->rateIndex, $rateIndex);
    }

    /**
     * @return string|null
     */
    public function getIndexMaturity():?string
    {
        return $this->indexMaturity;
    }

    /**
     * @param string $indexMaturity
     */
    public function setIndexMaturity(string $indexMaturity):void
    {
        $this->implementChange($this,'indexMaturity', $this->indexMaturity, $indexMaturity);
    }

    /**
     * @return string|null
     */
    public function getBasis():?string
    {
        return $this->basis;
    }

    /**
     * @param string $basis
     */
    public function setBasis(string $basis):void
    {
        $this->implementChange($this,'basis', $this->basis, $basis);
    }

    /**
     * @return float|null
     */
    public function getOriginalBalance():?float
    {
        return $this->originalBalance;
    }

    /**
     * @param float $originalBalance
     */
    public function setOriginalBalance(float $originalBalance):void
    {
        $this->implementChange($this,'originalBalance', $this->originalBalance, $originalBalance);
    }
}