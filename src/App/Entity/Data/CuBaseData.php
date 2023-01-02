<?php


namespace App\Entity\Data;

use Doctrine\ORM\PersistentCollection;
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity()
 * @ORM\Table(name="CuBaseData")
 */
class CuBaseData
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @var int
     **/
    protected int $id;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\Data\CuBase", inversedBy="cuData")
     * @var CuBase
     */
    protected $cuBase;

    /**
     * @ORM\Column(type = "datetime", nullable=false)
     * @var \DateTime
     **/
    protected $date;

    /**
     * @ORM\Column(type="decimal", precision=14, nullable=false)
     * @var float|int|string
     */
    protected float|int|string $members;

    /**
     * @ORM\Column(type="decimal", precision=14, scale=2, nullable=false)
     * @var float|int|string
     */
    protected float|int|string $totalAssets;

    /**
     * @ORM\Column(type="decimal", precision=14, scale=2, nullable=false)
     * @var float|int|string
     */
    protected float|int|string $totalLoans;

    /**
     * @ORM\Column(type="decimal", precision=14, scale=2, nullable=false)
     * @var float|int|string
     */
    protected float|int|string $totalDeposits;

    /**
     * @ORM\Column(type="decimal", precision=18, scale=12, nullable=false)
     * @var float|int|string
     */
    protected float|int|string $returnOnAvgAsset;

    /**
     * @ORM\Column(type="decimal", precision=18, scale=12, nullable=false)
     * @var float|int|string
     */
    protected float|int|string $netWorthRatio;

    /**
     * @ORM\Column(type="decimal", precision=18, scale=12, nullable=false)
     * @var float|int|string
     */
    protected float|int|string $loanToShare;

    /**
     * @ORM\Column(type="decimal", precision=18, scale=12, nullable=false)
     * @var float|int|string
     */
    protected float|int|string $depositGrowthPct;

    /**
     * @ORM\Column(type="decimal", precision=18, scale=12, nullable=false)
     * @var float|int|string
     */
    protected float|int|string $loansGrowthPct;

    /**
     * @ORM\Column(type="decimal", precision=18, scale=12, nullable=false)
     * @var float|int|string
     */
    protected float|int|string $assetGrowthPct;

    /**
     * @ORM\Column(type="decimal", precision=18, scale=12, nullable=false)
     * @var float|int|string
     */
    protected float|int|string $membersGrowthPct;

    /**
     * @ORM\Column(type="decimal", precision=18, scale=12, nullable=false)
     * @var float|int|string
     */
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
     * @return \DateTime
     */
    public function getDate(): \DateTime { return $this->date; }

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