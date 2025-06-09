<?php

namespace App\Entity\Loan;

use App\Entity\DomainObject;
use App\Entity\Loan;
use App\Service\CreatePropertiesArrayTrait;
use Doctrine\ORM\Mapping\ChangeTrackingPolicy;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="\App\Repository\Loan\DelinquentAttribute")
 * @ORM\Table(name="DelinquentAttribute")
 * @ORM\ChangeTrackingPolicy("NOTIFY")
 */
class DelinquentAttribute extends DomainObject
{
    /**
     * @ORM\Id
     * @ORM\Column (type="integer")
     * @ORM\GeneratedValue
     * @var int
     */
    protected int $id;

    /**
     * @ORM\OneToOne(targetEntity="\App\Entity\Loan", inversedBy="delinquentAttribute")
     * @ORM\JoinColumn(name="loan_id", referencedColumnName="id", nullable=false)
     * @var Loan
     */
    protected $loan;

    /**
     * @ORM\OneToOne(targetEntity="\App\Entity\Loan\ModificationAttribute", mappedBy="delinquentAttribute")
     * @var ModificationAttribute
     */
    protected $modificationAttribute;

    /**
     * @ORM\OneToOne(targetEntity="\App\Entity\Loan\ForeclosureAttribute", mappedBy="delinquentAttribute")
     * @var ForeclosureAttribute
     */
    protected $foreclosureAttribute;

    /**
     * @ORM\OneToOne(targetEntity="\App\Entity\Loan\BankruptcyAttribute", mappedBy="delinquentAttribute")
     * @var BankruptcyAttribute
     */
    protected $bankruptcyAttribute;

    /**
     * @ORM\OneToOne(targetEntity="\App\Entity\Loan\LossMitigationAttribute", mappedBy="delinquentAttribute")
     * @var LossMitigationAttribute
     */
    protected $lossMitigationAttribute;

    /**
     * @ORM\OneToOne(targetEntity="\App\Entity\Loan\EscrowAttribute", mappedBy="delinquentAttribute")
     * @var EscrowAttribute
     */
    protected $escrowAttribute;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var ?string
     */
    protected ?string $servicer;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var ?string
     */
    protected ?string $subServicer;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var ?string
     */
    protected ?string $servicerNotes;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var ?string
     */
    protected ?string $subServicerNotes;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var ?string
     */
    protected ?string $servicerStatus;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var ?string
     */
    protected ?string $subServicerStatus;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var ?string
     */
    protected ?string $masterServicer;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var ?string
     */
    protected ?string $masterServicerStatus;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var ?string
     */
    protected ?string $assetManager;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var ?string
     */
    protected ?string $assetManagerStatus;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var ?string
     */
    protected ?string $assetManagerSubStatus;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @var ?int
     */
    protected ?int $daysDelinquent;

    /**
     * @ORM\Column (type="float", precision=16, scale=3, nullable=true)
     * @var ?float
     */
    protected ?float $delinquentPrincipal;

    /**
     * @ORM\Column (type="float", precision=16, scale=3, nullable=true)
     * @var ?float
     */
    protected ?float $delinquentInterest;

    /**
     * @ORM\Column (type="float", precision=16, scale=3, nullable=true)
     * @var ?float
     */
    protected ?float $totalDelinquentBalance;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var ?string
     */
    protected ?string $subStatus;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var ?string
     */
    protected ?string $subStatusNotes;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var ?string
     */
    protected ?string $generalNotes;

    /**
     * @ORM\Column (type="float", precision=16, scale=3, nullable=true)
     * @var ?float
     */
    protected ?float $suspenseBalance;

    /**
     * @ORM\Column (type="float", precision=16, scale=3, nullable=true)
     * @var ?float
     */
    protected ?float $deferredBalance;

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
     * @return ModificationAttribute
     */
    public function getModificationAttribute(): ModificationAttribute
    {
        return $this->modificationAttribute;
    }

    /**
     * @param ModificationAttribute $modificationAttribute
     * @return void
     */
    public function setModificationAttribute(ModificationAttribute $modificationAttribute): void
    {
        $this->modificationAttribute = $modificationAttribute;
    }

    /**
     * @return ForeclosureAttribute
     */
    public function getForeclosureAttribute(): ForeclosureAttribute
    {
        return $this->foreclosureAttribute;
    }

    /**
     * @param ForeclosureAttribute $foreclosureAttribute
     * @return void
     */
    public function setForeclosureAttribute(ForeclosureAttribute $foreclosureAttribute): void
    {
        $this->foreclosureAttribute = $foreclosureAttribute;
    }

    /**
     * @return BankruptcyAttribute
     */
    public function getBankruptcyAttribute(): BankruptcyAttribute
    {
        return $this->bankruptcyAttribute;
    }

    /**
     * @param BankruptcyAttribute $bankruptcyAttribute
     * @return void
     */
    public function setBankruptcyAttribute(BankruptcyAttribute $bankruptcyAttribute): void
    {
        $this->bankruptcyAttribute = $bankruptcyAttribute;
    }

    /**
     * @return LossMitigationAttribute
     */
    public function getLossMitigationAttribute(): LossMitigationAttribute
    {
        return $this->lossMitigationAttribute;
    }

    /**
     * @param LossMitigationAttribute $lossMitigationAttribute
     * @return void
     */
    public function setLossMitigationAttribute(LossMitigationAttribute $lossMitigationAttribute): void
    {
        $this->lossMitigationAttribute = $lossMitigationAttribute;
    }

    /**
     * @return EscrowAttribute
     */
    public function getEscrowAttribute(): EscrowAttribute
    {
        return $this->escrowAttribute;
    }

    /**
     * @param EscrowAttribute $escrowAttribute
     * @return void
     */
    public function setEscrowAttribute(EscrowAttribute $escrowAttribute): void
    {
        $this->escrowAttribute = $escrowAttribute;
    }

    /**
     * @return string|null
     */
    public function getServicer(): ?string
    {
        return $this->servicer;
    }

    /**
     * @param string|null $servicer
     * @return void
     */
    public function setServicer(?string $servicer): void
    {
        $this->servicer = $servicer;
    }

    /**
     * @return string|null
     */
    public function getSubServicer(): ?string
    {
        return $this->subServicer;
    }

    /**
     * @param string|null $subServicer
     * @return void
     */
    public function setSubServicer(?string $subServicer): void
    {
        $this->subServicer = $subServicer;
    }

    /**
     * @return string|null
     */
    public function getServicerNotes(): ?string
    {
        return $this->servicerNotes;
    }

    /**
     * @param string|null $servicerNotes
     * @return void
     */
    public function setServicerNotes(?string $servicerNotes): void
    {
        $this->servicerNotes = $servicerNotes;
    }

    /**
     * @return string|null
     */
    public function getSubServicerNotes(): ?string
    {
        return $this->subServicerNotes;
    }

    /**
     * @param string|null $subServicerNotes
     * @return void
     */
    public function setSubServicerNotes(?string $subServicerNotes): void
    {
        $this->subServicerNotes = $subServicerNotes;
    }

    /**
     * @return string|null
     */
    public function getServicerStatus(): ?string
    {
        return $this->servicerStatus;
    }

    /**
     * @param string|null $servicerStatus
     * @return void
     */
    public function setServicerStatus(?string $servicerStatus): void
    {
        $this->servicerStatus = $servicerStatus;
    }

    /**
     * @return string|null
     */
    public function getSubServicerStatus(): ?string
    {
        return $this->subServicerStatus;
    }

    /**
     * @param string|null $subServicerStatus
     * @return void
     */
    public function setSubServicerStatus(?string $subServicerStatus): void
    {
        $this->subServicerStatus = $subServicerStatus;
    }

    /**
     * @return string|null
     */
    public function getMasterServicer(): ?string
    {
        return $this->masterServicer;
    }

    /**
     * @param string|null $masterServicer
     * @return void
     */
    public function setMasterServicer(?string $masterServicer): void
    {
        $this->masterServicer = $masterServicer;
    }

    /**
     * @return string|null
     */
    public function getMasterServicerStatus(): ?string
    {
        return $this->masterServicerStatus;
    }

    /**
     * @param string|null $masterServicerStatus
     * @return void
     */
    public function setMasterServicerStatus(?string $masterServicerStatus): void
    {
        $this->masterServicerStatus = $masterServicerStatus;
    }

    /**
     * @return string|null
     */
    public function getAssetManager(): ?string
    {
        return $this->assetManager;
    }

    /**
     * @param string|null $assetManager
     * @return void
     */
    public function setAssetManager(?string $assetManager): void
    {
        $this->assetManager = $assetManager;
    }

    /**
     * @return string|null
     */
    public function getAssetManagerStatus(): ?string
    {
        return $this->assetManagerStatus;
    }

    /**
     * @param string|null $assetManagerStatus
     * @return void
     */
    public function setAssetManagerStatus(?string $assetManagerStatus): void
    {
        $this->assetManagerStatus = $assetManagerStatus;
    }

    /**
     * @return string|null
     */
    public function getAssetManagerSubStatus(): ?string
    {
        return $this->assetManagerSubStatus;
    }

    /**
     * @param string|null $assetManagerSubStatus
     * @return void
     */
    public function setAssetManagerSubStatus(?string $assetManagerSubStatus): void
    {
        $this->assetManagerSubStatus = $assetManagerSubStatus;
    }

    /**
     * @return int|null
     */
    public function getDaysDelinquent(): ?int
    {
        return $this->daysDelinquent;
    }

    /**
     * @param int|null $daysDelinquent
     * @return void
     */
    public function setDaysDelinquent(?int $daysDelinquent): void
    {
        $this->daysDelinquent = $daysDelinquent;
    }

    /**
     * @return float|null
     */
    public function getDelinquentPrincipal(): ?float
    {
        return $this->delinquentPrincipal;
    }

    /**
     * @param float|null $delinquentPrincipal
     * @return void
     */
    public function setDelinquentPrincipal(?float $delinquentPrincipal): void
    {
        $this->delinquentPrincipal = $delinquentPrincipal;
    }

    /**
     * @return float|null
     */
    public function getDelinquentInterest(): ?float
    {
        return $this->delinquentInterest;
    }

    /**
     * @param float|null $delinquentInterest
     * @return void
     */
    public function setDelinquentInterest(?float $delinquentInterest): void
    {
        $this->delinquentInterest = $delinquentInterest;
    }

    /**
     * @return float|null
     */
    public function getTotalDelinquentBalance(): ?float
    {
        return $this->totalDelinquentBalance;
    }

    /**
     * @param float|null $totalDelinquentBalance
     * @return void
     */
    public function setTotalDelinquentBalance(?float $totalDelinquentBalance): void
    {
        $this->totalDelinquentBalance = $totalDelinquentBalance;
    }

    /**
     * @return string|null
     */
    public function getGeneralNotes(): ?string
    {
        return $this->generalNotes;
    }

    /**
     * @return string|null
     */
    public function getSubStatus(): ?string
    {
        return $this->subStatus;
    }

    /**
     * @param string|null $subStatus
     * @return void
     */
    public function setSubStatus(?string $subStatus): void
    {
        $this->subStatus = $subStatus;
    }

    /**
     * @return string|null
     */
    public function getSubStatusNotes(): ?string
    {
        return $this->subStatusNotes;
    }

    /**
     * @param string|null $subStatusNotes
     * @return void
     */
    public function setSubStatusNotes(?string $subStatusNotes): void
    {
        $this->subStatusNotes = $subStatusNotes;
    }

    /**
     * @param string|null $generalNotes
     * @return void
     */
    public function setGeneralNotes(?string $generalNotes): void
    {
        $this->generalNotes = $generalNotes;
    }


}