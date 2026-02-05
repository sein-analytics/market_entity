<?php

namespace App\Entity\Loan;

use App\Entity\DomainObject;
use App\Entity\Loan;
use App\Service\CreatePropertiesArrayTrait;
 
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'EscrowAttribute')]
#[ORM\Entity(repositoryClass: \App\Repository\Loan\EscrowAttribute::class)]
 
class EscrowAttribute extends DomainObject
{
    use CreatePropertiesArrayTrait;

    /**
     * @var int
     */
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    protected int $id;

    /**
     * @var Loan
     */
    #[ORM\JoinColumn(name: 'loan_id', referencedColumnName: 'id', nullable: false)]
    #[ORM\OneToOne(targetEntity:  Loan::class, inversedBy: 'escrowAttribute')]
    protected $loan;

    /**
     * @var DelinquentAttribute
     */
    #[ORM\JoinColumn(name: 'delinquent_attribute_id', referencedColumnName: 'id', nullable: false)]
    #[ORM\OneToOne(targetEntity:  DelinquentAttribute::class, inversedBy: 'escrowAttribute')]
    protected $delinquentAttribute;

    /**
     * @var ?float
     */
    #[ORM\Column(type: 'float', precision: 16, scale: 3, nullable: true)]
    protected ?float $totalDebtBalance;

    /**
     * @var ?float
     */
    #[ORM\Column(type: 'float', precision: 16, scale: 3, nullable: true)]
    protected ?float $accruedLateFees;

    /**
     * @var ?float
     */
    #[ORM\Column(type: 'float', precision: 16, scale: 3, nullable: true)]
    protected ?float $escrowBalance;

    /**
     * @var ?float
     */
    #[ORM\Column(type: 'float', precision: 16, scale: 3, nullable: true)]
    protected ?float $restrictedEscrow;

    /**
     * @var ?float
     */
    #[ORM\Column(type: 'float', precision: 16, scale: 3, nullable: true)]
    protected ?float $escrowAdvanceBalance;

    /**
     * @var ?float
     */
    #[ORM\Column(type: 'float', precision: 16, scale: 3, nullable: true)]
    protected ?float $corpAdvanceBalance;

    /**
     * @var ?float
     */
    #[ORM\Column(type: 'float', precision: 16, scale: 3, nullable: true)]
    protected ?float $thirdPartyBalance;

    /**
     * @var ?float
     */
    #[ORM\Column(type: 'float', precision: 16, scale: 3, nullable: true)]
    protected ?float $accruedBalance;

    /**
     * @var ?float
     */
    #[ORM\Column(type: 'float', precision: 16, scale: 3, nullable: true)]
    protected ?float $taxAndInsurancePayment;

    /**
     * @var ?float
     */
    #[ORM\Column(type: 'float', precision: 16, scale: 3, nullable: true)]
    protected ?float $totalPiti;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return Loan
     */
    public function getLoan(): Loan
    {
        return $this->loan;
    }

    /**
     * @param Loan $loan
     * @return void
     */
    public function setLoan(Loan $loan): void
    {
        $this->loan = $loan;
    }

    /**
     * @return DelinquentAttribute
     */
    public function getDelinquentAttribute(): DelinquentAttribute
    {
        return $this->delinquentAttribute;
    }

    /**
     * @param DelinquentAttribute $delinquentAttribute
     * @return void
     */
    public function setDelinquentAttribute(DelinquentAttribute $delinquentAttribute): void
    {
        $this->delinquentAttribute = $delinquentAttribute;
    }

    /**
     * @return float|null
     */
    public function getTotalDebtBalance(): ?float
    {
        return $this->totalDebtBalance;
    }

    /**
     * @param float|null $totalDebtBalance
     * @return void
     */
    public function setTotalDebtBalance(?float $totalDebtBalance): void
    {
        $this->totalDebtBalance = $totalDebtBalance;
    }

    /**
     * @return float|null
     */
    public function getAccruedLateFees(): ?float
    {
        return $this->accruedLateFees;
    }

    /**
     * @param float|null $accruedLateFees
     * @return void
     */
    public function setAccruedLateFees(?float $accruedLateFees): void
    {
        $this->accruedLateFees = $accruedLateFees;
    }

    /**
     * @return float|null
     */
    public function getEscrowBalance(): ?float
    {
        return $this->escrowBalance;
    }

    /**
     * @param float|null $escrowBalance
     * @return void
     */
    public function setEscrowBalance(?float $escrowBalance): void
    {
        $this->escrowBalance = $escrowBalance;
    }

    /**
     * @return float|null
     */
    public function getRestrictedEscrow(): ?float
    {
        return $this->restrictedEscrow;
    }

    /**
     * @param float|null $restrictedEscrow
     * @return void
     */
    public function setRestrictedEscrow(?float $restrictedEscrow): void
    {
        $this->restrictedEscrow = $restrictedEscrow;
    }

    /**
     * @return float|null
     */
    public function getEscrowAdvanceBalance(): ?float
    {
        return $this->escrowAdvanceBalance;
    }

    /**
     * @param float|null $escrowAdvanceBalance
     * @return void
     */
    public function setEscrowAdvanceBalance(?float $escrowAdvanceBalance): void
    {
        $this->escrowAdvanceBalance = $escrowAdvanceBalance;
    }

    /**
     * @return float|null
     */
    public function getCorpAdvanceBalance(): ?float
    {
        return $this->corpAdvanceBalance;
    }

    /**
     * @param float|null $corpAdvanceBalance
     * @return void
     */
    public function setCorpAdvanceBalance(?float $corpAdvanceBalance): void
    {
        $this->corpAdvanceBalance = $corpAdvanceBalance;
    }

    /**
     * @return float|null
     */
    public function getThirdPartyBalance(): ?float
    {
        return $this->thirdPartyBalance;
    }

    /**
     * @param float|null $thirdPartyBalance
     * @return void
     */
    public function setThirdPartyBalance(?float $thirdPartyBalance): void
    {
        $this->thirdPartyBalance = $thirdPartyBalance;
    }

    /**
     * @return float|null
     */
    public function getAccruedBalance(): ?float
    {
        return $this->accruedBalance;
    }

    /**
     * @param float|null $accruedBalance
     * @return void
     */
    public function setAccruedBalance(?float $accruedBalance): void
    {
        $this->accruedBalance = $accruedBalance;
    }

    /**
     * @return float|null
     */
    public function getTaxAndInsurancePayment(): ?float
    {
        return $this->taxAndInsurancePayment;
    }

    /**
     * @param float|null $taxAndInsurancePayment
     * @return void
     */
    public function setTaxAndInsurancePayment(?float $taxAndInsurancePayment): void
    {
        $this->taxAndInsurancePayment = $taxAndInsurancePayment;
    }

    public function getTotalPiti(): ?float
    {
        return $this->totalPiti;
    }

    public function setTotalPiti(?float $totalPiti): void
    {
        $this->totalPiti = $totalPiti;
    }

}