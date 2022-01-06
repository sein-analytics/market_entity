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
use Doctrine\ORM\Mapping\ChangeTrackingPolicy;
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity(repositoryClass="\App\Repository\Loan\CommAttribute")
 * @ORM\Table(name="CommAttribute")
 * @ChangeTrackingPolicy("NOTIFY")
 */
class CommAttribute extends DomainObject
{
    use CreatePropertiesArrayTrait;

    protected $ignoreDbProperties = [];

    protected $addUcIdToPropName = ['loan' => null];

    protected $defaultValueProperties = [];

    /** @ORM\Id @ORM\Column(type="integer") @ORM\GeneratedValue **/
    protected $id;

    /**
     * @ORM\OneToOne(targetEntity="\App\Entity\Loan", inversedBy="commAttributes")
     * @ORM\JoinColumn(name="loan_id", referencedColumnName="id", nullable=false)
     * @var \App\Entity\Loan
     **/
    protected $loan;

    /** @ORM\Column(type="decimal", precision=12, scale=8, nullable=true) **/
    protected $dscr;

    /** @ORM\Column(type="decimal", precision=16, scale=4, nullable=true) **/
    protected $noi;

    /** @ORM\Column(type="decimal", precision=12, scale=8, nullable=true) **/
    protected $netWorthToLoan;

    /** @ORM\Column(type="decimal", precision=12, scale=8, nullable=true) **/
    protected $profitRatio;

    /** @ORM\Column(type="decimal", precision=12, scale=8, nullable=true) **/
    protected $loanToCostRatio;

    /** @ORM\Column(type="decimal", precision=12, scale=8, nullable=true) **/
    protected $debtYieldRatio;

    /** @ORM\Column(type="decimal", precision=12, scale=8, nullable=true) **/
    protected $vacancyRate;

    /** @ORM\Column(type="integer", nullable=true)   */
    protected $lockoutPeriod;

    /**
     * @ORM\Column(type = "datetime", nullable=true)
     * @var \DateTime
     **/
    protected $defeasanceDate;

    /** @ORM\Column(type="decimal", precision=12, scale=8, nullable=true) **/
    protected $capRate;

    /**
     * @return mixed
     */
    public function getId() { return $this->id; }

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
     * @return mixed
     */
    public function getDscr() { return $this->dscr; }

    /**
     * @param mixed $dscr
     */
    public function setDscr($dscr)
    {
        $this->implementChange($this, 'dscr', $this->dscr, $dscr);
    }

    /**
     * @return mixed
     */
    public function getNoi() { return $this->noi; }

    /**
     * @param mixed $noi
     */
    public function setNoi($noi)
    {
        $this->implementChange($this, 'noi', $this->noi, $noi);
    }

    /**
     * @return mixed
     */
    public function getNetWorthToLoan() { return $this->netWorthToLoan; }

    /**
     * @param mixed $netWorthToLoan
     */
    public function setNetWorthToLoan($netWorthToLoan)
    {
        $this->implementChange($this, 'netWorthToLoan', $this->netWorthToLoan, $netWorthToLoan);
    }

    /**
     * @return mixed
     */
    public function getProfitRatio() { return $this->profitRatio; }

    /**
     * @param mixed $profitRatio
     */
    public function setProfitRatio($profitRatio)
    {
        $this->implementChange($this, 'profitRatio', $this->profitRatio, $profitRatio);
    }

    /**
     * @return mixed
     */
    public function getLoanToCostRatio() { return $this->loanToCostRatio; }

    /**
     * @param mixed $loanToCostRatio
     */
    public function setLoanToCostRatio($loanToCostRatio)
    {
        $this->implementChange($this, 'loanToCostRatio', $this->loanToCostRatio, $loanToCostRatio);
    }

    /**
     * @return mixed
     */
    public function getDebtYieldRatio() { return $this->debtYieldRatio;}

    /**
     * @param mixed $debtYieldRatio
     */
    public function setDebtYieldRatio($debtYieldRatio)
    {
        $this->implementChange($this, 'debtYieldRatio', $this->debtYieldRatio, $debtYieldRatio);
    }

    /**
     * @return mixed
     */
    public function getVacancyRate() { return $this->vacancyRate; }

    /**
     * @param mixed $vacancyRate
     */
    public function setVacancyRate($vacancyRate)
    {
        $this->implementChange($this, 'vacancyRate', $this->vacancyRate, $vacancyRate);
    }

    /**
     * @return mixed
     */
    public function getLockoutPeriod() { return $this->lockoutPeriod; }

    /**
     * @param mixed $lockoutPeriod
     */
    public function setLockoutPeriod($lockoutPeriod)
    {
        $this->implementChange($this, 'lockoutPeriod', $this->lockoutPeriod, $lockoutPeriod);
    }

    /**
     * @return \DateTime
     */
    public function getDefeasanceDate() {  return $this->defeasanceDate; }

    /**
     * @param \DateTime $defeasanceDate
     */
    public function setDefeasanceDate(\DateTime $defeasanceDate)
    {
        $this->implementChange($this,'defeasanceDate', $this->defeasanceDate, $defeasanceDate);
    }

    /**
     * @return mixed
     */
    public function getCapRate() { return $this->capRate; }

    /**
     * @param mixed $capRate
     */
    public function setCapRate($capRate)
    {
        $this->implementChange($this, 'capRate', $this->capRate, $capRate);
    }


}