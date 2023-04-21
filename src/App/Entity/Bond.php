<?php


namespace App\Entity;
use App\Entity\Bond\Component;
use App\Entity\Update\BondUpdate;
use App\Service\CreatePropertiesArrayTrait;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks as HasLifecycleCallbacks;

/**
 * @ORM\Entity
 * @ORM\Table(name="Bond")
 * @ORM\ChangeTrackingPolicy("NOTIFY")
 * @HasLifecycleCallbacks
 *
 */
class Bond extends DomainObject
{
    use CreatePropertiesArrayTrait;

    const SOLVE_FOR_YIELD = 1;
    const SOLVE_FOR_PRICE = 2;

    /**
     * @ORM\Id 
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue **/
    protected int $id;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\Pool", inversedBy="bonds")
     * @var Pool
     **/
    protected $pool;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\Deal", inversedBy="bonds", cascade={"persist"})
     * @var Deal
     **/
    protected $deal;

    /** @ORM\Column(type="string", unique=false) **/
    protected string $cusip;

    /** @ORM\Column(type="string") **/
    protected string $className;

    /** @ORM\Column(type="decimal", precision=14, scale=2) **/
    protected float $originalBalance;

    /** @ORM\Column(type="decimal", precision=14, scale=2) **/
    protected float $currentBalance = 0;

    /** @ORM\Column(type="string", nullable=true) **/
    protected string $rateFormula;

    /** @ORM\Column(type="date", nullable=true) **/
    protected $scheduledMaturityDate;

    /** @ORM\Column(type="decimal", precision=6, scale=5, nullable=true) **/
    protected float $fixedRate;

    /** @ORM\Column(type="decimal", precision=8, scale=6, nullable=true) **/
    protected float $origCreditSupport;

    /**
     * @ORM\Column(type="decimal", precision=6, scale=5) *
     */
    protected float$currCreditSupport = 0;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\BasisCount", inversedBy="bonds") *
     */
    protected $basisCount;

    /**
     * @ORM\Column(name="floatingIndex", type="string", nullable=true)*
     */
    protected string $floatingIndex;

    /**
     * @ORM\Column(name="indexMaturity", type="string", nullable=true) *
     */
    protected string $indexMaturity;

    /**
     * @ORM\Column(name="spreadArray", type="string", nullable=true) *
     */
    protected string $spreadArray;

    /**
     * @ORM\Column(type="datetime", nullable=true) *
     */
    protected $legalFinal;

    /**
     * @ORM\Column(type="integer", nullable=true) *
     */
    protected $isIoBond;

    /**
     * @ORM\Column(type="integer", nullable=true) *
     */
    protected int $isPoBond;

    /**
     * @ORM\Column(type="integer", nullable=true) *
     */
    protected int $isComponent;

    /**
     * @ORM\OneToMany(targetEntity="\App\Entity\Bond\Component",
     *     mappedBy="bond", mappedBy="bond")
     * @var ArrayCollection
     **/
    protected $components;

    /**
     * @ORM\OneToMany(targetEntity="\App\Entity\Update\BondUpdate", mappedBy="bond")
     * @ORM\OrderBy({"reportDate" = "ASC"})
     * @var ArrayCollection
     **/
    protected $updates;

    /** @ORM\Column(type="integer") **/
    protected $updateCount = 0;

    /**
     * @ORM\OneToOne(targetEntity="\App\Entity\Update\BondUpdate")
     * @var \App\Entity\Update\BondUpdate
     **/
    protected $latestUpdate;

    /**
     * @ORM\Column(type="string", nullable=true) *
     */
    protected string $moodysRating;

    /**
     * @ORM\Column(type="string", nullable=true) *
     */
    protected string $spRating;

    /**
     * @ORM\Column(type="string", nullable=true) *
     */
    protected string $fitchRating;

    /**
     * @ORM\Column(type="string", nullable=true) *
     */
    protected string $dbrsRating;

    /**
     * @ORM\ManyToMany(targetEntity="\App\Entity\Typed\ShelfSpecific\BondSpecific", mappedBy="bonds")
     */
    protected $specifics;

    /**
     * @ORM\ManyToMany(targetEntity="\App\Entity\Typed\Fee\BondFee", mappedBy="bonds")
     */
    protected $fees;

    /**
     * @ORM\ManyToMany(targetEntity="\App\Entity\Typed\Account\BondAccount", mappedBy="bonds")
     */
    protected $accounts;

    /**
     * @ORM\ManyToMany(targetEntity="\App\Entity\Typed\Trigger\BondTrigger", mappedBy="bonds")
     */
    protected $triggers;

    /**
     * @ORM\Column(type = "integer")
     *
     **/
    protected int $feeCount = 0;

    /**
     * @ORM\Column(type = "integer")
     *
     **/
    protected int $triggerCount = 0;

    /**
     * @ORM\Column(type = "integer")
     *
     **/
    protected int $shelfSpecificCount = 0;

    /**
     * @ORM\Column(type = "integer")
     *
     **/
    protected int $accountCount = 0;

    public function __construct()
    {
        $this->updates = new ArrayCollection();
        $this->components = new ArrayCollection();
        parent::__construct();
    }

    /**
     * @return int
     */
    public function getId():int
    {
        return $this->id;
    }

    /**
     * @return Pool
     */
    public function getPool():Pool
    {
        return $this->pool;
    }

    /**
     * @param Pool $pool
     */
    public function setPool(Pool$pool):void
    {
        $this->implementChange($this,'pool', $this->pool, $pool);
    }

    /**
     * @return Deal
     */
    public function getDeal():Deal
    {
        return $this->deal;
    }

    /**
     * @param Deal $deal
     */
    public function setDeal(Deal$deal):void
    {
        $this->implementChange($this,'deal', $this->deal, $deal);
    }

    /**
     * @return string
     */
    public function getCusip():string
    {
        return $this->cusip;
    }

    /**
     * @param string  $cusip
     */
    public function setCusip(string $cusip):void
    {
        $this->implementChange($this,'cusip', $this->cusip, $cusip);
    }

    /**
     * @return string
     */
    public function getClassName():string
    {
        return $this->className;
    }

    /**
     * @param string $className
     */
    public function setClassName(string $className):void
    {
        $this->implementChange($this,'className', $this->className, $className);
    }

    /**
     * @return float
     */
    public function getOriginalBalance():float
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

    /**
     * @return float
     */
    public function getCurrentBalance():float
    {
        return $this->currentBalance;
    }

    /**
     * @param float $currentBalance
     */
    public function setCurrentBalance(float $currentBalance):void
    {
        $this->implementChange($this,'currentBalance', $this->currentBalance, $currentBalance);
    }

    /**
     * @return string
     */
    public function getRateFormula():string
    {
        return $this->rateFormula;
    }

    /**
     * @param mixed $rateFormula
     */
    public function setRateFormula(mixed $rateFormula):void
    {
        if(is_array($rateFormula))
            $rateFormula = serialize($rateFormula);
        $this->implementChange($this,'rateFormula', $this->rateFormula, $rateFormula);
    }

    /**
     * @return \DateTime|null
     */
    public function getScheduledMaturityDate():\DateTime|null
    {
        return $this->scheduledMaturityDate;
    }

    /**
     * @param \DateTime $scheduledMaturityDate
     */
    public function setScheduledMaturityDate(\DateTime $scheduledMaturityDate):void
    {
        $this->implementChange($this,'scheduledMaturityDate', $this->scheduledMaturityDate, $scheduledMaturityDate);
    }

    /**
     * @return float|null
     */
    public function getFixedRate():float|null
    {
        return $this->fixedRate;
    }

    /**
     * @param mixed $fixedRate
     */
    public function setFixedRate(mixed $fixedRate):void
    {
        $this->implementChange($this,'fixedRate', $this->fixedRate, $fixedRate);
    }

    /**
     * @return mixed
     */
    public function getOrigCreditSupport(): mixed
    {
        return $this->origCreditSupport;
    }

    /**
     * @param mixed $origCreditSupport
     */
    public function setOrigCreditSupport(mixed $origCreditSupport)
    {
        $this->implementChange($this,'origCreditSupport', $this->origCreditSupport, $origCreditSupport);
    }

    /**
     * @return mixed
     */
    public function getCurrCreditSupport(): mixed
    {
        return $this->currCreditSupport;
    }

    /**
     * @param mixed $currCreditSupport
     */
    public function setCurrCreditSupport(mixed $currCreditSupport)
    {
        $this->implementChange($this,'currCreditSupport', $this->currCreditSupport, $currCreditSupport);
    }

    /**
     * @return mixed
     */
    public function getBasisCount(): mixed
    {
        return $this->basisCount;
    }

    /**
     * @param mixed $basisCount
     */
    public function setBasisCount(mixed $basisCount)
    {
        $this->implementChange($this,'basisCount', $this->basisCount, $basisCount);
    }

    /**
     * @return mixed
     */
    public function getFloatingIndex(): mixed
    {
        return $this->floatingIndex;
    }

    /**
     * @param mixed $floatingIndex
     */
    public function setFloatingIndex(mixed $floatingIndex)
    {
        $this->implementChange($this,'floatingIndex', $this->floatingIndex, $floatingIndex);
    }

    /**
     * @return string
     */
    public function getIndexMaturity(): string
    {
        return $this->indexMaturity;
    }

    /**
     * @param mixed $indexMaturity
     */
    public function setIndexMaturity(mixed $indexMaturity)
    {
        $this->implementChange($this,'indexMaturity', $this->indexMaturity, $indexMaturity);
    }

    /**
     * @return mixed
     */
    public function getSpreadArray(): mixed
    {
        return $this->spreadArray;
    }

    /**
     * @param mixed $spreadArray
     */
    public function setSpreadArray(mixed $spreadArray)
    {
        $spread = serialize($spreadArray);
        $this->implementChange($this,'spreadArray', $this->spreadArray, $spread);
    }

    /**
     * @return mixed
     */
    public function getLegalFinal(): mixed
    {
        return $this->legalFinal;
    }

    /**
     * @param mixed $legalFinal
     */
    public function setLegalFinal(mixed $legalFinal)
    {
        $this->implementChange($this,'legalFinal', $this->legalFinal, $legalFinal);
    }

    /**
     * @return mixed
     */
    public function getIsIoBond(): mixed
    {
        return $this->isIoBond;
    }

    /**
     * @param mixed $isIoBond
     */
    public function setIsIoBond(mixed $isIoBond)
    {
        $this->implementChange($this,'isIoBond', $this->isIoBond, $isIoBond);
    }

    /**
     * @return int
     */
    public function getIsPoBond(): int
    {
        return $this->isPoBond;
    }

    /**
     * @param mixed $isPoBond
     */
    public function setIsPoBond(mixed $isPoBond)
    {
        $this->implementChange($this,'isPoBond', $this->isPoBond, $isPoBond);
    }

    /**
     * @return int
     */
    public function getIsComponent(): int
    {
        return $this->isComponent;
    }

    /**
     * @param mixed $isComponent
     */
    public function setIsComponent(mixed $isComponent)
    {
        $this->implementChange($this,'isComponent', $this->isComponent, $isComponent);
    }

    /**
     * @return ArrayCollection
     */
    public function getComponents(): ArrayCollection
    {
        return $this->components;
    }

    /**
     * @param Component $component
     */
    public function addComponent(Component $component)
    {
        $component->setBond($this);
        $this->components->add($component);
    }

    /**
     * @return mixed
     */
    public function getUpdates(): mixed
    {
        return $this->updates;
    }

    /**
     * @param BondUpdate $update
     */
    public function addUpdate(BondUpdate $update)
    {
        $update->setBond($this);
        $this->updates->add($update);
    }

    /**
     * @return int
     */
    public function getUpdateCount(): int
    {
        return $this->updateCount;
    }

    /**
     * @param mixed $updateCount
     */
    public function setUpdateCount(mixed $updateCount)
    {
        $this->implementChange($this,'updateCount', $this->updateCount, $updateCount);
    }

    /**
     * @return BondUpdate
     */
    public function getLatestUpdate(): BondUpdate
    {
        return $this->latestUpdate;
    }

    /**
     * @param BondUpdate $latestUpdate
     */
    public function setLatestUpdate(BondUpdate $latestUpdate)
    {
        $this->implementChange($this,'latestUpdate', $this->latestUpdate, $latestUpdate);
    }

    /**
     * @return int
     */
    public function getFeeCount():int
    {
        return $this->feeCount;
    }

    /**
     * @param number $feeCount
     */
    public function setFeeCount($feeCount)
    {
        $this->implementChange($this,'feeCount', $this->feeCount, $feeCount);
    }

    /**
     * @return int
     */
    public function getTriggerCount():int
    {
        return $this->triggerCount;
    }

    /**
     * @param int $triggerCount
     */
    public function setTriggerCount(int $triggerCount):void
    {
        $this->implementChange($this,'triggerCount', $this->triggerCount, $triggerCount);
    }

    /**
     * @return int
     */
    public function getShelfSpecificCount():int
    {
        return $this->shelfSpecificCount;
    }

    /**
     * @param int $shelfSpecificCount
     */
    public function setShelfSpecificCount(int $shelfSpecificCount):void
    {
        $this->implementChange($this,'shelfSpecificCount', $this->shelfSpecificCount, $shelfSpecificCount);
    }

    /**
     * @return int
     */
    public function getAccountCount():int
    {
        return $this->accountCount;
    }

    /**
     * @param int $accountCount
     */
    public function setAccountCount(int $accountCount):void
    {
        $this->implementChange($this,'accountCount', $this->accountCount, $accountCount);
    }

    /**
     * @return string|null
     */
    public function getMoodysRating():string|null
    {
        return $this->moodysRating;
    }

    /**
     * @param string $moodysRating
     */
    public function setMoodysRating(string $moodysRating):void
    {
        $this->implementChange($this,'moodysRating', $this->moodysRating, $moodysRating);
    }

    /**
     * @return string|null
     */
    public function getSpRating():string|null
    {
        return $this->spRating;
    }

    /**
     * @param string $spRating
     */
    public function setSpRating(string $spRating):void
    {
        $this->implementChange($this,'spRating', $this->spRating, $spRating);
    }

    /**
     * @return string|null
     */
    public function getFitchRating():string|null
    {
        return $this->fitchRating;
    }

    /**
     * @param string $fitchRating
     */
    public function setFitchRating(string $fitchRating)
    {
        $this->implementChange($this,'fitchRating', $this->fitchRating, $fitchRating);
    }

    /**
     * @return string|null
     */
    public function getDbrsRating():string|null
    {
        return $this->dbrsRating;
    }

    /**
     * @param string $dbrsRating
     */
    public function setDbrsRating(string $dbrsRating):void
    {
        $this->implementChange($this,'dbrsRating', $this->dbrsRating, $dbrsRating);
    }
}