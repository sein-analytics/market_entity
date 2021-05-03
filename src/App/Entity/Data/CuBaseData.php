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
    protected $id;

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
     * @var numeric
     */
    protected $members;

    /**
     * @ORM\Column(type="decimal", precision=14, scale=2, nullable=false)
     * @var numeric
     */
    protected $totalAssets;

    /**
     * @ORM\Column(type="decimal", precision=14, scale=2, nullable=false)
     * @var numeric
     */
    protected $totalLoans;

    /**
     * @ORM\Column(type="decimal", precision=14, scale=2, nullable=false)
     * @var numeric
     */
    protected $totalDeposits;

    /**
     * @ORM\Column(type="decimal", precision=18, scale=12, nullable=false)
     * @var numeric
     */
    protected $returnOnAvgAsset;

    /**
     * @ORM\Column(type="decimal", precision=18, scale=12, nullable=false)
     * @var numeric
     */
    protected $netWorthRatio;

    /**
     * @ORM\Column(type="decimal", precision=18, scale=12, nullable=false)
     * @var numeric
     */
    protected $loanToShare;

    /**
     * @ORM\Column(type="decimal", precision=18, scale=12, nullable=false)
     * @var numeric
     */
    protected $depositGrowthPct;

    /**
     * @ORM\Column(type="decimal", precision=18, scale=12, nullable=false)
     * @var numeric
     */
    protected $loansGrowthPct;

    /**
     * @ORM\Column(type="decimal", precision=18, scale=12, nullable=false)
     * @var numeric
     */
    protected $assetGrowthPct;

    /**
     * @ORM\Column(type="decimal", precision=18, scale=12, nullable=false)
     * @var numeric
     */
    protected $membersGrowthPct;

    /**
     * @ORM\Column(type="decimal", precision=18, scale=12, nullable=false)
     * @var numeric
     */
    protected $netWorthGrowthPct;

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
    public function getMembers() { return $this->members; }

    /**
     * @return float|int|string
     */
    public function getTotalAssets() { return $this->totalAssets; }

    /**
     * @return float|int|string
     */
    public function getTotalLoans() { return $this->totalLoans; }

    /**
     * @return float|int|string
     */
    public function getTotalDeposits() { return $this->totalDeposits; }

    /**
     * @return float|int|string
     */
    public function getReturnOnAvgAsset() { return $this->returnOnAvgAsset; }

    /**
     * @return float|int|string
     */
    public function getNetWorthRatio() { return $this->netWorthRatio; }

    /**
     * @return float|int|string
     */
    public function getLoanToShare() { return $this->loanToShare; }

    /**
     * @return float|int|string
     */
    public function getDepositGrowthPct() { return $this->depositGrowthPct; }

    /**
     * @return float|int|string
     */
    public function getLoansGrowthPct() { return $this->loansGrowthPct; }

    /**
     * @return float|int|string
     */
    public function getAssetGrowthPct() { return $this->assetGrowthPct; }

    /**
     * @return float|int|string
     */
    public function getMembersGrowthPct() { return $this->membersGrowthPct; }

    /**
     * @return float|int|string
     */
    public function getNetWorthGrowthPct() { return $this->netWorthGrowthPct; }


}