<?php

namespace App\Entity\Loan;

use DateTime;
use App\Entity\DomainObject;
use App\Entity\Loan;
use App\Service\CreatePropertiesArrayTrait;
use Doctrine\ORM\Mapping\ChangeTrackingPolicy;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'ModificationAttribute')]
#[ORM\Entity(repositoryClass: \App\Repository\Loan\ModificationAttribute::class)]
#[ORM\ChangeTrackingPolicy('NOTIFY')]
class ModificationAttribute extends DomainObject
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
    #[ORM\OneToOne(targetEntity:  Loan::class, inversedBy: 'modificationAttribute')]
    protected $loan;

    /**
     * @var DelinquentAttribute
     */
    #[ORM\JoinColumn(name: 'delinquent_attribute_id', referencedColumnName: 'id', nullable: false)]
    #[ORM\OneToOne(targetEntity:  DelinquentAttribute::class, inversedBy: 'modificationAttribute')]
    protected $delinquentAttribute;

    /**
     * @var ?DateTime
     */
    #[ORM\Column(type: 'datetime', nullable: true)]
    protected ?DateTime $modificationDate;

    /**
     * @var ?float
     */
    #[ORM\Column(type: 'float', precision: 16, scale: 3, nullable: true)]
    protected ?float $capitalizedAmount;

    /**
     * @var ?string
     */
    #[ORM\Column(type: 'string', nullable: true)]
    protected ?string $modificationStatus;

    /**
     * @var ?float
     */
    #[ORM\Column(type: 'float', precision: 16, scale: 3, nullable: true)]
    protected ?float $postPrincipalBalance;

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
    public function getModificationDate(): ?DateTime
    {
        return $this->modificationDate;
    }

    /**
     * @param DateTime|null $modificationDate
     * @return void
     */
    public function setModificationDate(?DateTime $modificationDate): void
    {
        $this->modificationDate = $modificationDate;
    }

    /**
     * @return float|null
     */
    public function getCapitalizedAmount(): ?float
    {
        return $this->capitalizedAmount;
    }

    /**
     * @param float|null $capitalizedAmount
     * @return void
     */
    public function setCapitalizedAmount(?float $capitalizedAmount): void
    {
        $this->capitalizedAmount = $capitalizedAmount;
    }

    /**
     * @return ?string
     */
    public function getModificationStatus(): ?string
    {
        return $this->modificationStatus;
    }

    /**
     * @param string $modificationStatus
     * @return void
     */
    public function setModificationStatus(string $modificationStatus): void
    {
        $this->modificationStatus = $modificationStatus;
    }

    /**
     * @return float|null
     */
    public function getPostPrincipalBalance(): ?float
    {
        return $this->postPrincipalBalance;
    }

    /**
     * @param float|null $postPrincipalBalance
     * @return void
     */
    public function setPostPrincipalBalance(?float $postPrincipalBalance): void
    {
        $this->postPrincipalBalance = $postPrincipalBalance;
    }

}