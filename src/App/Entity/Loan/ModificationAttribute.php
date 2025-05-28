<?php

namespace App\Entity\Loan;

use App\Entity\DomainObject;
use App\Entity\Loan;
use App\Service\CreatePropertiesArrayTrait;
use Doctrine\ORM\Mapping\ChangeTrackingPolicy;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="\App\Repository\Loan\ModificationAttribute")
 * @ORM\Table(name="ModificationAttribute")
 * @ORM\ChangeTrackingPolicy("NOTIFY")
 */
class ModificationAttribute extends DomainObject
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
     * @ORM\OneToOne(targetEntity="\App\Entity\Loan", inversedBy="modificationAttribute")
     * @var Loan
     */
    protected $loan;

    /**
     * @ORM\Column (type = "datetime", nullable = true)
     * @var ?\DateTime
     */
    protected ?\DateTime $modificationDate;

    /**
     * @ORM\Column (type="decimal", precision=16, scale=3, nullable=true)
     * @var ?float
     */
    protected ?float $capitalizedAmount;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var string
     */
    protected $modificationStatus;

    /**
     * @ORM\Column (type="decimal", precision=16, scale=3, nullable=true)
     * @var ?float
     */
    protected $postModBalance;

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
     * @return \DateTime|null
     */
    public function getModificationDate(): ?\DateTime
    {
        return $this->modificationDate;
    }

    /**
     * @param \DateTime|null $modificationDate
     * @return void
     */
    public function setModificationDate(?\DateTime $modificationDate): void
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
     * @return string
     */
    public function getModificationStatus(): string
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
    public function getPostModBalance(): ?float
    {
        return $this->postModBalance;
    }

    /**
     * @param float|null $postModBalance
     * @return void
     */
    public function setPostModBalance(?float $postModBalance): void
    {
        $this->postModBalance = $postModBalance;
    }

}