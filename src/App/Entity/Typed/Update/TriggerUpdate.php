<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 * Date: 6/15/16
 * Time: 1:49 PM
 */

namespace App\Entity\Typed\Update;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\Period;
use App\Entity\Typed\Triggers;
use Doctrine\ORM\Mapping\ChangeTrackingPolicy;
/**
 *
 * @ORM\Entity
 * @ORM\Table(name="TriggerUpdate")
 * @ORM\ChangeTrackingPolicy("NOTIFY")
 */
class TriggerUpdate extends AbstractTypeUpdate
{
    const TRIGGER_RESULT_PASS = 1;
    const TRIGGER_RESULT_FAIL = 0;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue *
     */
    protected int $id;

    /**
     * @var Triggers $trigger
     * @ORM\ManyToOne(targetEntity="\App\Entity\Typed\Triggers", inversedBy="updates")
     **/
    protected $trigger;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\Period", inversedBy="triggers")
     * @var Period
     **/
    protected $period;

    /**
     * @var float $threshold
     * @ORM\Column(type="decimal", precision=14, scale=3)
     */
    public float $threshold = 0;

    /**
     * @var float $actual
     * @ORM\Column(type="decimal", precision=14, scale=3)
     */
    public float $actual = 0;

    /**
     * @ORM\Column(type="string")
     * @var int $triggerResult
     */
    public int $triggerResult = self::TRIGGER_RESULT_PASS;

    public function getId():int
    {
        return $this->id;
    }

    /**
     * @return Triggers
     */
    public function getTrigger():Triggers {
        return $this->trigger;
    }

    /**
     * @return Period
     */
    public function getPeriod():Period {
        return $this->period;
    }

    /**
     * @param Period $period
     */
    public function setPeriod(Period $period):void {
        $this->implementChange($this,'period', $this->period, $period);
    }

    /**
     * @return float $threshold
     */
    public function getThreshold():float {
        return $this->threshold;
    }

    /**
     * @return float $actual
     */
    public function getActual():float {
        return $this->actual;
    }

    /**
     * @return int $triggerResult
     */
    public function getTriggerResult():int {
        return $this->triggerResult;
    }

    /**
     * @param Triggers $trigger
     */
    public function setTrigger(Triggers $trigger):void {
        $this->implementChange($this,'trigger', $this->trigger, $trigger);
    }

    /**
     * @param float $threshold
     */
    public function setThreshold(float $threshold):void {
        $this->implementChange($this,'threshold', $this->threshold, $threshold);
    }

    /**
     * @param float $actual
     */
    public function setActual(float $actual):void {
        $this->implementChange($this,'actual', $this->actual, $actual);
    }

    /**
     * @param $triggerResult
     * @throws \Exception
     */
    public function setTriggerResult($triggerResult) {
        $constant = @constant("self::TRIGGER_RESULT{$triggerResult}");
        if(is_null($constant)){
            throw new \Exception("Could not find constant: self::TRIGGER_RESULT{$triggerResult} in TriggerUpdate");
        }
        $this->implementChange($this,'triggerResult', $this->triggerResult, $constant);
    }

}