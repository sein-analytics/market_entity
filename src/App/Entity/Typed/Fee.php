<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 * Date: 6/22/16
 * Time: 5:11 PM
 */

namespace App\Entity\Typed;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use App\Entity\Deal;
use Doctrine\ORM\Mapping\MappedSuperclass;
use App\Entity\Typed\Update\FeeUpdate;
use App\Entity\Typed\Update\TypedUpdateInterface;

/**
 * @ORM\MappedSuperclass
 * @ORM\Entity
 * @ORM\Table(name="Fee")
 * @ORM\DiscriminatorColumn(name="feeClass", type="string")
 * @ORM\DiscriminatorMap({"bond" = "\App\Entity\Typed\Fee\BondFee",
 *                        "pool" = "\App\Entity\Typed\Fee\PoolFee",
 *                        "loan" = "\App\Entity\Typed\Fee\LoanFee"
 * })
 */
abstract class Fee extends AbstractTyped
{
    abstract public function addAttached(TypedInterface $entity);

    /**
     * @var integer $id
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    protected int $id;
    
    /**
     * @var Deal $deal
     * @ORM\ManyToOne(targetEntity="\App\Entity\Deal", inversedBy = "fees") *
     */
    protected $deal;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\Typed\FeeType", inversedBy="fees")
     * @var FeeType
     */
    protected $type;

    /**
     * @ORM\OneToMany(targetEntity="\App\Entity\Typed\Update\FeeUpdate", mappedBy="fee")
     * @var ArrayCollection
     */
    protected $updates;

    /**
     * @var FeeUpdate
     * @ORM\OneToOne(targetEntity="\App\Entity\Typed\Update\FeeUpdate", fetch="EAGER")
     */
    protected $latestUpdate = null;

    /**
     * @var int $isFeeHedge | Default = 0 Negative;
     * @ORM\Column(type="integer") *
     */
    protected int $isFeeHedge = 0;


    /**
     * @ORM\Column(type="integer")
     * @var int $isStructuredDealFee | Default = 1, fee is paid at the
     *      StructuredDeal level
     */
    protected int $isDealFee = 1;

    /**
     * @ORM\Column(type="float", precision=14, scale=2, nullable=true)
     * @var float|null
     */
    protected float|null $periodTotalFees;
    
    public function __construct()
    {
        $this->updates = new ArrayCollection();
        parent::__construct();
    }


    /** @return float|null $periodTotalFees */
    public function getPeriodTotalFees ():?float
    {
        return $this->periodTotalFees;
    }

    /**  @param float $periodTotalFees */
    public function setPeriodTotalFees (float $periodTotalFees):void
    {
        $this->implementChange($this,'periodTotalFees', $this->periodTotalFees, $periodTotalFees);
    }

    public function getDeal ():?Deal
    {
        return $this->deal;
    }

    /**
     * @return DefineTypeInterface
     */
    public function getType():DefineTypeInterface
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
    public function getUpdates():ArrayCollection
    {
        return $this->updates;
    }

    /**
     * @return TypedUpdateInterface|null
     */
    public function getLatestUpdate():?TypedUpdateInterface
    {
        return $this->latestUpdate;
    }

    /**
     * @param TypedUpdateInterface $latestUpdate
     */
    public function setLatestUpdate(TypedUpdateInterface $latestUpdate)
    {
        $this->implementChange($this,'latestUpdate', $this->latestUpdate, $latestUpdate);
    }

    /**
     * @param FeeUpdate $feeUpdate
     * @return $this
     * @throws \Exception
     */
    public function addFeeUpdate(FeeUpdate $feeUpdate){
        return $this->addUpdate($feeUpdate);
    }

    /**  @return int $isStructuredDealFee */
    public function getIsDealFee ():int
    {
        return $this->isDealFee;
    }

    /** @return int $isInterestRateHedgeFee */
    public function getIsFeeHedge():int
    {
        return $this->isFeeHedge;
    }

    /** @param Deal $deal */
    public function setDeal (Deal $deal):void
    {
        $this->implementChange($this,'deal', $this->deal, $deal);
    }

    /** @param int $isDealFee */
    public function setIsDealFee (int $isDealFee):void
    {
        $this->implementChange($this,'isDealFee', $this->isDealFee, $isDealFee);
    }

    public function setIsInterestRateHedgeFee (int $isFeeHedge):void
    {
        if ($isFeeHedge == 0 || $isFeeHedge == 1){
            $this->implementChange($this,'isFeeHedge', $this->isFeeHedge, $isFeeHedge);
        }else
            throw new \Exception(
                "Variable isInterestRateHedgeFee can only be either 1 or 0: $isFeeHedge was given");
    }


}