<?php

namespace App\Entity\Loan;

use App\Entity\DomainObject;
use App\Entity\Loan;
use App\Service\CreatePropertiesArrayTrait;
use Doctrine\ORM\Mapping\ChangeTrackingPolicy;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="\App\Repository\Loan\InterestOnlyAttribute")
 * @ORM\Table(name="InterestOnlyAttribute")
 * @ORM\ChangeTrackingPolicy("NOTIFY")
 */
class InterestOnlyAttribute extends DomainObject
{
    /**
     * @ORM\Id
     * @ORM\Column (type="integer")
     * @ORM\GeneratedValue
     * @var int
     */
    protected int $id;

    /**
     * @ORM\OneToOne(targetEntity="\App\Entity\Loan", inversedBy="interestOnlyAttribute")
     * @ORM\JoinColumn(name="loan_id", referencedColumnName="id", nullable=false)
     * @var Loan
     */
    protected $loan;

    /**
     * @ORM\Column(type = "integer", nullable=true)
     */
    protected int|null $interestOnlyTerm;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var ?string
     */
    protected ?string $interestOnlyIndicator;

    /**
     * @ORM\Column (type="float", precision=16, scale=3, nullable=true)
     * @var ?float
     */
    protected ?float $interestOnlyPayment;

    /**
     * @ORM\Column(type = "datetime", nullable=true)
     */
    protected \DateTime|null $interestOnlyStartDate;

    /**
     * @ORM\Column(type = "datetime", nullable=true)
     */
    protected \DateTime|null $interestOnlyExpirationDate;

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
     * @return \DateTime|null
     */
    public function getInterestOnlyStartDate(): ?\DateTime
    {
        return $this->interestOnlyStartDate;
    }

    /**
     * @param \DateTime|null $interestOnlyStartDate
     * @return void
     */
    public function setInterestOnlyStartDate(?\DateTime $interestOnlyStartDate): void
    {
        $this->interestOnlyStartDate = $interestOnlyStartDate;
    }

    /**
     * @return \DateTime|null
     */
    public function getInterestOnlyExpirationDate(): ?\DateTime
    {
        return $this->interestOnlyExpirationDate;
    }

    /**
     * @param \DateTime|null $interestOnlyExpirationDate
     * @return void
     */
    public function setInterestOnlyExpirationDate(?\DateTime $interestOnlyExpirationDate): void
    {
        $this->interestOnlyExpirationDate = $interestOnlyExpirationDate;
    }


}