<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 */

namespace App\Entity\Typed\ShelfSpecific;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use App\Entity\Bond;
use App\Entity\Typed\ShelfSpecific;
use App\Entity\Typed\TypedInterface;

/**
 * @ORM\Entity
 */
class BondSpecific extends ShelfSpecific
{
    /**
     * @ORM\Id @ORM\Column(type="integer")
     * @ORM\GeneratedValue **/
    protected $id;
    
    /**
     * @ORM\ManyToMany(targetEntity="\App\Entity\Bond", inversedBy = "specifics")
     * 
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
    public function getMappedEntities()
    {
        return $this->bonds;
    }

    /**
     * @param TypedInterface $entity
     * @return $this|bool
     */
    public function addAttached(TypedInterface $entity) {
        if(! $entity instanceof Bond){
            return false;
        }
        return $this->addTypedMappedEntity($entity);
    }
}