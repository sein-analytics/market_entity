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
    abstract public function getMappedEntities();

    const CALC_FIXED   = 1;
    const CALC_FORMULA = 2;

    const CALC_AT_POOL = 0;
    const CALC_AT_BOND = 1;
    const CALC_AT_LOAN = 2;


    /**
     * @var integer
     * @ORM\Column(type="integer") */
    protected $calculationType = self::CALC_FIXED;

    /**
     * @var integer
     * @ORM\Column(type = "integer") **/
    protected $calculateAt = self::CALC_AT_LOAN;

    /**
     * @var string|null
     * @ORM\Column(type = "string", nullable=true)  **/
    protected $calculateAtFormula;

    /**
     * @var double|null $fixedAmount
     * @ORM\Column(type = "decimal", precision=14, scale=2, nullable=true) **/
    protected $fixed;

    /**
     * @var string|null $formula
     * @ORM\Column(type = "string", nullable=true) **/
    protected $formula;

    /** @ORM\Column(type = "integer", nullable=true)
     *  @var integer|null
     **/
    protected $bondsCount = 0;

    /** @ORM\Column(type = "integer", nullable=true)
     *  @var integer|null
     **/
    protected $loansCount = 0;

    /** @ORM\Column(type = "integer", nullable=true)
     *  @var integer|null
     **/
    protected $poolsCount = 0;

    /**
     * @var integer
     * @ORM\Column(type = "integer") **/
    protected $updatesCount = 0;


    /**
     * @param TypedUpdateInterface $updateInterface
     * @return $this
     * @throws \Exception
     */
    public function addUpdate(TypedUpdateInterface $updateInterface)
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

    protected function updateLatestUpdate(TypedUpdateInterface $update, Period $period)
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
    protected function addTypedMappedEntity(TypedInterface $mappedEntity)
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
    protected function incrementMappedCounter(TypedInterface $mappedEntity)
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
    public static function fixedCalcConstant(){
        return self::CALC_FIXED;
    }

    /**
     * @return int
     */
    public static function formulaCalcConstant(){
        return self::CALC_FORMULA;
    }

    /**
     * @return int
     */
    public static function poolCalcConstant(){
        return self::CALC_AT_POOL;
    }

    /**
     * @return int
     */
    public static function bondCalcConstant(){
        return self::CALC_AT_BOND;
    }

    /**
     * @return int
     */
    public static function loanCalcConstant(){
        return self::CALC_AT_LOAN;
    }

    /**
     * @return int
     */
    public function getCalculationType()
    {
        return $this->calculationType;
    }

    /**
     * @return int
     */
    public function getId()
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
    public function getCalculateAt()
    {
        return $this->calculateAt;
    }

    /**
     * @param $calculateAt
     * @throws \Exception
     */
    public function setCalculateAt($calculateAt)
    {
        $case = strtoupper($calculateAt);
        $constant = @constant("self::CALC_AT_{$case}");
        if(is_null($constant)){
            throw new \Exception("Could not find constant: self::CALC_AT_{$calculateAt} AbstractType");
        }
        $this->implementChange($this,'calculateAt', $this->calculateAt, $constant);
    }

    /**
     * @return mixed
     */
    public function getCalculateAtFormula()
    {
        return $this->calculateAtFormula;
    }

    /**
     * @param mixed $calculateAtFormula
     */
    public function setCalculateAtFormula($calculateAtFormula)
    {
        $this->calculateAtFormula = $calculateAtFormula;
    }

    /**
     * @return int
     */
    public function getBondsCount()
    {
        return $this->bondsCount;
    }

    /**
     * @return float
     */
    public function getFixed()
    {
        return $this->fixed;
    }

    /**
     * @param float $fixed
     */
    public function setFixed($fixed)
    {
        $this->implementChange($this,'fixed', $this->fixed, $fixed);
    }

    /**
     * @return string
     */
    public function getFormula()
    {
        return $this->formula;
    }

    /**
     * @param string|array $formula
     */
    public function setFormula($formula)
    {
        if(is_array($formula)){
            $formula = serialize($formula);
        }
        $this->implementChange($this,'formula', $this->formula, $formula);
    }

    /**
     * @param int $bondsCount
     */
    public function setBondsCount($bondsCount)
    {
        $this->bondsCount = $bondsCount;
    }

    /**
     * @return int
     */
    public function getLoansCount()
    {
        return $this->loansCount;
    }

    /**
     * @param int $loansCount
     */
    public function setLoansCount($loansCount)
    {
        $this->implementChange($this,'loansCount', $this->loansCount, $loansCount);
    }

    /**
     * @return int
     */
    public function getPoolsCount()
    {
        return $this->poolsCount;
    }

    /**
     * @param int $poolsCount
     */
    public function setPoolsCount($poolsCount)
    {
        $this->implementChange($this,'poolsCount', $this->poolsCount, $poolsCount);
    }

    /**
     * @return int
     */
    public function getUpdatesCount()
    {
        return $this->updatesCount;
    }

    /**
     * @param int $updatesCount
     */
    public function setUpdatesCount($updatesCount)
    {
        $this->implementChange($this,'updatesCount', $this->updatesCount, $updatesCount);
    }


}