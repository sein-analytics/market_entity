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
use App\Entity\Typed\Trigger;
use Doctrine\ORM\Mapping\ChangeTrackingPolicy;
/**
 *
 * @ORM\Entity
 * @ORM\Table(name="TriggerUpdate")
 * @ChangeTrackingPolicy("NOTIFY")
 */
class TriggerUpdate extends AbstractTypeUpdate
{
    const TRIGGER_RESULT_PASS = 1;
    const TRIGGER_RESULT_FAIL = 0;

    /** @ORM\Id @ORM\Column(type="integer") @ORM\GeneratedValue **/
    protected $id;

    /**
     * @var \App\Entity\Typed\Trigger $trigger
     * @ORM\ManyToOne(targetEntity="\App\Entity\Typed\Trigger", inversedBy="updates") **/
    protected $trigger;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\Period", inversedBy="triggers")
     * @var \App\Entity\Period
     **/
    protected $period;

    /**
     * @ORM\Column(type="decimal", precision=14, scale=3)
     *
     */
    public $threshold = 0;

    /**
     * @ORM\Column(type="decimal", precision=14, scale=3)
     *
     */
    public $actual = 0;

    /**
     * @ORM\Column(type="string")
     * @var string $triggerResult
     */
    public $triggerResult = self::TRIGGER_RESULT_PASS;

    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Trigger
     */
    public function getTrigger() {
        return $this->trigger;
    }

    public function getPeriod() {
        return $this->period;
    }

    /**
     * @param Period $period
     */
    public function setPeriod(Period $period) {
        $this->implementChange($this,'period', $this->period, $period);
    }

    /**
     * @return number $threshold
     */
    public function getThreshold() {
        return $this->threshold;
    }

    /**
     * @return number $actual
     */
    public function getActual() {
        return $this->actual;
    }

    /**
     * @return int $triggerResult
     */
    public function getTriggerResult() {
        return $this->triggerResult;
    }

    /**
     * @param Trigger $trigger
     */
    public function setTrigger(Trigger $trigger) {
        $this->implementChange($this,'trigger', $this->trigger, $trigger);
    }

    /**
     * @param number $threshold
     */
    public function setThreshold($threshold) {
        $this->implementChange($this,'threshold', $this->threshold, $threshold);
    }

    /**
     * @param number $actual
     */
    public function setActual($actual) {
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