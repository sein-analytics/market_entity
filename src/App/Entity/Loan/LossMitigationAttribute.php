<?php

namespace App\Entity\Loan;

use App\Entity\DomainObject;
use App\Entity\Loan;
use App\Service\CreatePropertiesArrayTrait;
use Doctrine\ORM\Mapping\ChangeTrackingPolicy;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="\App\Repository\Loan\LossMitigationAttribute")
 * @ORM\Table(name="LossMitigationAttribute")
 * @ORM\ChangeTrackingPolicy("NOTIFY")
 */
class LossMitigationAttribute extends DomainObject
{
    use CreatePropertiesArrayTrait;

    /**
     * @ORM\Id
     * @ORM\Column (type="integer")
     * @ORM\GeneratedValue
     * @var int
     */
    protected int $id;

    /**
     * @ORM\OneToOne(targetEntity="\App\Entity\Loan", inversedBy="lossMitigationAttribute")
     * @ORM\JoinColumn(name="loan_id", referencedColumnName="id", nullable=false)
     * @var Loan
     */
    protected $loan;

    /**
     * @ORM\OneToOne(targetEntity="\App\Entity\Loan\DelinquentAttribute", inversedBy="lossMitigationAttribute")
     * @ORM\JoinColumn(name="delinquent_attribute_id", referencedColumnName="id", nullable=false)
     * @var DelinquentAttribute
     */
    protected $delinquentAttribute;

    /**
     * @ORM\Column (type = "datetime", nullable = true)
     * @var ?\DateTime
     */
    protected ?\DateTime $setupDate;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var ?string
     */
    protected ?string $lossMitigationStatus;

    /**
     * @ORM\Column (type = "datetime", nullable = true)
     * @var ?\DateTime
     */
    protected ?\DateTime $removalDate;

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
     * @return \DateTime|null
     */
    public function getSetupDate(): ?\DateTime
    {
        return $this->setupDate;
    }

    /**
     * @param \DateTime|null $setupDate
     * @return void
     */
    public function setSetupDate(?\DateTime $setupDate): void
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
     * @return \DateTime|null
     */
    public function getRemovalDate(): ?\DateTime
    {
        return $this->removalDate;
    }

    /**
     * @param \DateTime|null $removalDate
     * @return void
     */
    public function setRemovalDate(?\DateTime $removalDate): void
    {
        $this->removalDate = $removalDate;
    }

}