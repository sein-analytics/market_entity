<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 */

namespace App\Entity\Typed;


use App\Entity\DomainObject;
use App\Entity\Typed\Update\TypedUpdateInterface;
use App\Service\CreatePropertiesArrayTrait;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Period;

 abstract class AbstractTyped extends DomainObject
     implements  TypedInterface
{
    use CreatePropertiesArrayTrait;

    /** @return ArrayCollection */
    abstract public function getMappedEntities(): ArrayCollection;

    const CALC_FIXED   = 1;
    const CALC_FORMULA = 2;

    const CALC_AT_POOL = 0;
    const CALC_AT_BOND = 1;
    const CALC_AT_LOAN = 2;


    /**
     * @var integer
     * @ORM\Column(type="integer") */
    protected int $calculationType = self::CALC_FIXED;

    /**
     * @var integer
     * @ORM\Column(type = "integer") **/
    protected int $calculateAt = self::CALC_AT_LOAN;

    /**
     * @var string|null
     * @ORM\Column(type = "string", nullable=true)  **/
    protected string|null $calculateAtFormula;

    /**
     * @var float|null $fixedAmount
     * @ORM\Column(type = "decimal", precision=14, scale=2, nullable=true) **/
    protected float|null $fixed;

    /**
     * @var string|null $formula
     * @ORM\Column(type = "string", nullable=true)
     **/
    protected string|null $formula;

    /**
     * @ORM\Column(type = "integer", nullable=true)
     *  @var int|null
     **/
    protected int|null $bondsCount = 0;

    /**
     * @ORM\Column(type = "integer", nullable=true)
     *  @var int|null
     **/
    protected int|null $loansCount = 0;

    /**
     * @ORM\Column(type = "integer", nullable=true)
     *  @var int|null
     **/
    protected int|null $poolsCount = 0;

    /**
     * @var int
     * @ORM\Column(type = "integer") **/
    protected int $updatesCount = 0;


    /**
     * @param TypedUpdateInterface $updateInterface
     * @return $this
     * @throws \Exception
     */
    public function addUpdate(TypedUpdateInterface $updateInterface):self
    {
        $period = $updateInterface->getPeriod();
        if(! $period instanceof Period){
            throw new \Exception('Period in updateInterface must be an instance of Entity\Market\Period');
        }
        $this->updateLatestUpdate($updateInterface, $period);
        $coll = $this->getUpdates()->filter(function(TypedUpdateInterface $up) use ($period){
            return $up->getPeriod()->getId() === $period->getId();
        });
        if(!$coll->first()){
            $this->getUpdates()->add($updateInterface);
        }
        return $this;
    }

    protected function updateLatestUpdate(TypedUpdateInterface $update, Period $period):void
    {
        if(is_null($this->getLatestUpdate())
            || ($this->getLatestUpdate()->getPeriod()->getPeriodIndex() < $period->getPeriodIndex() && $period->getIsHistorical() == 1)){
            $this->setLatestUpdate($update);
            $this->updatesCount += 1;
        }
    }

    /**
     * @param TypedInterface $mappedEntity
     * @return $this
     */
    protected function addTypedMappedEntity(TypedInterface $mappedEntity):self
    {
        if($this->getMappedEntities()->count() >0){
            $coll = $this->getMappedEntities()->filter(function (TypedUpdateInterface $bd) use ($mappedEntity) {
                return $bd->getId() === $mappedEntity->getId();
            });
        }else{
            $coll = false;
        }
        if($coll instanceof Collection
            && $coll->first()){
            $this->getMappedEntities()->add($mappedEntity);
            $this->incrementMappedCounter($mappedEntity);
        }
        return $this;
    }

    /**
     * @param TypedInterface $mappedEntity
     */
    protected function incrementMappedCounter(TypedInterface $mappedEntity):void
    {
        $class = get_class($mappedEntity);
        if(is_numeric(stripos($class, 'Bond'))){
            $this->bondsCount++;
        }elseif (is_numeric(stripos($class, 'Pool'))){
            $this->poolsCount++;
        }elseif (is_numeric(stripos($class, 'Loan'))){
            $this->loansCount++;
        }
    }

    /**
     * @return int
     */
    public static function fixedCalcConstant():int {
        return self::CALC_FIXED;
    }

    /**
     * @return int
     */
    public static function formulaCalcConstant(): int {
        return self::CALC_FORMULA;
    }

    /**
     * @return int
     */
    public static function poolCalcConstant():int {
        return self::CALC_AT_POOL;
    }

    /**
     * @return int
     */
    public static function bondCalcConstant():int {
        return self::CALC_AT_BOND;
    }

    /**
     * @return int
     */
    public static function loanCalcConstant():int {
        return self::CALC_AT_LOAN;
    }

    /**
     * @return int
     */
    public function getCalculationType():int
    {
        return $this->calculationType;
    }

    /**
     * @return int
     */
    public function getId():int
    {
        return $this->id;
    }


    /**
     * @param $calculationType
     * @throws \Exception
     */
    public function setCalculationType($calculationType)
    {
        $case = strtoupper($calculationType);
        $constant = @constant("self::CALC_{$case}");
        if(is_null($constant)){
            throw new \Exception("Could not find constant: self::CALC_{$calculationType} in AbstractType");
        }
        $this->implementChange($this,'calculationType', $this->calculationType, $constant);
    }

    /**
     * @return null|string
     */
    public function getCalculateAt():?string
    {
        return $this->calculateAt;
    }

    /**
     * @param $calculateAt
     * @throws \Exception
     */
    public function setCalculateAt($calculateAt):void
    {
        $case = strtoupper($calculateAt);
        $constant = @constant("self::CALC_AT_{$case}");
        if(is_null($constant)){
            throw new \Exception("Could not find constant: self::CALC_AT_{$calculateAt} AbstractType");
        }
        $this->implementChange($this,'calculateAt', $this->calculateAt, $constant);
    }

     /**
      * @return string|null
      */
    public function getCalculateAtFormula():?string
    {
        return $this->calculateAtFormula;
    }

    /**
     * @param mixed $calculateAtFormula
     */
    public function setCalculateAtFormula(mixed $calculateAtFormula):void
    {
        $this->calculateAtFormula = $calculateAtFormula;
    }

    /**
     * @return int
     */
    public function getBondsCount():int
    {
        return $this->bondsCount;
    }

     /**
      * @return float|null
      */
    public function getFixed():?float
    {
        return $this->fixed;
    }

    /**
     * @param float $fixed
     */
    public function setFixed(float $fixed)
    {
        $this->implementChange($this,'fixed', $this->fixed, $fixed);
    }

     /**
      * @return string|null
      */
    public function getFormula():?string
    {
        return $this->formula;
    }

    /**
     * @param string|array $formula
     */
    public function setFormula($formula):void
    {
        if(is_array($formula)){
            $formula = serialize($formula);
        }
        $this->implementChange($this,'formula', $this->formula, $formula);
    }

    /**
     * @param int $bondsCount
     */
    public function setBondsCount(int $bondsCount):void
    {
        $this->bondsCount = $bondsCount;
    }

    /**
     * @return int
     */
    public function getLoansCount():int
    {
        return $this->loansCount;
    }

    /**
     * @param int $loansCount
     */
    public function setLoansCount(int $loansCount):void
    {
        $this->implementChange($this,'loansCount', $this->loansCount, $loansCount);
    }

     /**
      * @return int|null
      */
    public function getPoolsCount():?int
    {
        return $this->poolsCount;
    }

    /**
     * @param int $poolsCount
     */
    public function setPoolsCount(int $poolsCount)
    {
        $this->implementChange($this,'poolsCount', $this->poolsCount, $poolsCount);
    }

    /**
     * @return int
     */
    public function getUpdatesCount():int
    {
        return $this->updatesCount;
    }

    /**
     * @param int $updatesCount
     */
    public function setUpdatesCount(int $updatesCount):void
    {
        $this->implementChange($this,'updatesCount', $this->updatesCount, $updatesCount);
    }

}