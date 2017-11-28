<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 */

namespace App\Entity;

use App\Service\CreatePropertiesArrayTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\NotifyPropertyChanged;
use Doctrine\ORM\Mapping\ChangeTrackingPolicy;
use Doctrine\ORM\Mapping as ORM;

/**
 *
 * @ORM\Entity
 * @ORM\Table(name="Period")
 * @ORM\ChangeTrackingPolicy("NOTIFY")
 *
 */
class Period implements NotifyPropertyChanged
{
    use NotifyChangeTrait, CreatePropertiesArrayTrait;

    /** @ORM\Id @ORM\Column(type="integer") @ORM\GeneratedValue **/
    protected $id;

    /** @ORM\Column(type="integer") **/
    protected $periodIndex;

    /**
     * @ORM\Column(type="datetime")
     * @var \DateTime
     **/
    protected $reportDate;

    /** @ORM\Column(type="integer") **/
    protected $isHistorical = 0;

    /** @ORM\Column(type="integer") **/
    protected $allParamsSet = 0;

    /**
     * @ORM\OneToMany(targetEntity="\App\Entity\Update\PoolUpdate", mappedBy="period")
     * @var ArrayCollection
     **/
    protected $poolUpdates;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\Deal", inversedBy="periods")
     * @var \App\Entity\Deal
     **/
    protected $deal;

    /** @ORM\OneToMany(targetEntity="\App\Entity\Update\BondUpdate", mappedBy="period")
     * @var ArrayCollection
     **/
    protected $bondUpdates;

    /**
     * @var ArrayCollection $periodFees
     * @ORM\OneToMany(targetEntity="\App\Entity\Typed\Update\FeeUpdate", mappedBy="period") **/
    protected $fees;

    /**
     * @var ArrayCollection $periodRequiredAccounts
     * @ORM\OneToMany(targetEntity="\App\Entity\Typed\Update\AccountUpdate", mappedBy="period") **/
    protected $accounts;

    /**
     * @var ArrayCollection $periodShelfSpecifics
     * @ORM\OneToMany(targetEntity="\App\Entity\Typed\Update\ShelfSpecificUpdate", mappedBy="period")
     */
    protected $shelfSpecifics;

    /**
     * @var ArrayCollection $periodTriggers
     * @ORM\OneToMany(targetEntity="\App\Entity\Typed\Update\TriggerUpdate", mappedBy="period") **/
    protected $triggers;


    public function __construct()
    {
        $this->poolUpdates = new ArrayCollection();
        $this->bondUpdates = new ArrayCollection();
        //$this->periodFees = new ArrayCollection();
        //$this->periodAccounts = new ArrayCollection();
        //$this->periodShelfSpecifics = new ArrayCollection();
        //$this->periodTriggers = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getPeriodIndex()
    {
        return $this->periodIndex;
    }

    /** @param int $periodIndex */
    public function setPeriodIndex ($periodIndex)
    {
        $this->_onPropertyChanged('periodIndex', $this->periodIndex, $periodIndex);
        $this->periodIndex = $periodIndex;
    }

    /**
     * @return mixed
     */
    public function getReportDate()
    {
        return $this->reportDate;
    }

    /**
     * @param \DateTime $reportDate
     */
    public function setReportDate (\DateTime $reportDate)
    {
        $this->_onPropertyChanged('reportDate', $this->reportDate, $reportDate);
        $this->reportDate = $reportDate;
    }

    /**
     * @return mixed
     */
    public function getIsHistorical()
    {
        return $this->isHistorical;
    }

    /**
     * @return mixed
     */
    public function getAllParamsSet()
    {
        return $this->allParamsSet;
    }

    /**
     * @return ArrayCollection
     */
    public function getPoolUpdates()
    {
        return $this->poolUpdates;
    }

    public function addPoolUpdate($poolUpdate){

    }

    /**
     * @return mixed
     */
    public function getDeal()
    {
        return $this->deal;
    }

    /**
     * @return ArrayCollection
     */
    public function getBondUpdates()
    {
        return $this->bondUpdates;
    }
}