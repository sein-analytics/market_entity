<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 * Date: 2018-12-20
 * Time: 13:15
 */

namespace App\Entity\Loan;

use App\Entity\DomainObject;
use App\Entity\Loan;
use App\Service\CreatePropertiesArrayTrait;
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity(repositoryClass="\App\Repository\Loan\CommAttribute")
 * @ORM\Table(name="CommAttribute")
 * @ORM\ChangeTrackingPolicy("NOTIFY")
 */
class CommAttribute extends DomainObject
{
    use CreatePropertiesArrayTrait;

    protected array $ignoreDbProperties = [];

    protected array $addUcIdToPropName = ['loan' => null];

    protected array $defaultValueProperties = [];

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    protected int $id;

    /**
     * @ORM\OneToOne(targetEntity="\App\Entity\Loan", inversedBy="commAttributes")
     * @ORM\JoinColumn(name="loan_id", referencedColumnName="id", nullable=false)
     * @var \App\Entity\Loan
     **/
    protected $loan;

    /**
     * @ORM\Column(type="float", precision=12, scale=8, nullable=true)
     */
    protected float|null $dscr;

    /**
     * @ORM\Column(type="float", precision=16, scale=4, nullable=true)
     */
    protected float|null $noi;

    /**
     * @ORM\Column(type="float", precision=12, scale=8, nullable=true)
     */
    protected float|null $netWorthToLoan;

    /**
     * @ORM\Column(type="float", precision=12, scale=8, nullable=true)
     */
    protected float|null $profitRatio;

    /**
     * @ORM\Column(type="float", precision=12, scale=8, nullable=true)
     */
    protected float|null $loanToCostRatio;

    /**
     * @ORM\Column(type="float", precision=12, scale=8, nullable=true)
     */
    protected float|null $debtYieldRatio;

    /**
     * @ORM\Column(type="float", precision=12, scale=8, nullable=true)
     */
    protected float|null $vacancyRate;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    protected int|null $lockoutPeriod;

    /**
     * @ORM\Column(type = "datetime", nullable=true)
     * @var \DateTime|null
     **/
    protected \DateTime|null $defeasanceDate;

    /**
     * @ORM\Column(type="float", precision=12, scale=8, nullable=true)
     */
    protected float|null $capRate;

    /**
     * @return int
     */
    public function getId():int { return $this->id; }

    /**
     * @return Loan
     */
    public function getLoan(): Loan { return $this->loan; }

    /**
     * @param Loan $loan
     */
    public function setLoan(Loan $loan)
    {
        $this->implementChange($this, 'loan', $this->loan, $loan);
    }

    /**
     * @return float|null
     */
    public function getDscr():?float { return $this->dscr; }

    /**
     * @param float $dscr
     */
    public function setDscr(float $dscr):void
    {
        $this->implementChange($this, 'dscr', $this->dscr, $dscr);
    }

    /**
     * @return float|null
     */
    public function getNoi():float|null { return $this->noi; }

    /**
     * @param float $noi
     */
    public function setNoi(float $noi):void
    {
        $this->implementChange($this, 'noi', $this->noi, $noi);
    }

    /**
     * @return float|null
     */
    public function getNetWorthToLoan():float|null { return $this->netWorthToLoan; }

    /**
     * @param float $netWorthToLoan
     */
    public function setNetWorthToLoan(float $netWorthToLoan)
    {
        $this->implementChange($this, 'netWorthToLoan', $this->netWorthToLoan, $netWorthToLoan);
    }

    /**
     * @return float|null
     */
    public function getProfitRatio():float|null { return $this->profitRatio; }

    /**
     * @param float $profitRatio
     */
    public function setProfitRatio(float $profitRatio):void
    {
        $this->implementChange($this, 'profitRatio', $this->profitRatio, $profitRatio);
    }

    /**
     * @return float|null
     */
    public function getLoanToCostRatio():float|null { return $this->loanToCostRatio; }

    /**
     * @param float $loanToCostRatio
     */
    public function setLoanToCostRatio(float $loanToCostRatio)
    {
        $this->implementChange($this, 'loanToCostRatio', $this->loanToCostRatio, $loanToCostRatio);
    }

    /**
     * @return float|null
     */
    public function getDebtYieldRatio():float|null { return $this->debtYieldRatio;}

    /**
     * @param float  $debtYieldRatio
     */
    public function setDebtYieldRatio(float $debtYieldRatio)
    {
        $this->implementChange($this, 'debtYieldRatio', $this->debtYieldRatio, $debtYieldRatio);
    }

    /**
     * @return float|null
     */
    public function getVacancyRate():float|null { return $this->vacancyRate; }

    /**
     * @param float $vacancyRate
     */
    public function setVacancyRate(float $vacancyRate)
    {
        $this->implementChange($this, 'vacancyRate', $this->vacancyRate, $vacancyRate);
    }

    /**
     * @return int|null
     */
    public function getLockoutPeriod():?int { return $this->lockoutPeriod; }

    /**
     * @param int $lockoutPeriod
     */
    public function setLockoutPeriod(int $lockoutPeriod)
    {
        $this->implementChange($this, 'lockoutPeriod', $this->lockoutPeriod, $lockoutPeriod);
    }

    /**
     * @return \DateTime|null
     */
    public function getDefeasanceDate():\DateTime|null {  return $this->defeasanceDate; }

    /**
     * @param \DateTime $defeasanceDate
     */
    public function setDefeasanceDate(\DateTime $defeasanceDate):void
    {
        $this->implementChange($this,'defeasanceDate', $this->defeasanceDate, $defeasanceDate);
    }

    /**
     * @return float|null
     */
    public function getCapRate():float|null { return $this->capRate; }

    /**
     * @param float $capRate
     */
    public function setCapRate(float $capRate)
    {
        $this->implementChange($this, 'capRate', $this->capRate, $capRate);
    }


}