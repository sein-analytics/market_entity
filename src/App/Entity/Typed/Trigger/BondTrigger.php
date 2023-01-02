<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 */

namespace App\Entity\Typed\Trigger;

use App\Entity\Typed\Triggers;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use App\Entity\Bond;
use App\Entity\Typed\ShelfSpecific;
use App\Entity\Typed\TypedInterface;

/**
 * @ORM\Entity
 */
class BondTrigger extends Triggers
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     **/
    protected int $id;

    /**
     * @ORM\ManyToMany(targetEntity="\App\Entity\Bond", inversedBy = "triggers")
     */
    protected $bonds;

    public function __construct()
    {
        $this->bonds = new ArrayCollection();
        parent::__construct();
    }

    /**
     * @return ArrayCollection
     */
    public function getMappedEntities():ArrayCollection
    {
        return $this->bonds;
    }

    /**
     * @param TypedInterface $entity
     * @return $this|bool
     */
    public function addAttached(TypedInterface $entity): bool|static
    {
        if(! $entity instanceof Bond){
            return false;
        }
        return $this->addTypedMappedEntity($entity);
    }
}