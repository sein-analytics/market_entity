<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 */

namespace App\Entity\Typed\ShelfSpecific;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use App\Entity\Loan;
use App\Entity\Typed\ShelfSpecific;
use App\Entity\Typed\TypedInterface;

/**
 * @ORM\Entity
 */
class LoanSpecific extends ShelfSpecific
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     **/
    protected int $id;

    /**
     * @ORM\ManyToMany(targetEntity="\App\Entity\Loan", inversedBy = "specifics")
     */
    protected $loans;

    public function __construct()
    {
        $this->loans = new ArrayCollection();
        parent::__construct();
    }

    /**
     * @return ArrayCollection
     */
    public function getMappedEntities():ArrayCollection
    {
        return $this->loans;
    }

    /**
     * @param TypedInterface $entity
     * @return $this|bool
     */
    public function addAttached(TypedInterface $entity): bool|static
    {
        if(! $entity instanceof Loan){
            return false;
        }
        return $this->addTypedMappedEntity($entity);
    }
}