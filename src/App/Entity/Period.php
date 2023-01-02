<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 */

namespace App\Entity;

use App\Service\CreatePropertiesArrayTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping\ChangeTrackingPolicy;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\PersistentCollection;

/**
 *
 * @ORM\Entity
 * @ORM\Table(name="Period")
 * @ORM\ChangeTrackingPolicy("NOTIFY")
 *
 */
class Period extends DomainObject
{
    use CreatePropertiesArrayTrait;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue *
     */
    protected int $id;

    /**
     * @ORM\Column(type="integer")
     * @var int
     */
    protected int $periodIndex;

    /**
     * @ORM\Column(type="datetime")
     * @var \DateTime
     **/
    protected $reportDate;

    /**
     * @ORM\Column(type="integer")
     * @var int
     */
    protected int $isHistorical = 0;

    /**
     * @ORM\Column(type="integer")
     * @var int
     */
    protected int $allParamsSet = 0;

    /**
     * @ORM\OneToMany(targetEntity="\App\Entity\Update\PoolUpdate", mappedBy="period")
     * @var PersistentCollection|ArrayCollection|null
     **/
    protected $poolUpdates;

    /**
     * @ORM\OneToMany(targetEntity="\App\Entity\Update\LoanUpdate", mappedBy="period")
     * @var PersistentCollection|ArrayCollection|null
     **/
    protected $loanUpdates;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\Deal", inversedBy="periods")
     * @var ?Deal
     **/
    protected $deal;

    /**
     * @ORM\OneToMany(targetEntity="\App\Entity\Update\BondUpdate", mappedBy="period")
     * @var PersistentCollection|ArrayCollection|null
     **/
    protected $bondUpdates;

    /**
     * @ORM\OneToMany(targetEntity="\App\Entity\Typed\Update\FeeUpdate", mappedBy="period")
     *  @var PersistentCollection|ArrayCollection|null
     **/
    protected $fees;

    /**
     * @ORM\OneToMany(targetEntity="\App\Entity\Typed\Update\AccountUpdate", mappedBy="period")
     *  @var PersistentCollection|ArrayCollection|null
     **/
    protected $accounts;

    /**
     * @ORM\OneToMany(targetEntity="\App\Entity\Typed\Update\ShelfSpecificUpdate", mappedBy="period")
     *  @var PersistentCollection|ArrayCollection|null
     */
    protected $shelfSpecifics;

    /**
     * @ORM\OneToMany(targetEntity="\App\Entity\Typed\Update\TriggerUpdate", mappedBy="period")
     *  @var PersistentCollection|ArrayCollection|null
     **/
    protected $triggers;


    public function __construct()
    {
        $this->poolUpdates = new ArrayCollection();
        $this->bondUpdates = new ArrayCollection();
        //$this->periodFees = new ArrayCollection();
        //$this->periodAccounts = new ArrayCollection();
        //$this->periodShelfSpecifics = new ArrayCollection();
        //$this->periodTriggers = new ArrayCollection();
        parent::__construct();
    }

    /**
     * @return int
     */
    public function getId():int
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getPeriodIndex():int
    {
        return $this->periodIndex;
    }

    /** @param int $periodIndex */
    public function setPeriodIndex (int $periodIndex):void
    {
        $this->implementChange($this, 'periodIndex', $this->periodIndex, $periodIndex);
    }

    /**
     * @return \DateTime
     */
    public function getReportDate():\DateTime
    {
        return $this->reportDate;
    }

    /**
     * @param \DateTime $reportDate
     */
    public function setReportDate (\DateTime $reportDate):void
    {
        $this->implementChange($this,'reportDate', $this->reportDate, $reportDate);
    }

    /**
     * @return int
     */
    public function getIsHistorical():int
    {
        return $this->isHistorical;
    }

    /**
     * @return int
     */
    public function getAllParamsSet():int
    {
        return $this->allParamsSet;
    }

    /**
     * @return PersistentCollection|ArrayCollection|null
     */
    public function getPoolUpdates():PersistentCollection|ArrayCollection|null
    {
        return $this->poolUpdates;
    }

    public function addPoolUpdate($poolUpdate){

    }

    /**
     * @return ?Deal
     */
    public function getDeal():?Deal
    {
        return $this->deal;
    }

    /**
     * @return PersistentCollection|ArrayCollection|null
     */
    public function getBondUpdates():PersistentCollection|ArrayCollection|null
    {
        return $this->bondUpdates;
    }
}