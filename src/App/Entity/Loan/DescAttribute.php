<?php
namespace App\Entity\Loan;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="DescAttribute")
 */
class DescAttribute
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     **/
    protected int $id;

    /**
     * @ORM\OneToMany(targetEntity="\App\Entity\Loan", mappedBy="description")
     * @var ArrayCollection
     **/
    protected $loans;

    /**
     * @ORM\Column(type="string", nullable=false) *
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