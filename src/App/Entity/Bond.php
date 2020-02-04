<?php


namespace App\Entity;

use App\Entity\Bond\Component;
use App\Entity\Update\BondUpdate;
use App\Service\CreatePropertiesArrayTrait;
use Doctrine\Common\NotifyPropertyChanged;
use Doctrine\ORM\Mapping\ChangeTrackingPolicy;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="Bond")
 * @ChangeTrackingPolicy("NOTIFY")
 * @ORM\HasLifecycleCallbacks
 *
 */
class Bond extends DomainObject
{
    use CreatePropertiesArrayTrait;

    const SOLVE_FOR_YIELD = 1;
    const SOLVE_FOR_PRICE = 2;

    /**
     * @ORM\Id @ORM\Column(type="integer")
     * @ORM\GeneratedValue **/
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\Pool", inversedBy="bonds")
     * @var \App\Entity\Pool
     **/
    protected $pool;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\Deal", inversedBy="bonds", cascade={"persist"})
     * @var \App\Entity\Deal
     **/
    protected $deal;

    /** @ORM\Column(type="string", unique=false) **/
    protected $cusip;

    /** @ORM\Column(type="string") **/
    protected $className;

    /** @ORM\Column(type="decimal", precision=14, scale=2) **/
    protected $originalBalance;

    /** @ORM\Column(type="decimal", precision=14, scale=2) **/
    protected $currentBalance = 0;

    /** @ORM\Column(type="string", nullable=true) **/
    protected $rateFormula;

    /** @ORM\Column(type="date", nullable=true) **/
    protected $scheduledMaturityDate;

    /** @ORM\Column(type="decimal", precision=6, scale=5, nullable=true) **/
    protected $fixedRate;

    /** @ORM\Column(type="decimal", precision=8, scale=6, nullable=true) **/
    protected $origCreditSupport;

    /** @ORM\Column(type="decimal", precision=6, scale=5) **/
    protected $currCreditSupport = 0;

    /** @ORM\ManyToOne(targetEntity="\App\Entity\BasisCount", inversedBy="bonds") **/
    protected $basisCount;

    /** @ORM\Column(name="floatingIndex", type="string", nullable=true)**/
    protected $floatingIndex;

    /** @ORM\Column(name="indexMaturity", type="string", nullable=true) **/
    protected $indexMaturity;

    /** @ORM\Column(name="spreadArray", type="string", nullable=true) **/
    protected $spreadArray;

    /** @ORM\Column(type="datetime", nullable=true) **/
    protected $legalFinal;

    /** @ORM\Column(type="integer", nullable=true) **/
    protected $isIoBond;

    /** @ORM\Column(type="integer", nullable=true) **/
    protected $isPoBond;

    /** @ORM\Column(type="integer", nullable=true) **/
    protected $isComponent;

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

    /** @ORM\Column(type="string", nullable=true) **/
    protected $moodysRating;

    /** @ORM\Column(type="string", nullable=true) **/
    protected $spRating;

    /** @ORM\Column(type="string", nullable=true) **/
    protected $fitchRating;

    /** @ORM\Column(type="string", nullable=true) **/
    protected $dbrsRating;

    /** @ORM\ManyToMany(targetEntity="\App\Entity\Typed\ShelfSpecific\BondSpecific", mappedBy="bonds")   */
    protected $specifics;

    /** @ORM\ManyToMany(targetEntity="\App\Entity\Typed\Fee\BondFee", mappedBy="bonds")   */
    protected $fees;

    /** @ORM\ManyToMany(targetEntity="\App\Entity\Typed\Account\BondAccount", mappedBy="bonds")   */
    protected $accounts;

    /** @ORM\ManyToMany(targetEntity="\App\Entity\Typed\Trigger\BondTrigger", mappedBy="bonds")   */
    protected $triggers;

    /**
     * @ORM\Column(type = "integer")
     *
     **/
    protected $feeCount = 0;

    /**
     * @ORM\Column(type = "integer")
     *
     **/
    protected $triggerCount = 0;

    /**
     * @ORM\Column(type = "integer")
     *
     **/
    protected $shelfSpecificCount = 0;

    /**
     * @ORM\Column(type = "integer")
     *
     **/
    protected $accountCount = 0;

    public function __construct()
    {
        $this->updates = new ArrayCollection();
        $this->components = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getPool()
    {
        return $this->pool;
    }

    /**
     * @param mixed $pool
     */
    public function setPool($pool)
    {
        $this->implementChange($this,'pool', $this->pool, $pool);
    }

    /**
     * @return mixed
     */
    public function getDeal()
    {
        return $this->deal;
    }

    /**
     * @param $deal
     */
    public function setDeal($deal)
    {
        $this->implementChange($this,'deal', $this->deal, $deal);
    }

    /**
     * @return mixed
     */
    public function getCusip()
    {
        return $this->cusip;
    }

    /**
     * @param mixed $cusip
     */
    public function setCusip($cusip)
    {
        $this->implementChange($this,'cusip', $this->cusip, $cusip);
    }

    /**
     * @return mixed
     */
    public function getClassName()
    {
        return $this->className;
    }

    /**
     * @param mixed $className
     */
    public function setClassName($className)
    {
        $this->implementChange($this,'className', $this->className, $className);
    }

    /**
     * @return mixed
     */
    public function getOriginalBalance()
    {
        return $this->originalBalance;
    }

    /**
     * @param mixed $originalBalance
     */
    public function setOriginalBalance($originalBalance)
    {
        $this->implementChange($this,'originalBalance', $this->originalBalance, $originalBalance);
    }

    /**
     * @return mixed
     */
    public function getCurrentBalance()
    {
        return $this->currentBalance;
    }

    /**
     * @param mixed $currentBalance
     */
    public function setCurrentBalance($currentBalance)
    {
        $this->implementChange($this,'currentBalance', $this->currentBalance, $currentBalance);
    }

    /**
     * @return mixed
     */
    public function getRateFormula()
    {
        return $this->rateFormula;
    }

    /**
     * @param mixed $rateFormula
     */
    public function setRateFormula($rateFormula)
    {
        if(is_array($rateFormula))
            $rateFormula = serialize($rateFormula);
        $this->implementChange($this,'rateFormula', $this->rateFormula, $rateFormula);
    }

    /**
     * @return mixed
     */
    public function getScheduledMaturityDate()
    {
        return $this->scheduledMaturityDate;
    }

    /**
     * @param mixed $scheduledMaturityDate
     */
    public function setScheduledMaturityDate($scheduledMaturityDate)
    {
        $this->implementChange($this,'scheduledMaturityDate', $this->scheduledMaturityDate, $scheduledMaturityDate);
    }

    /**
     * @return mixed
     */
    public function getFixedRate()
    {
        return $this->fixedRate;
    }

    /**
     * @param mixed $fixedRate
     */
    public function setFixedRate($fixedRate)
    {
        $this->implementChange($this,'fixedRate', $this->fixedRate, $fixedRate);
    }

    /**
     * @return mixed
     */
    public function getOrigCreditSupport()
    {
        return $this->origCreditSupport;
    }

    /**
     * @param mixed $origCreditSupport
     */
    public function setOrigCreditSupport($origCreditSupport)
    {
        $this->implementChange($this,'origCreditSupport', $this->origCreditSupport, $origCreditSupport);
    }

    /**
     * @return mixed
     */
    public function getCurrCreditSupport()
    {
        return $this->currCreditSupport;
    }

    /**
     * @param mixed $currCreditSupport
     */
    public function setCurrCreditSupport($currCreditSupport)
    {
        $this->implementChange($this,'currCreditSupport', $this->currCreditSupport, $currCreditSupport);
    }

    /**
     * @return mixed
     */
    public function getBasisCount()
    {
        return $this->basisCount;
    }

    /**
     * @param mixed $basisCount
     */
    public function setBasisCount($basisCount)
    {
        $this->implementChange($this,'basisCount', $this->basisCount, $basisCount);
    }

    /**
     * @return mixed
     */
    public function getFloatingIndex()
    {
        return $this->floatingIndex;
    }

    /**
     * @param mixed $floatingIndex
     */
    public function setFloatingIndex($floatingIndex)
    {
        $this->implementChange($this,'floatingIndex', $this->floatingIndex, $floatingIndex);
    }

    /**
     * @return mixed
     */
    public function getIndexMaturity()
    {
        return $this->indexMaturity;
    }

    /**
     * @param mixed $indexMaturity
     */
    public function setIndexMaturity($indexMaturity)
    {
        $this->implementChange($this,'indexMaturity', $this->indexMaturity, $indexMaturity);
    }

    /**
     * @return mixed
     */
    public function getSpreadArray()
    {
        return $this->spreadArray;
    }

    /**
     * @param mixed $spreadArray
     */
    public function setSpreadArray($spreadArray)
    {
        $spread = serialize($spreadArray);
        $this->implementChange($this,'spreadArray', $this->spreadArray, $spread);
    }

    /**
     * @return mixed
     */
    public function getLegalFinal()
    {
        return $this->legalFinal;
    }

    /**
     * @param mixed $legalFinal
     */
    public function setLegalFinal($legalFinal)
    {
        $this->implementChange($this,'legalFinal', $this->legalFinal, $legalFinal);
    }

    /**
     * @return mixed
     */
    public function getIsIoBond()
    {
        return $this->isIoBond;
    }

    /**
     * @param mixed $isIoBond
     */
    public function setIsIoBond($isIoBond)
    {
        $this->implementChange($this,'isIoBond', $this->isIoBond, $isIoBond);
    }

    /**
     * @return mixed
     */
    public function getIsPoBond()
    {
        return $this->isPoBond;
    }

    /**
     * @param mixed $isPoBond
     */
    public function setIsPoBond($isPoBond)
    {
        $this->implementChange($this,'isPoBond', $this->isPoBond, $isPoBond);
    }

    /**
     * @return mixed
     */
    public function getIsComponent()
    {
        return $this->isComponent;
    }

    /**
     * @param mixed $isComponent
     */
    public function setIsComponent($isComponent)
    {
        $this->implementChange($this,'isComponent', $this->isComponent, $isComponent);
    }

    /**
     * @return ArrayCollection
     */
    public function getComponents()
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
    public function getUpdates()
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
     * @return mixed
     */
    public function getUpdateCount()
    {
        return $this->updateCount;
    }

    /**
     * @param mixed $updateCount
     */
    public function setUpdateCount($updateCount)
    {
        $this->implementChange($this,'updateCount', $this->updateCount, $updateCount);
    }

    /**
     * @return BondUpdate
     */
    public function getLatestUpdate()
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
     * @return number
     */
    public function getFeeCount()
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
     * @return number
     */
    public function getTriggerCount()
    {
        return $this->triggerCount;
    }

    /**
     * @param number $triggerCount
     */
    public function setTriggerCount($triggerCount)
    {
        $this->implementChange($this,'triggerCount', $this->triggerCount, $triggerCount);
    }

    /**
     * @return number
     */
    public function getShelfSpecificCount()
    {
        return $this->shelfSpecificCount;
    }

    /**
     * @param number $shelfSpecificCount
     */
    public function setShelfSpecificCount($shelfSpecificCount)
    {
        $this->implementChange($this,'shelfSpecificCount', $this->shelfSpecificCount, $shelfSpecificCount);
    }

    /**
     * @return number
     */
    public function getAccountCount()
    {
        return $this->accountCount;
    }

    /**
     * @param number $accountCount
     */
    public function setAccountCount($accountCount)
    {
        $this->implementChange($this,'accountCount', $this->accountCount, $accountCount);
    }

    /**
     * @return mixed
     */
    public function getMoodysRating()
    {
        return $this->moodysRating;
    }

    /**
     * @param mixed $moodysRating
     */
    public function setMoodysRating($moodysRating)
    {
        $this->implementChange($this,'moodysRating', $this->moodysRating, $moodysRating);
    }

    /**
     * @return mixed
     */
    public function getSpRating()
    {
        return $this->spRating;
    }

    /**
     * @param mixed $spRating
     */
    public function setSpRating($spRating)
    {
        $this->implementChange($this,'spRating', $this->spRating, $spRating);
    }

    /**
     * @return mixed
     */
    public function getFitchRating()
    {
        return $this->fitchRating;
    }

    /**
     * @param mixed $fitchRating
     */
    public function setFitchRating($fitchRating)
    {
        $this->implementChange($this,'fitchRating', $this->fitchRating, $fitchRating);
    }

    /**
     * @return mixed
     */
    public function getDbrsRating()
    {
        return $this->dbrsRating;
    }

    /**
     * @param mixed $dbrsRating
     */
    public function setDbrsRating($dbrsRating)
    {
        $this->implementChange($this,'dbrsRating', $this->dbrsRating, $dbrsRating);
    }
}