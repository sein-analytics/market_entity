<?php
namespace App\Entity\Loan;

use App\Entity\AnnotationMappings;
use Doctrine\Common\Collections\ArrayCollection;
//use Doctrine\ORM\Mapping as ORM;

/**
 * \Doctrine\ORM\Mapping\Entity
 * \Doctrine\ORM\Mapping\Table(name="DescAttribute")
 */
class DescAttribute extends AnnotationMappings
{
    /**
     * \Doctrine\ORM\Mapping\Id @ORM\Column(type="integer")
     * \Doctrine\ORM\Mapping\GeneratedValue
     **/
    protected int $id;

    /**
     * \Doctrine\ORM\Mapping\OneToMany(targetEntity="\App\Entity\Loan", mappedBy="description")
     * @var ArrayCollection
     **/
    protected $loans;

    /**
     * \Doctrine\ORM\Mapping\Column(type="string", nullable=false) *
     */
    protected string|null $descType;

    public function __construct()
    {
        $this->loans = new ArrayCollection();
    }

    /**
     * @return string|null
     */
    public function getDescType():?string
    {
        return $this->descType;
    }

    /**
     * @return ArrayCollection
     */
    public function getLoans():ArrayCollection
    {
        return $this->loans;
    }

    /**
     * @return int
     */
    public function getId():int
    {
        return $this->id;
    }
}