<?php


namespace App\Entity\Loan;

use App\Entity\DomainObject;
use App\Entity\Loan;
use App\Entity\MarketUser;
use App\Service\CreatePropertiesArrayTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="\App\Repository\Loan\SaleAttribute")
 * @ORM\Table(name="SaleAttribute")
 * @ORM\ChangeTrackingPolicy("NOTIFY")
 */
class SaleAttribute extends DomainObject
{
    use CreatePropertiesArrayTrait;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    protected int $id;

    /**
     *  @ORM\OneToOne(targetEntity="\App\Entity\Loan", inversedBy="saleAttributes")
     *  @ORM\JoinColumn(name="loan_id", referencedColumnName="id", nullable=false)
     * @var Loan
     **/
    protected $loan;

    /**
     * @ORM\ManyToMany(targetEntity="\App\Entity\MarketUser", inversedBy="boughtLoans")
     * @var ArrayCollection
     */
    protected $buyers;

    /**
     * @var float
     * @ORM\Column(type="float", precision=6, scale=5, nullable = true)
     */
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