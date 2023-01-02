<?php


namespace App\Entity\Loan;

use App\Entity\DomainObject;
use App\Entity\Loan;
use App\Entity\MarketUser;
use App\Service\CreatePropertiesArrayTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping\ChangeTrackingPolicy;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\OneToOne;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\ManyToMany;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\JoinColumns;
use Doctrine\ORM\Mapping\JoinTable;
use Doctrine\ORM\Mapping\GeneratedValue;

/**
 * \Doctrine\ORM\Mapping\Entity(repositoryClass="\App\Repository\Loan\SaleAttribute")
 * \Doctrine\ORM\Mapping\Table(name="SaleAttribute")
 * \Doctrine\ORM\Mapping\ChangeTrackingPolicy("NOTIFY")
 */
class SaleAttribute extends DomainObject
{
    use CreatePropertiesArrayTrait;

    /**
     * \Doctrine\ORM\Mapping\Id
     * \Doctrine\ORM\Mapping\Column(type="integer")
     * \Doctrine\ORM\Mapping\GeneratedValue
     */
    protected int $id;

    /**
     *  \Doctrine\ORM\Mapping\OneToOne(targetEntity="\App\Entity\Loan", inversedBy="saleAttributes")
     *  \Doctrine\ORM\Mapping\JoinColumn(name="loan_id", referencedColumnName="id", nullable=false)
     * @var Loan
     **/
    protected $loan;

    /**
     * \Doctrine\ORM\Mapping\ManyToMany(targetEntity="\App\Entity\MarketUser", inversedBy="boughtLoans")
     * @var ArrayCollection
     */
    protected $buyers;

    /**
     * @var float
     * \Doctrine\ORM\Mapping\Column(type="decimal", precision=6, scale=5, nullable = true)
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