<?php
namespace App\Entity\Loan;


use App\Entity\DomainObject;
use App\Entity\Loan;
use App\Entity\NotifyChangeTrait;
use App\Service\CreatePropertiesArrayTrait;
use Doctrine\Common\NotifyPropertyChanged;
use Doctrine\ORM\Mapping\ChangeTrackingPolicy;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="\App\Repository\Loan\ArmAttribute")
 * @ORM\Table(name="ArmAttribute")
 * @ChangeTrackingPolicy("NOTIFY")
 */
class ArmAttribute extends DomainObject
{
    use CreatePropertiesArrayTrait;

    protected $ignoreDbProperties = [];

    protected $addUcIdToPropName = ['loan' => null];

    protected $defaultValueProperties = [];

    /** @ORM\Id @ORM\Column(type="integer") @ORM\GeneratedValue **/
    protected $id;

    /**
     * @ORM\OneToOne(targetEntity="\App\Entity\Loan", inversedBy="armAttributes")
     * @ORM\JoinColumn(name="loan_id", referencedColumnName="id", nullable=false)
     * @var \App\Entity\Loan
     **/
    protected $loan;

    /** @ORM\Column(type="decimal", precision=18, scale=15, nullable=true) **/
    protected $grossMargin;

    /** @ORM\Column(type="decimal", precision=18, scale=15, nullable=true) **/
    protected $minimumRate;

    /** @ORM\Column(type="decimal", precision=18, scale=15, nullable=true) **/
    protected $maximumRate;

    /** @ORM\Column(type = "string", nullable=true) **/
    protected $rateIndex;

    /** @ORM\Column(type = "integer", nullable=true) **/
    protected $fstRateAdjPeriod;

    /** @ORM\Column(type = "datetime", nullable=true) **/
    protected $fstRateAdjDate;

    /** @ORM\Column(type = "integer", nullable=true) **/
    protected $fstPmntAdjPeriod;

    /** @ORM\Column(type = "datetime", nullable=true) **/
    protected $fstPmntAdjDate;

    /** @ORM\Column(type = "integer", nullable=true) **/
    protected $rateAdjFrequency;

    /** @ORM\Column(type="decimal", precision=14, scale=2, nullable=true) **/
    protected $periodicCap;

    /** @ORM\Column(type="decimal", precision=14, scale=2, nullable=true) **/
    protected $initialCap;

    /** @ORM\Column(type = "integer", nullable=true) **/
    protected $pmntAdjFrequency;

    /** @ORM\Column(type ="decimal", precision=14, scale=5, nullable=true) **/
    protected $pmntIncreaseCap;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Loan
     */
    public function getLoan()
    {
        return $this->loan;
    }

    /**
     * @param \App\Entity\Loan $loan
     */
    public function setLoan(Loan $loan)
    {
        $this->implementChange($this,'loan', $this->loan, $loan);
    }

    /**
     * @return mixed
     */
    public function getGrossMargin()
    {
        return $this->grossMargin;
    }

    /**
     * @param mixed $grossMargin
     */
    public function setGrossMargin($grossMargin)
    {
        $this->implementChange($this,'grossMargin', $this->grossMargin, $grossMargin);
    }

    /**
     * @return mixed
     */
    public function getMinimumRate()
    {
        return $this->minimumRate;
    }

    /**
     * @param mixed $minimumRate
     */
    public function setMinimumRate($minimumRate)
    {
        $this->implementChange($this,'minimumRate', $this->minimumRate, $minimumRate);
    }

    /**
     * @return mixed
     */
    public function getMaximumRate()
    {
        return $this->maximumRate;
    }

    /**
     * @param mixed $maximumRate
     */
    public function setMaximumRate($maximumRate)
    {
        $this->implementChange($this,'maximumRate', $this->maximumRate, $maximumRate);
    }

    /**
     * @return mixed
     */
    public function getRateIndex()
    {
        return $this->rateIndex;
    }

    /**
     * @param mixed $rateIndex
     */
    public function setRateIndex($rateIndex)
    {
        $this->implementChange($this,'rateIndex', $this->rateIndex, $rateIndex);
    }

    /**
     * @return mixed
     */
    public function getFstRateAdjPeriod()
    {
        return $this->fstRateAdjPeriod;
    }

    /**
     * @param mixed $fstRateAdjPeriod
     */
    public function setFstRateAdjPeriod($fstRateAdjPeriod)
    {
        $this->implementChange($this,'fstRateAdjPeriod', $this->fstRateAdjPeriod, $fstRateAdjPeriod);
    }

    /**
     * @return mixed
     */
    public function getFstRateAdjDate()
    {
        return $this->fstRateAdjDate;
    }

    /**
     * @param mixed $fstRateAdjDate
     */
    public function setFstRateAdjDate($fstRateAdjDate)
    {
        $this->implementChange($this,'fstRateAdjDate', $this->fstRateAdjDate, $fstRateAdjDate);
    }

    /**
     * @return mixed
     */
    public function getFstPmntAdjPeriod()
    {
        return $this->fstPmntAdjPeriod;
    }

    /**
     * @param mixed $fstPmntAdjPeriod
     */
    public function setFstPmntAdjPeriod($fstPmntAdjPeriod)
    {
        $this->implementChange($this,'fstPmntAdjPeriod', $this->fstPmntAdjPeriod, $fstPmntAdjPeriod);
    }

    /**
     * @return mixed
     */
    public function getFstPmntAdjDate()
    {
        return $this->fstPmntAdjDate;
    }

    /**
     * @param mixed $fstPmntAdjDate
     */
    public function setFstPmtAdjDate($fstPmntAdjDate)
    {
        $this->implementChange($this,'fstPmntAdjDate', $this->fstPmntAdjDate, $fstPmntAdjDate);
    }

    /**
     * @return mixed
     */
    public function getRateAdjFrequency()
    {
        return $this->rateAdjFrequency;
    }

    /**
     * @param mixed $rateAdjFrequency
     */
    public function setRateAdjFrequency($rateAdjFrequency)
    {
        $this->implementChange($this,'rateAdjFrequency', $this->rateAdjFrequency, $rateAdjFrequency);
    }

    /**
     * @return mixed
     */
    public function getPeriodicCap()
    {
        return $this->periodicCap;
    }

    /**
     * @param mixed $periodicCap
     */
    public function setPeriodicCap($periodicCap)
    {
        $this->implementChange($this,'periodicCap', $this->periodicCap, $periodicCap);
    }

    /**
     * @return mixed
     */
    public function getInitialCap()
    {
        return $this->initialCap;
    }

    /**
     * @param mixed $initialCap
     */
    public function setInitialCap($initialCap)
    {
        $this->implementChange($this,'initialCap', $this->initialCap, $initialCap);
    }

    /**
     * @return mixed
     */
    public function getPmntAdjFrequency()
    {
        return $this->pmntAdjFrequency;
    }

    /**
     * @param mixed $pmntAdjFrequency
     */
    public function setPmntAdjFrequency($pmntAdjFrequency)
    {
        $this->implementChange($this,'pmntAdjFrequency', $this->pmntAdjFrequency, $pmntAdjFrequency);
    }

    /**
     * @return mixed
     */
    public function getPmntIncreaseCap()
    {
        return $this->pmntIncreaseCap;
    }

    /**
     * @param mixed $pmntIncreaseCap
     */
    public function setPmntIncreaseCap($pmntIncreaseCap)
    {
        $this->implementChange($this,'pmntIncreaseCap', $this->pmntIncreaseCap, $pmntIncreaseCap);
    }
}