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
 * @MappedSuperClass
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
     * @ORM\GeneratedValue *
     */
    protected $id;

    /**
     * @var Deal $deal
     * @ORM\ManyToOne(targetEntity="\App\Entity\Deal", inversedBy = "accounts") *
     */
    protected $deal;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\Typed\AccountType", inversedBy="accounts")
     * @var \App\Entity\Typed\AccountType
     */
    protected $type;

    /**
     * @ORM\OneToMany(targetEntity="\App\Entity\Typed\Update\AccountUpdate", mappedBy="account")
     * @var ArrayCollection
     */
    protected $updates;

    /**
     * @var \App\Entity\Typed\Update\AccountUpdate
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

    public function getId()
    {
        return $this->id;
    }

    /** @return number $periodTotalFees */
    public function getPeriodTotalFees ()
    {
        return $this->periodTotalFees;
    }

    /**  @param number $periodTotalFees */
    public function setPeriodTotalFees ($periodTotalFees)
    {
        $this->implementChange($this,'periodTotalFees', $this->periodTotalFees, $periodTotalFees);
    }

    /**
     * @return Deal
     */
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
        $this->implementChange($this,'latestUpdate', $this->latestUpdate, $latestUpdate);
    }

    /**
     * @param AccountUpdate $accountUpdate
     * @return $this
     * @throws \Exception
     */
    public function addAccountUpdate(AccountUpdate $accountUpdate){
        return $this->addUpdate($accountUpdate);
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
        $this->implementChange($this,'deal', $this->deal, $deal);
    }

    /** @param integer $isDealFee */
    public function setIsDealFee ($isDealFee)
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