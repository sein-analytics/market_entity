<?php
namespace App\Entity\Loan;

use \App\Entity\Loan;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'DescAttribute')]
#[ORM\Entity]
class DescAttribute
{
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    protected int $id;

    /**
     * @var ArrayCollection
     **/
    #[ORM\OneToMany(targetEntity: Loan::class, mappedBy: 'description')]
    protected $loans;

    #[ORM\Column(type: 'string', nullable: false)]
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