<?php


namespace App\Entity\Loan;

use App\Entity\AnnotationMappings;
use Doctrine\Common\Collections\ArrayCollection;
//use Doctrine\ORM\Mapping as ORM;

/**
 * \Doctrine\ORM\Mapping\Entity
 * \Doctrine\ORM\Mapping\Table(name="AmortAttribute")
 */
class AmortAttribute extends AnnotationMappings
{
    /**
     * \Doctrine\ORM\Mapping\Id
     * \Doctrine\ORM\Mapping\Column(type="integer")
     * \Doctrine\ORM\Mapping\GeneratedValue
     **/
    protected int $id;

    /** \Doctrine\ORM\Mapping\OneToMany(targetEntity="\App\Entity\Loan", mappedBy="amortization")
     * @var ArrayCollection
     **/
    protected $loans;



    /**
     * \Doctrine\ORM\Mapping\Column(type="string", nullable=false) *
     */
    protected string $amortType;

    public function __construct()
    {
        $this->loans = new ArrayCollection();
    }

    /**
     * @return string|null
     */
    public function getAmortType():?string
    {
        return $this->amortType;
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