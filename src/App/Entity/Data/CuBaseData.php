<?php


namespace App\Entity\Data;

use App\Entity\AnnotationMappings;
use Doctrine\ORM\PersistentCollection;
//use Doctrine\ORM\Mapping as ORM;
/**
 * \Doctrine\ORM\Mapping\Entity()
 * \Doctrine\ORM\Mapping\Table(name="CuBaseData")
 */
class CuBaseData extends AnnotationMappings
{
    /**
     * \Doctrine\ORM\Mapping\Id
     * \Doctrine\ORM\Mapping\Column(type="integer")
     * \Doctrine\ORM\Mapping\GeneratedValue(strategy="AUTO")
     * @var int
     **/
    protected int $id;

    /**
     * \Doctrine\ORM\Mapping\ManyToOne(targetEntity="\App\Entity\Data\CuBase", inversedBy="cuData")
     * @var CuBase
     */
    protected $cuBase;

    /**
     * \Doctrine\ORM\Mapping\Column(type = "datetime", nullable=false)
     * @var \DateTime
     **/
    protected $date;

    /**
     * \Doctrine\ORM\Mapping\Column(type="decimal", precision=14, nullable=false)
     * @var float|int|string
     */
    protected float|int|string $members;

    /**
     * \Doctrine\ORM\Mapping\Column(type="decimal", precision=14, scale=2, nullable=false)
     * @var float|int|string
     */
    protected float|int|string $totalAssets;

    /**
     * \Doctrine\ORM\Mapping\Column(type="decimal", precision=14, scale=2, nullable=false)
     * @var float|int|string
     */
    protected float|int|string $totalLoans;

    /**
     * \Doctrine\ORM\Mapping\Column(type="decimal", precision=14, scale=2, nullable=false)
     * @var float|int|string
     */
    protected float|int|string $totalDeposits;

    /**
     * \Doctrine\ORM\Mapping\Column(type="decimal", precision=18, scale=12, nullable=false)
     * @var float|int|string
     */
    protected float|int|string $returnOnAvgAsset;

    /**
     * \Doctrine\ORM\Mapping\Column(type="decimal", precision=18, scale=12, nullable=false)
     * @var float|int|string
     */
    protected float|int|string $netWorthRatio;

    /**
     * \Doctrine\ORM\Mapping\Column(type="decimal", precision=18, scale=12, nullable=false)
     * @var float|int|string
     */
    protected float|int|string $loanToShare;

    /**
     * \Doctrine\ORM\Mapping\Column(type="decimal", precision=18, scale=12, nullable=false)
     * @var float|int|string
     */
    protected float|int|string $depositGrowthPct;

    /**
     * \Doctrine\ORM\Mapping\Column(type="decimal", precision=18, scale=12, nullable=false)
     * @var float|int|string
     */
    protected float|int|string $loansGrowthPct;

    /**
     * \Doctrine\ORM\Mapping\Column(type="decimal", precision=18, scale=12, nullable=false)
     * @var float|int|string
     */
    protected float|int|string $assetGrowthPct;

    /**
     * \Doctrine\ORM\Mapping\Column(type="decimal", precision=18, scale=12, nullable=false)
     * @var float|int|string
     */
    protected float|int|string $membersGrowthPct;

    /**
     * \Doctrine\ORM\Mapping\Column(type="decimal", precision=18, scale=12, nullable=false)
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