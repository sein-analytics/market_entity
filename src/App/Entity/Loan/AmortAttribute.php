<?php


namespace App\Entity\Loan;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="AmortAttribute")
 */
class AmortAttribute
{
    /**
     * @ORM\Id @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     **/
    protected $id;

    /** @ORM\OneToMany(targetEntity="\App\Entity\Loan", mappedBy="amortization")
     * @var ArrayCollection
     **/
    protected $loans;



    /** @ORM\Column(type="string", nullable=false) **/
    protected $amortType;

    public function __construct()
    {
        $this->loans = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getAmortType()
    {
        return $this->amortType;
    }

    /**
     * @return ArrayCollection
     */
    public function getLoans()
    {
        return $this->loans;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }
}