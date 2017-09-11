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

/**
 * @MappedSuperclass
 * @ORM\Entity
 * @ORM\Table(name="Trigger")
 * @ORM\DiscriminatorColumn(name="triggerClass", type="string")
 * @ORM\DiscriminatorMap({"bond" = "\App\Entity\Typed\Trigger\BondTrigger",
 *                        "pool" = "\App\Entity\Typed\Trigger\PoolTrigger",
 *                        "loan" = "\App\Entity\Typed\Trigger\LoanTrigger"
 * })
 */
abstract class Trigger extends AbstractTyped
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
     * @ORM\ManyToOne(targetEntity="\App\Entity\Deal", inversedBy = "triggers")
     * @var \App\Entity\Deal $deal
     */
    protected $deal;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\Typed\TriggerType", inversedBy="triggers")
     * @var \App\Entity\Typed\TriggerType $triggerType
     */
    protected $type;

    /**
     * @ORM\OneToMany(targetEntity="\App\Entity\Typed\Update\TriggerUpdate", mappedBy="trigger")
     * @var ArrayCollection $triggersUpdate
     */
    protected $updates;

    /**
     * @ORM\OneToOne(targetEntity="\App\Entity\Typed\Update\TriggerUpdate", fetch="EAGER")
     * @var \App\Entity\Typed\Update\TriggerUpdate $latestTriggerUpdate
     */
    protected $latestUpdate = null;

    public function __construct()
    {
        $this->updates = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    /**
     * @return \App\Entity\Deal
     */
    public function getDeal()
    {
        return $this->deal;
    }

    /**
     * @param \App\Entity\Deal $deal
     */
    public function setDeal(Deal $deal)
    {
        $this->deal = $deal;
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
     * @param TriggerUpdate $update
     * @return $this
     * @throws \Exception
     */
    public function addTriggerUpdate(TriggerUpdate $update)
    {
        return $this->addUpdate($update);
    }
}