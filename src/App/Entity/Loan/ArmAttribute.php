<?php
namespace App\Entity\Loan;


use App\Entity\DomainObject;
use App\Entity\Loan;
use App\Service\CreatePropertiesArrayTrait;
use Doctrine\ORM\Mapping\ChangeTrackingPolicy;
use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity(repositoryClass="\App\Repository\Loan\ArmAttribute")
 * @ORM\Table(name="ArmAttribute")
 * @ORM\ChangeTrackingPolicy("NOTIFY")
 */
class ArmAttribute extends DomainObject
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
     * @ORM\OneToOne(targetEntity="\App\Entity\Loan", inversedBy="armAttributes")
     * @ORM\JoinColumn(name="loan_id", referencedColumnName="id", nullable=false)
     * @var Loan
     **/
    protected $loan;

    /**
     * @ORM\Column(type="decimal", precision=18, scale=15, nullable=true)
     */
    protected float|null $grossMargin = 0.0;

    /**
     * @ORM\Column(type="decimal", precision=18, scale=15, nullable=true) *
     */
    protected float $minimumRate = 0.0;

    /**
     * @ORM\Column(type="decimal", precision=18, scale=15, nullable=true)
     */
    protected float $maximumRate = 0.0;

    /**
     * @ORM\Column(type = "string", nullable=true)
     */
    protected string $rateIndex;

    /**
     * @ORM\Column(type = "integer", nullable=true)
     */
    protected int|null $fstRateAdjPeriod;

    /**
     * @ORM\Column(type = "datetime", nullable=true)
     */
    protected \DateTime|null $fstRateAdjDate;

    /**
     * @ORM\Column(type = "integer", nullable=true)
     */
    protected int|null $fstPmntAdjPeriod;

    /**
     * @ORM\Column(type = "datetime", nullable=true)
     */
    protected \DateTime|null $fstPmntAdjDate;

    /**
     * @ORM\Column(type = "integer", nullable=true)
     */
    protected int|null $rateAdjFrequency;

    /**
     * @ORM\Column(type="decimal", precision=14, scale=2, nullable=true)
     */
    protected float|null $periodicCap;

    /**
     * @ORM\Column(type="decimal", precision=14, scale=2, nullable=true)
     */
    protected float|null $initialCap;

    /**
     * @ORM\Column(type = "integer", nullable=true)
     */
    protected int|null $pmntAdjFrequency;

    /**
     * @ORM\Column(type ="decimal", precision=14, scale=5, nullable=true)
     */
    protected float|null $pmntIncreaseCap;

    /**
     * @return mixed
     */
    public function getId():int
    {
        return $this->id;
    }

    /**
     * @return Loan|null
     */
    public function getLoan():?Loan
    {
        return $this->loan;
    }

    /**
     * @param Loan $loan
     */
    public function setLoan(Loan $loan):void
    {
        $this->implementChange($this,'loan', $this->loan, $loan);
    }

    /**
     * @return float|null
     */
    public function getGrossMargin():?float
    {
        return $this->grossMargin;
    }

    /**
     * @param float $grossMargin
     */
    public function setGrossMargin(float$grossMargin):void
    {
        $this->implementChange($this,'grossMargin', $this->grossMargin, $grossMargin);
    }

    /**
     * @return float|null
     */
    public function getMinimumRate():?float
    {
        return $this->minimumRate;
    }

    /**
     * @param float $minimumRate
     */
    public function setMinimumRate(float $minimumRate):void
    {
        $this->implementChange($this,'minimumRate', $this->minimumRate, $minimumRate);
    }

    /**
     * @return float|null
     */
    public function getMaximumRate():?float
    {
        return $this->maximumRate;
    }

    /**
     * @param mixed $maximumRate
     */
    public function setMaximumRate(float $maximumRate):void
    {
        $this->implementChange($this,'maximumRate', $this->maximumRate, $maximumRate);
    }

    /**
     * @return string
     */
    public function getRateIndex():string
    {
        return $this->rateIndex;
    }

    /**
     * @param string $rateIndex
     */
    public function setRateIndex(string $rateIndex):void
    {
        $this->implementChange($this,'rateIndex', $this->rateIndex, $rateIndex);
    }

    /**
     * @return int|null
     */
    public function getFstRateAdjPeriod():?int
    {
        return $this->fstRateAdjPeriod;
    }

    /**
     * @param int $fstRateAdjPeriod
     */
    public function setFstRateAdjPeriod(int $fstRateAdjPeriod):void
    {
        $this->implementChange($this,'fstRateAdjPeriod', $this->fstRateAdjPeriod, $fstRateAdjPeriod);
    }

    /**
     * @return \DateTime|null
     */
    public function getFstRateAdjDate():?\DateTime
    {
        return $this->fstRateAdjDate;
    }

    /**
     * @param \DateTime $fstRateAdjDate
     */
    public function setFstRateAdjDate(\DateTime $fstRateAdjDate)
    {
        $this->implementChange($this,'fstRateAdjDate', $this->fstRateAdjDate, $fstRateAdjDate);
    }

    /**
     * @return int|null
     */
    public function getFstPmntAdjPeriod():?int
    {
        return $this->fstPmntAdjPeriod;
    }

    /**
     * @param int $fstPmntAdjPeriod
     */
    public function setFstPmntAdjPeriod(int $fstPmntAdjPeriod)
    {
        $this->implementChange($this,'fstPmntAdjPeriod', $this->fstPmntAdjPeriod, $fstPmntAdjPeriod);
    }

    /**
     * @return \DateTime|null
     */
    public function getFstPmntAdjDate():?\DateTime
    {
        return $this->fstPmntAdjDate;
    }

    /**
     * @param \DateTime $fstPmntAdjDate
     */
    public function setFstPmtAdjDate(\DateTime $fstPmntAdjDate):void
    {
        $this->implementChange($this,'fstPmntAdjDate', $this->fstPmntAdjDate, $fstPmntAdjDate);
    }

    /**
     * @return int|null
     */
    public function getRateAdjFrequency():?int
    {
        return $this->rateAdjFrequency;
    }

    /**
     * @param int $rateAdjFrequency
     */
    public function setRateAdjFrequency(int $rateAdjFrequency):void
    {
        $this->implementChange($this,'rateAdjFrequency', $this->rateAdjFrequency, $rateAdjFrequency);
    }

    /**
     * @return float|null
     */
    public function getPeriodicCap():?float
    {
        return $this->periodicCap;
    }

    /**
     * @param float $periodicCap
     */
    public function setPeriodicCap(float $periodicCap)
    {
        $this->implementChange($this,'periodicCap', $this->periodicCap, $periodicCap);
    }

    /**
     * @return float|null
     */
    public function getInitialCap():?float
    {
        return $this->initialCap;
    }

    /**
     * @param float $initialCap
     */
    public function setInitialCap(float $initialCap):void
    {
        $this->implementChange($this,'initialCap', $this->initialCap, $initialCap);
    }

    /**
     * @return int|null
     */
    public function getPmntAdjFrequency():?int
    {
        return $this->pmntAdjFrequency;
    }

    /**
     * @param int $pmntAdjFrequency
     */
    public function setPmntAdjFrequency(int $pmntAdjFrequency):void
    {
        $this->implementChange($this,'pmntAdjFrequency', $this->pmntAdjFrequency, $pmntAdjFrequency);
    }

    /**
     * @return float|null
     */
    public function getPmntIncreaseCap():?float
    {
        return $this->pmntIncreaseCap;
    }

    /**
     * @param float  $pmntIncreaseCap
     */
    public function setPmntIncreaseCap(float $pmntIncreaseCap):void
    {
        $this->implementChange($this,'pmntIncreaseCap', $this->pmntIncreaseCap, $pmntIncreaseCap);
    }
}