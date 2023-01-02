<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 */

namespace App\Entity\Typed;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use App\Entity\Deal;
use App\Entity\Typed\Update\AccountUpdate;
use Doctrine\ORM\Mapping\MappedSuperclass;
use App\Entity\Typed\Update\TypedUpdateInterface;

/**
 * @ORM\MappedSuperClass
 * @ORM\Entity
 * @ORM\Table(name="Account")
 * @ORM\DiscriminatorColumn(name="accountClass", type="string")
 * @ORM\DiscriminatorMap({"bond" = "\App\Entity\Typed\Account\BondAccount",
 *                        "pool" = "\App\Entity\Typed\Account\PoolAccount",
 *                        "loan" = "\App\Entity\Typed\Account\LoanAccount"
 * })
 */
abstract class Account extends AbstractTyped
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
     * @ORM\ManyToOne(targetEntity="\App\Entity\Deal", inversedBy = "accounts") *
     */
    protected $deal;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\Typed\AccountType", inversedBy="accounts")
     * @var AccountType
     */
    protected $type;

    /**
     * @ORM\OneToMany(targetEntity="\App\Entity\Typed\Update\AccountUpdate", mappedBy="account")
     * @var ArrayCollection
     */
    protected $updates;

    /**
     * @var AccountUpdate
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
     * @ORM\Column(type="decimal", precision=14, scale=2, nullable=true) *
     * @var float|null
    */
    protected float|null $periodTotalFees;

    public function __construct()
    {
        $this->updates = new ArrayCollection();
        parent::__construct();
    }

    public function getId():int
    {
        return $this->id;
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

    /**
     * @return Deal|null
     */
    public function getDeal ():?Deal
    {
        return $this->deal;
    }

    /**
     * @return AccountType|null
     */
    public function getType():?AccountType
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
     * @return ArrayCollection|null
     */
    public function getUpdates():?ArrayCollection
    {
        return $this->updates;
    }

    /**
     * @return AccountUpdate|null
     */
    public function getLatestUpdate():?AccountUpdate
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
     * @param AccountUpdate $accountUpdate
     * @return $this
     * @throws \Exception
     */
    public function addAccountUpdate(AccountUpdate $accountUpdate)
    {
        return $this->addUpdate($accountUpdate);
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
    public function setDeal (Deal $deal)
    {
        $this->implementChange($this,'deal', $this->deal, $deal);
    }

    /** @param integer $isDealFee */
    public function setIsDealFee (int $isDealFee):void
    {
        $this->implementChange($this,'isDealFee', $this->isDealFee, $isDealFee);
    }

    public function setIsInterestRateHedgeFee ($isFeeHedge)
    {
        if ($isFeeHedge == 0 || $isFeeHedge == 1){
            $this->implementChange($this,'isFeeHedge', $this->isFeeHedge, $isFeeHedge);
        }else
            throw new \Exception(
                "Variable isInterestRateHedgeFee can only be either 1 or 0: $isFeeHedge was given");
    }
}