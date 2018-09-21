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
 * @MappedSuperclass
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
     * @ORM\GeneratedValue *
     */
    protected $id;
    
    /**
     * @var Deal $deal
     * @ORM\ManyToOne(targetEntity="\App\Entity\Deal", inversedBy = "fees") *
     */
    protected $deal;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\Typed\FeeType", inversedBy="fees")
     * @var \App\Entity\Typed\FeeType
     */
    protected $type;

    /**
     * @ORM\OneToMany(targetEntity="\App\Entity\Typed\Update\FeeUpdate", mappedBy="fee")
     * @var ArrayCollection
     */
    protected $updates;

    /**
     * @var \App\Entity\Typed\Update\FeeUpdate
     * @ORM\OneToOne(targetEntity="\App\Entity\Typed\Update\FeeUpdate", fetch="EAGER")
     */
    protected $latestUpdate = null;

    /**
     * @var integer $isFeeHedge | Default = 0 Negative;
     * @ORM\Column(type="integer") *
     */
    protected $isFeeHedge = 0;


    /**
     * @ORM\Column(type="integer")
     * @var integer $isStructuredDealFee | Default = 1, fee is paid at the
     *      StructuredDeal level
     */
    protected $isDealFee = 1;

    /**
     * @ORM\Column(type="decimal", precision=14, scale=2, nullable=true) *
     */
    /** @var number */
    protected $periodTotalFees;
    
    public function __construct()
    {
        $this->updates = new ArrayCollection();
    }


    /** @return number $periodTotalFees */
    public function getPeriodTotalFees ()
    {
        return $this->periodTotalFees;
    }

    /**  @param number $periodTotalFees */
    public function setPeriodTotalFees ($periodTotalFees)
    {
        $this->_onPropertyChanged('periodTotalFees', $this->periodTotalFees, $periodTotalFees);
        $this->periodTotalFees = $periodTotalFees;
    }

    public function getDeal ()
    {
        return $this->deal;
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
     * @param FeeUpdate $feeUpdate
     * @return $this
     * @throws \Exception
     */
    public function addFeeUpdate(FeeUpdate $feeUpdate){
        return $this->addUpdate($feeUpdate);
    }

    /**  @return int $isStructuredDealFee */
    public function getIsDealFee ()
    {
        return $this->isDealFee;
    }

    /** @return int $isInterestRateHedgeFee */
    public function getIsFeeHedge()
    {
        return $this->isFeeHedge;
    }

    /** @param \App\Entity\Deal $deal */
    public function setDeal (Deal $deal)
    {
        $this->_onPropertyChanged('deal', $this->deal, $deal);
        $this->deal = $deal;
    }

    /** @param integer $isDealFee */
    public function setIsDealFee ($isDealFee)
    {
        $this->_onPropertyChanged('isDealFee', $this->isDealFee, $isDealFee);
        $this->isDealFee = $isDealFee;
    }

    public function setIsInterestRateHedgeFee ($isFeeHedge)
    {
        if ($isFeeHedge == 0 || $isFeeHedge == 1){
            $this->_onPropertyChanged('isFeeHedge', $this->isFeeHedge, $isFeeHedge);
            $this->isFeeHedge = $isFeeHedge;
        }else
            throw new \Exception(
                "Variable isInterestRateHedgeFee can only be either 1 or 0: $isFeeHedge was given");
    }


}