<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 * Date: 6/22/16
 * Time: 5:11 PM
 */

namespace App\Entity\Typed;

use \App\Entity\Typed\FeeType;
use Exception;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use App\Entity\Deal;
use App\Entity\Typed\Update\FeeUpdate;
use App\Entity\Typed\Update\TypedUpdateInterface;

#[ORM\MappedSuperclass]
abstract class Fee extends AbstractTyped
{
    abstract public function addAttached(TypedInterface $entity);

    /**
     * @var integer $id
     */
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    protected int $id;
    
    /**
     * @var Deal $deal
     */
    #[ORM\ManyToOne(targetEntity:  Deal::class, inversedBy: 'fees')]
    protected $deal;

    /**
     * @var FeeType
     */
    #[ORM\ManyToOne(targetEntity: FeeType::class, inversedBy: 'fees')]
    protected $type;

    /**
     * @var ArrayCollection
     */
    #[ORM\OneToMany(targetEntity:  FeeUpdate::class, mappedBy: 'fee')]
    protected $updates;

    /**
     * @var FeeUpdate
     */
    #[ORM\OneToOne(targetEntity:  FeeUpdate::class, fetch: 'EAGER')]
    protected $latestUpdate = null;

    /**
     * @var int $isFeeHedge | Default = 0 Negative;
     */
    #[ORM\Column(type: 'integer')]
    protected int $isFeeHedge = 0;


    /**
     * @var int $isStructuredDealFee | Default = 1, fee is paid at the
     *      StructuredDeal level
     */
    #[ORM\Column(type: 'integer')]
    protected int $isDealFee = 1;

    /**
     * @var float|null
     */
    #[ORM\Column(type: 'float', precision: 14, scale: 2, nullable: true)]
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
     * @throws Exception
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
            throw new Exception(
                "Variable isInterestRateHedgeFee can only be either 1 or 0: $isFeeHedge was given");
    }


}