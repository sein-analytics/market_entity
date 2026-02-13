<?php


namespace App\Entity\Data;

use DateTime;
use Doctrine\ORM\PersistentCollection;
use Doctrine\ORM\Mapping as ORM;
#[ORM\Table(name: 'CuBaseData')]
#[ORM\Entity]
class CuBaseData
{
    /**
     * @var int
     **/
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    protected int $id;

    /**
     * @var CuBase
     */
    #[ORM\ManyToOne(targetEntity:  CuBase::class, inversedBy: 'cuData')]
    protected $cuBase;

    /**
     * @var DateTime
     **/
    #[ORM\Column(type: 'datetime', nullable: false)]
    protected $date;

    /**
     * @var float|int|string
     */
    #[ORM\Column(type: 'float', precision: 14, nullable: false)]
    protected float|int|string $members;

    /**
     * @var float|int|string
     */
    #[ORM\Column(type: 'float', precision: 14, scale: 2, nullable: false)]
    protected float|int|string $totalAssets;

    /**
     * @var float|int|string
     */
    #[ORM\Column(type: 'float', precision: 14, scale: 2, nullable: false)]
    protected float|int|string $totalLoans;

    /**
     * @var float|int|string
     */
    #[ORM\Column(type: 'float', precision: 14, scale: 2, nullable: false)]
    protected float|int|string $totalDeposits;

    /**
     * @var float|int|string
     */
    #[ORM\Column(type: 'float', precision: 18, scale: 12, nullable: false)]
    protected float|int|string $returnOnAvgAsset;

    /**
     * @var float|int|string
     */
    #[ORM\Column(type: 'float', precision: 18, scale: 12, nullable: false)]
    protected float|int|string $netWorthRatio;

    /**
     * @var float|int|string
     */
    #[ORM\Column(type: 'float', precision: 18, scale: 12, nullable: false)]
    protected float|int|string $loanToShare;

    /**
     * @var float|int|string
     */
    #[ORM\Column(type: 'float', precision: 18, scale: 12, nullable: false)]
    protected float|int|string $depositGrowthPct;

    /**
     * @var float|int|string
     */
    #[ORM\Column(type: 'float', precision: 18, scale: 12, nullable: false)]
    protected float|int|string $loansGrowthPct;

    /**
     * @var float|int|string
     */
    #[ORM\Column(type: 'float', precision: 18, scale: 12, nullable: false)]
    protected float|int|string $assetGrowthPct;

    /**
     * @var float|int|string
     */
    #[ORM\Column(type: 'float', precision: 18, scale: 12, nullable: false)]
    protected float|int|string $membersGrowthPct;

    /**
     * @var float|int|string
     */
    #[ORM\Column(type: 'float', precision: 18, scale: 12, nullable: false)]
    protected float|int|string $netWorthGrowthPct;

    /**
     * @return int
     */
    public function getId(): int { return $this->id; }

    /**
     * @return CuBase
     */
    public function getCuBase(): CuBase { return $this->cuBase; }

    /**
     * @return DateTime
     */
    public function getDate(): DateTime { return $this->date; }

    /**
     * @return float|int|string
     */
    public function getMembers():float|int|string { return $this->members; }

    /**
     * @return float|int|string
     */
    public function getTotalAssets():float|int|string { return $this->totalAssets; }

    /**
     * @return float|int|string
     */
    public function getTotalLoans():float|int|string { return $this->totalLoans; }

    /**
     * @return float|int|string
     */
    public function getTotalDeposits():float|int|string { return $this->totalDeposits; }

    /**
     * @return float|int|string
     */
    public function getReturnOnAvgAsset():float|int|string { return $this->returnOnAvgAsset; }

    /**
     * @return float|int|string
     */
    public function getNetWorthRatio():float|int|string { return $this->netWorthRatio; }

    /**
     * @return float|int|string
     */
    public function getLoanToShare():float|int|string { return $this->loanToShare; }

    /**
     * @return float|int|string
     */
    public function getDepositGrowthPct():float|int|string { return $this->depositGrowthPct; }

    /**
     * @return float|int|string
     */
    public function getLoansGrowthPct():float|int|string { return $this->loansGrowthPct; }

    /**
     * @return float|int|string
     */
    public function getAssetGrowthPct():float|int|string { return $this->assetGrowthPct; }

    /**
     * @return float|int|string
     */
    public function getMembersGrowthPct():float|int|string { return $this->membersGrowthPct; }

    /**
     * @return float|int|string
     */
    public function getNetWorthGrowthPct():float|int|string { return $this->netWorthGrowthPct; }


}