<?php

namespace App\Entity\Loan;

use App\Entity\DomainObject;
use App\Entity\Loan;
use App\Service\CreatePropertiesArrayTrait;
use Doctrine\ORM\Mapping\ChangeTrackingPolicy;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="\App\Repository\Loan\BankruptcyAttribute")
 * @ORM\Table(name="BankruptcyAttribute")
 * @ORM\ChangeTrackingPolicy("NOTIFY")
 */
class BankruptcyAttribute extends DomainObject
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
     * @ORM\OneToOne(targetEntity="\App\Entity\Loan", inversedBy="bankruptcyAttribute")
     * @var Loan
     */
    protected $loan;

    /**
     * @ORM\OneToOne(targetEntity="\App\Entity\Loan\DelinquentAttribute", inversedBy="bankruptcyAttribute")
     * @var DelinquentAttribute
     */
    protected $delinquentAttribute;

    /**
     * @ORM\Column (type = "datetime", nullable = true)
     * @var ?\DateTime
     */
    protected ?\DateTime $fileDate;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var ?string
     */
    protected ?string $caseNumber;

    /**
     * @ORM\Column (type = "datetime", nullable = true)
     * @var ?\DateTime
     */
    protected ?\DateTime $dismissedDate;

    /**
     * @ORM\Column (type = "datetime", nullable = true)
     * @var ?\DateTime
     */
    protected ?\DateTime $planStartDate;

    /**
     * @ORM\Column (type = "datetime", nullable = true)
     * @var ?\DateTime
     */
    protected ?\DateTime $planEndDate;

    /**
     * @ORM\Column (type = "datetime", nullable = true)
     * @var ?\DateTime
     */
    protected ?\DateTime $postPetitionDueDate;

    /**
     * @ORM\Column (type = "datetime", nullable = true)
     * @var ?\DateTime
     */
    protected ?\DateTime $caseClosedDate;

    /**
     * @ORM\Column (type = "datetime", nullable = true)
     * @var ?\DateTime
     */
    protected ?\DateTime $motionReliefDate;

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
    public function getFileDate(): ?\DateTime
    {
        return $this->fileDate;
    }

    /**
     * @param \DateTime|null $fileDate
     * @return void
     */
    public function setFileDate(?\DateTime $fileDate): void
    {
        $this->fileDate = $fileDate;
    }

    /**
     * @return string|null
     */
    public function getCaseNumber(): ?string
    {
        return $this->caseNumber;
    }

    /**
     * @param string|null $caseNumber
     * @return void
     */
    public function setCaseNumber(?string $caseNumber): void
    {
        $this->caseNumber = $caseNumber;
    }

    /**
     * @return \DateTime|null
     */
    public function getDismissedDate(): ?\DateTime
    {
        return $this->dismissedDate;
    }

    /**
     * @param \DateTime|null $dismissedDate
     * @return void
     */
    public function setDismissedDate(?\DateTime $dismissedDate): void
    {
        $this->dismissedDate = $dismissedDate;
    }

    /**
     * @return \DateTime|null
     */
    public function getPlanStartDate(): ?\DateTime
    {
        return $this->planStartDate;
    }

    /**
     * @param \DateTime|null $planStartDate
     * @return void
     */
    public function setPlanStartDate(?\DateTime $planStartDate): void
    {
        $this->planStartDate = $planStartDate;
    }

    /**
     * @return \DateTime|null
     */
    public function getPlanEndDate(): ?\DateTime
    {
        return $this->planEndDate;
    }

    /**
     * @param \DateTime|null $planEndDate
     * @return void
     */
    public function setPlanEndDate(?\DateTime $planEndDate): void
    {
        $this->planEndDate = $planEndDate;
    }

    /**
     * @return \DateTime|null
     */
    public function getPostPetitionDueDate(): ?\DateTime
    {
        return $this->postPetitionDueDate;
    }

    /**
     * @param \DateTime|null $postPetitionDueDate
     * @return void
     */
    public function setPostPetitionDueDate(?\DateTime $postPetitionDueDate): void
    {
        $this->postPetitionDueDate = $postPetitionDueDate;
    }

    /**
     * @return \DateTime|null
     */
    public function getCaseClosedDate(): ?\DateTime
    {
        return $this->caseClosedDate;
    }

    /**
     * @param \DateTime|null $caseClosedDate
     * @return void
     */
    public function setCaseClosedDate(?\DateTime $caseClosedDate): void
    {
        $this->caseClosedDate = $caseClosedDate;
    }

    /**
     * @return \DateTime|null
     */
    public function getMotionReliefDate(): ?\DateTime
    {
        return $this->motionReliefDate;
    }

    /**
     * @param \DateTime|null $motionReliefDate
     * @return void
     */
    public function setMotionReliefDate(?\DateTime $motionReliefDate): void
    {
        $this->motionReliefDate = $motionReliefDate;
    }

}