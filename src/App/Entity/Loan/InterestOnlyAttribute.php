<?php

namespace App\Entity\Loan;

use DateTime;
use App\Entity\DomainObject;
use App\Entity\Loan;
use App\Service\CreatePropertiesArrayTrait;
 
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'InterestOnlyAttribute')]
#[ORM\Entity(repositoryClass: \App\Repository\Loan\InterestOnlyAttribute::class)]
 
class InterestOnlyAttribute extends DomainObject
{
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
    #[ORM\OneToOne(targetEntity:  Loan::class, inversedBy: 'interestOnlyAttribute')]
    protected $loan;

    #[ORM\Column(type: 'integer', nullable: true)]
    protected int|null $interestOnlyTerm;

    /**
     * @var ?string
     */
    #[ORM\Column(type: 'string', nullable: true)]
    protected ?string $interestOnlyIndicator;

    /**
     * @var ?float
     */
    #[ORM\Column(type: 'float', precision: 16, scale: 3, nullable: true)]
    protected ?float $interestOnlyPayment;

    #[ORM\Column(type: 'datetime', nullable: true)]
    protected DateTime|null $interestOnlyStartDate;

    #[ORM\Column(type: 'datetime', nullable: true)]
    protected DateTime|null $interestOnlyExpirationDate;

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
     * @return int|null
     */
    public function getInterestOnlyTerm(): ?int
    {
        return $this->interestOnlyTerm;
    }

    /**
     * @param int|null $interestOnlyTerm
     * @return void
     */
    public function setInterestOnlyTerm(?int $interestOnlyTerm): void
    {
        $this->interestOnlyTerm = $interestOnlyTerm;
    }

    /**
     * @return string|null
     */
    public function getInterestOnlyIndicator(): ?string
    {
        return $this->interestOnlyIndicator;
    }

    /**
     * @param string|null $interestOnlyIndicator
     * @return void
     */
    public function setInterestOnlyIndicator(?string $interestOnlyIndicator): void
    {
        $this->interestOnlyIndicator = $interestOnlyIndicator;
    }

    /**
     * @return float|null
     */
    public function getInterestOnlyPayment(): ?float
    {
        return $this->interestOnlyPayment;
    }

    /**
     * @param float|null $interestOnlyPayment
     * @return void
     */
    public function setInterestOnlyPayment(?float $interestOnlyPayment): void
    {
        $this->interestOnlyPayment = $interestOnlyPayment;
    }

    /**
     * @return DateTime|null
     */
    public function getInterestOnlyStartDate(): ?DateTime
    {
        return $this->interestOnlyStartDate;
    }

    /**
     * @param DateTime|null $interestOnlyStartDate
     * @return void
     */
    public function setInterestOnlyStartDate(?DateTime $interestOnlyStartDate): void
    {
        $this->interestOnlyStartDate = $interestOnlyStartDate;
    }

    /**
     * @return DateTime|null
     */
    public function getInterestOnlyExpirationDate(): ?DateTime
    {
        return $this->interestOnlyExpirationDate;
    }

    /**
     * @param DateTime|null $interestOnlyExpirationDate
     * @return void
     */
    public function setInterestOnlyExpirationDate(?DateTime $interestOnlyExpirationDate): void
    {
        $this->interestOnlyExpirationDate = $interestOnlyExpirationDate;
    }


}