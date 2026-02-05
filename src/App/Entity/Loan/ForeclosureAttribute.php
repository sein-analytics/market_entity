<?php

namespace App\Entity\Loan;

use DateTime;
use App\Entity\DomainObject;
use App\Entity\Loan;
use App\Service\CreatePropertiesArrayTrait;
 
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'ForeclosureAttribute')]
#[ORM\Entity(repositoryClass: \App\Repository\Loan\ForeclosureAttribute::class)]
 
class ForeclosureAttribute extends DomainObject
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
    #[ORM\OneToOne(targetEntity:  Loan::class, inversedBy: 'foreclosureAttribute')]
    protected $loan;

    /**
     * @var DelinquentAttribute
     */
    #[ORM\JoinColumn(name: 'delinquent_attribute_id', referencedColumnName: 'id', nullable: false)]
    #[ORM\OneToOne(targetEntity:  DelinquentAttribute::class, inversedBy: 'foreclosureAttribute')]
    protected $delinquentAttribute;

    /**
     * @var ?DateTime
     */
    #[ORM\Column(type: 'datetime', nullable: true)]
    protected ?DateTime $foreclosureStartDate;

    /**
     * @var ?float
     */
    #[ORM\Column(type: 'float', precision: 16, scale: 3, nullable: true)]
    protected ?float $foreclosureBidAmount;

    /**
     * @var ?DateTime
     */
    #[ORM\Column(type: 'datetime', nullable: true)]
    protected ?DateTime $actualSaleDate;

    /**
     * @var ?DateTime
     */
    #[ORM\Column(type: 'datetime', nullable: true)]
    protected ?DateTime $judgementDate;

    /**
     * @var ?DateTime
     */
    #[ORM\Column(type: 'datetime', nullable: true)]
    protected ?DateTime $referredToAttyDate;

    /**
     * @var ?DateTime
     */
    #[ORM\Column(type: 'datetime', nullable: true)]
    protected ?DateTime $serviceCompleteDate;

    /**
     * @var ?string
     */
    #[ORM\Column(type: 'string', nullable: true)]
    protected ?string $foreclosureStatus;

    /**
     * @var ?DateTime
     */
    #[ORM\Column(type: 'datetime', nullable: true)]
    protected ?DateTime $scheduleSaleDate;

    /**
     * @var ?DateTime
     */
    #[ORM\Column(type: 'datetime', nullable: true)]
    protected ?DateTime $completedDate;

    /**
     * @var ?DateTime
     */
    #[ORM\Column(type: 'datetime', nullable: true)]
    protected ?DateTime $removalDate;

    /**
     * @var ?DateTime
     */
    #[ORM\Column(type: 'datetime', nullable: true)]
    protected ?DateTime $suspendedDate;

    /**
     * @var ?string
     */
    #[ORM\Column(type: 'string', nullable: true)]
    protected ?string $foreclosureType;

    /**
     * @var ?DateTime
     */
    #[ORM\Column(type: 'datetime', nullable: true)]
    protected ?DateTime $nextStepDate;

    /**
     * @var ?DateTime
     */
    #[ORM\Column(type: 'datetime', nullable: true)]
    protected ?DateTime $referralDate;

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
    public function getForeclosureStartDate(): ?DateTime
    {
        return $this->foreclosureStartDate;
    }

    /**
     * @param DateTime|null $foreclosureStartDate
     * @return void
     */
    public function setForeclosureStartDate(?DateTime $foreclosureStartDate): void
    {
        $this->foreclosureStartDate = $foreclosureStartDate;
    }

    /**
     * @return float|null
     */
    public function getForeclosureBidAmount(): ?float
    {
        return $this->foreclosureBidAmount;
    }

    /**
     * @param float|null $foreclosureBidAmount
     * @return void
     */
    public function setForeclosureBidAmount(?float $foreclosureBidAmount): void
    {
        $this->foreclosureBidAmount = $foreclosureBidAmount;
    }

    /**
     * @return DateTime|null
     */
    public function getActualSaleDate(): ?DateTime
    {
        return $this->actualSaleDate;
    }

    /**
     * @param DateTime|null $actualSaleDate
     * @return void
     */
    public function setActualSaleDate(?DateTime $actualSaleDate): void
    {
        $this->actualSaleDate = $actualSaleDate;
    }

    /**
     * @return DateTime|null
     */
    public function getJudgementDate(): ?DateTime
    {
        return $this->judgementDate;
    }

    /**
     * @param DateTime|null $judgementDate
     * @return void
     */
    public function setJudgementDate(?DateTime $judgementDate): void
    {
        $this->judgementDate = $judgementDate;
    }

    /**
     * @return DateTime|null
     */
    public function getReferredToAttyDate(): ?DateTime
    {
        return $this->referredToAttyDate;
    }

    /**
     * @param DateTime|null $referredToAttyDate
     * @return void
     */
    public function setReferredToAttyDate(?DateTime $referredToAttyDate): void
    {
        $this->referredToAttyDate = $referredToAttyDate;
    }

    /**
     * @return DateTime|null
     */
    public function getServiceCompleteDate(): ?DateTime
    {
        return $this->serviceCompleteDate;
    }

    /**
     * @param DateTime|null $serviceCompleteDate
     * @return void
     */
    public function setServiceCompleteDate(?DateTime $serviceCompleteDate): void
    {
        $this->serviceCompleteDate = $serviceCompleteDate;
    }

    /**
     * @return string|null
     */
    public function getForeclosureStatus(): ?string
    {
        return $this->foreclosureStatus;
    }

    /**
     * @param string|null $foreclosureStatus
     * @return void
     */
    public function setForeclosureStatus(?string $foreclosureStatus): void
    {
        $this->foreclosureStatus = $foreclosureStatus;
    }

    /**
     * @return DateTime|null
     */
    public function getScheduleSaleDate(): ?DateTime
    {
        return $this->scheduleSaleDate;
    }

    /**
     * @param DateTime|null $scheduleSaleDate
     * @return void
     */
    public function setScheduleSaleDate(?DateTime $scheduleSaleDate): void
    {
        $this->scheduleSaleDate = $scheduleSaleDate;
    }

    /**
     * @return DateTime|null
     */
    public function getCompletedDate(): ?DateTime
    {
        return $this->completedDate;
    }

    /**
     * @param DateTime|null $completedDate
     * @return void
     */
    public function setCompletedDate(?DateTime $completedDate): void
    {
        $this->completedDate = $completedDate;
    }

    /**
     * @return DateTime|null
     */
    public function getRemovalDate(): ?DateTime
    {
        return $this->removalDate;
    }

    /**
     * @param DateTime|null $removalDate
     * @return void
     */
    public function setRemovalDate(?DateTime $removalDate): void
    {
        $this->removalDate = $removalDate;
    }

    /**
     * @return DateTime|null
     */
    public function getSuspendedDate(): ?DateTime
    {
        return $this->suspendedDate;
    }

    /**
     * @param DateTime|null $suspendedDate
     * @return void
     */
    public function setSuspendedDate(?DateTime $suspendedDate): void
    {
        $this->suspendedDate = $suspendedDate;
    }

    /**
     * @return string|null
     */
    public function getForeclosureType(): ?string
    {
        return $this->foreclosureType;
    }

    /**
     * @param string|null $foreclosureType
     * @return void
     */
    public function setForeclosureType(?string $foreclosureType): void
    {
        $this->foreclosureType = $foreclosureType;
    }

    /**
     * @return DateTime|null
     */
    public function getNextStepDate(): ?DateTime
    {
        return $this->nextStepDate;
    }

    /**
     * @param DateTime|null $nextStepDate
     * @return void
     */
    public function setNextStepDate(?DateTime $nextStepDate): void
    {
        $this->nextStepDate = $nextStepDate;
    }

    /**
     * @return DateTime|null
     */
    public function getReferralDate(): ?DateTime
    {
        return $this->referralDate;
    }

    /**
     * @param DateTime|null $referralDate
     * @return void
     */
    public function setReferralDate(?DateTime $referralDate): void
    {
        $this->referralDate = $referralDate;
    }

}