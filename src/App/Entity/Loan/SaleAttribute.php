<?php


namespace App\Entity\Loan;

use App\Entity\Loan;
use App\Entity\NotifyChangeTrait;
use App\Service\CreatePropertiesArrayTrait;
use Doctrine\Common\NotifyPropertyChanged;

/**
 * @ORM\Entity(repositoryClass="\App\Repository\Loan\Salettribute")
 * @ORM\Table(name="SaleAttribute")
 * @ChangeTrackingPolicy("NOTIFY")
 */
class SaleAttribute implements NotifyPropertyChanged
{
    use NotifyChangeTrait, CreatePropertiesArrayTrait;

    /** @ORM\Id @ORM\Column(type="integer") @ORM\GeneratedValue **/
    protected $id;

    /**
     * @ORM\OneToOne(targetEntity="\App\Entity\Loan", inversedBy="saleAttributes")
     * @ORM\JoinColumn(name="loan_id", referencedColumnName="id", nullable=false)
     * @var \App\Entity\Loan
     **/
    protected $loan;

    /** @var float  */
    protected $availability = 1.0;

    /**
     * @return int|null
     */
    public function getId() { return $this->id; }

    /**
     * @return \App\Entity\Loan
     */
    public function getLoan(): Loan { return $this->loan; }

    /**
     * @return float
     */
    public function getAvailability(): float { return $this->availability; }

    /**
     * @param \App\Entity\Loan $loan
     */
    public function setLoan(Loan $loan) { $this->loan = $loan; }

    /**
     * @param float $availability
     */
    public function setAvailability(float $availability) { $this->availability = $availability; }


}