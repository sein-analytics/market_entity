<?php


namespace App\Entity\Loan;

use \App\Entity\Loan;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'AmortAttribute')]
#[ORM\Entity]
class AmortAttribute
{
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    protected int $id;

    /**
     * @var ArrayCollection
     **/
    #[ORM\OneToMany(targetEntity: Loan::class, mappedBy: 'amortization')]
    protected $loans;



    #[ORM\Column(type: 'string', nullable: false)]
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