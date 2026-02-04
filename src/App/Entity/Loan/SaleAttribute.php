<?php


namespace App\Entity\Loan;

use App\Entity\DomainObject;
use App\Entity\Loan;
use App\Entity\MarketUser;
use App\Service\CreatePropertiesArrayTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'SaleAttribute')]
#[ORM\Entity(repositoryClass: \App\Repository\Loan\SaleAttribute::class)]
#[ORM\ChangeTrackingPolicy('NOTIFY')]
class SaleAttribute extends DomainObject
{
    use CreatePropertiesArrayTrait;

    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    protected int $id;

    /**
     * @var Loan
     **/
    #[ORM\JoinColumn(name: 'loan_id', referencedColumnName: 'id', nullable: false)]
    #[ORM\OneToOne(targetEntity:  Loan::class, inversedBy: 'saleAttributes')]
    protected $loan;

    /**
     * @var ArrayCollection
     */
    #[ORM\ManyToMany(targetEntity:  MarketUser::class, inversedBy: 'boughtLoans')]
    protected $buyers;

    /**
     * @var float
     */
    #[ORM\Column(type: 'float', precision: 6, scale: 5, nullable: true)]
    protected float $availability = 1.0;

    public function __construct()
    {
        $this->buyers = new ArrayCollection();
        parent::__construct();
    }

    public function addBuyer(MarketUser $marketUser)
    {
        $this->buyers->add($marketUser);
    }
    /**
     * @return int
     */
    public function getId():int { return $this->id; }

    /**
     * @return Loan
     */
    public function getLoan(): Loan { return $this->loan; }

    /**
     * @return float
     */
    public function getAvailability(): float { return $this->availability; }

    /**
     * @param Loan $loan
     */
    public function setLoan(Loan $loan) { $this->loan = $loan; }

    /**
     * @param float $availability
     */
    public function setAvailability(float $availability) { $this->availability = $availability; }


}