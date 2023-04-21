<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 * Date: 6/22/16
 * Time: 5:59 PM
 */

namespace App\Entity\Typed;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping\MappedSuperclass;
use App\Entity\Deal;
use App\Entity\Typed\Update\TriggerUpdate;
use App\Entity\Typed\Update\TypedUpdateInterface;
use Illuminate\Support\Arr;

/**
 * @ORM\MappedSuperclass
 * @ORM\Entity
 * @ORM\Table(name="Triggers")
 * @ORM\DiscriminatorColumn(name="triggerClass", type="string")
 * @ORM\DiscriminatorMap({"bond" = "\App\Entity\Typed\Trigger\BondTrigger",
 *                        "pool" = "\App\Entity\Typed\Trigger\PoolTrigger",
 *                        "loan" = "\App\Entity\Typed\Trigger\LoanTrigger"
 * })
 */
abstract class Triggers extends AbstractTyped
{
    abstract public function addAttached(TypedInterface $entity);

    /**
     * @var integer $id
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue *
     */
    protected int $id;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\Deal", inversedBy = "triggers")
     * @var Deal $deal
     */
    protected $deal;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\Typed\TriggerType", inversedBy="triggers")
     * @var TriggerType $triggerType
     */
    protected $type;

    /**
     * @ORM\OneToMany(targetEntity="\App\Entity\Typed\Update\TriggerUpdate", mappedBy="trigger")
     * @var ArrayCollection $triggersUpdate
     */
    protected $updates;

    /**
     * @ORM\OneToOne(targetEntity="\App\Entity\Typed\Update\TriggerUpdate", fetch="EAGER")
     * @var TriggerUpdate $latestTriggerUpdate
     */
    protected $latestUpdate = null;

    public function __construct()
    {
        $this->updates = new ArrayCollection();
        parent::__construct();
    }

    public function getId():int
    {
        return $this->id;
    }

    /**
     * @return Deal|null
     */
    public function getDeal():?Deal
    {
        return $this->deal;
    }

    /**
     * @param Deal $deal
     */
    public function setDeal(Deal $deal):void
    {
        $this->deal = $deal;
    }

    /**
     * @return DefineTypeInterface|TriggerType
     */
    public function getType(): DefineTypeInterface|TriggerType
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
     * @return TypedUpdateInterface|TriggerUpdate|null
     */
    public function getLatestUpdate(): TypedUpdateInterface|TriggerUpdate|null
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
     * @param TriggerUpdate $update
     * @return $this
     * @throws \Exception
     */
    public function addTriggerUpdate(TriggerUpdate $update): static
    {
        return $this->addUpdate($update);
    }
}