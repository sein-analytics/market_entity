<?php

namespace App\Entity\Loan;

use DateTime;
use App\Entity\DomainObject;
use App\Entity\Loan;
use App\Service\CreatePropertiesArrayTrait;
 
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'LossMitigationAttribute')]
#[ORM\Entity(repositoryClass: \App\Repository\Loan\LossMitigationAttribute::class)]
 
class LossMitigationAttribute extends DomainObject
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
    #[ORM\OneToOne(targetEntity:  Loan::class, inversedBy: 'lossMitigationAttribute')]
    protected $loan;

    /**
     * @var DelinquentAttribute
     */
    #[ORM\JoinColumn(name: 'delinquent_attribute_id', referencedColumnName: 'id', nullable: false)]
    #[ORM\OneToOne(targetEntity:  DelinquentAttribute::class, inversedBy: 'lossMitigationAttribute')]
    protected $delinquentAttribute;

    /**
     * @var ?DateTime
     */
    #[ORM\Column(type: 'datetime', nullable: true)]
    protected ?DateTime $setupDate;

    /**
     * @var ?string
     */
    #[ORM\Column(type: 'string', nullable: true)]
    protected ?string $lossMitigationStatus;

    /**
     * @var ?DateTime
     */
    #[ORM\Column(type: 'datetime', nullable: true)]
    protected ?DateTime $lossMitRemovalDate;

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
     * @return DateTime|null
     */
    public function getSetupDate(): ?DateTime
    {
        return $this->setupDate;
    }

    /**
     * @param DateTime|null $setupDate
     * @return void
     */
    public function setSetupDate(?DateTime $setupDate): void
    {
        $this->setupDate = $setupDate;
    }

    /**
     * @return string|null
     */
    public function getLossMitigationStatus(): ?string
    {
        return $this->lossMitigationStatus;
    }

    /**
     * @param string|null $lossMitigationStatus
     * @return void
     */
    public function setLossMitigationStatus(?string $lossMitigationStatus): void
    {
        $this->lossMitigationStatus = $lossMitigationStatus;
    }

    /**
     * @return DateTime|null
     */
    public function getRemovalDate(): ?DateTime
    {
        return $this->lossMitRemovalDate;
    }

    /**
     * @param DateTime|null $lossMitRemovalDate
     * @return void
     */
    public function setRemovalDate(?DateTime $lossMitRemovalDate): void
    {
        $this->lossMitRemovalDate = $lossMitRemovalDate;
    }

}