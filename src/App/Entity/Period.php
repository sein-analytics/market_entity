<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 */

namespace App\Entity;

use \App\Entity\Update\PoolUpdate;
use \App\Entity\Update\LoanUpdate;
use \App\Entity\Update\BondUpdate;
use \App\Entity\Typed\Update\FeeUpdate;
use \App\Entity\Typed\Update\AccountUpdate;
use \App\Entity\Typed\Update\ShelfSpecificUpdate;
use \App\Entity\Typed\Update\TriggerUpdate;
use DateTime;
use App\Service\CreatePropertiesArrayTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping\ChangeTrackingPolicy;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\PersistentCollection;

#[ORM\Table(name: 'Period')]
#[ORM\Entity]
#[ORM\ChangeTrackingPolicy('NOTIFY')]
class Period extends DomainObject
{
    use CreatePropertiesArrayTrait;

    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    protected int $id;

    /**
     * @var int
     */
    #[ORM\Column(type: 'integer')]
    protected int $periodIndex;

    /**
     * @var DateTime
     **/
    #[ORM\Column(type: 'datetime')]
    protected $reportDate;

    /**
     * @var int
     */
    #[ORM\Column(type: 'integer')]
    protected int $isHistorical = 0;

    /**
     * @var int
     */
    #[ORM\Column(type: 'integer')]
    protected int $allParamsSet = 0;

    /**
     * @var PersistentCollection|ArrayCollection|null
     **/
    #[ORM\OneToMany(targetEntity: PoolUpdate::class, mappedBy: 'period')]
    protected $poolUpdates;

    /**
     * @var PersistentCollection|ArrayCollection|null
     **/
    #[ORM\OneToMany(targetEntity: LoanUpdate::class, mappedBy: 'period')]
    protected $loanUpdates;

    /**
     * @var ?Deal
     **/
    #[ORM\ManyToOne(targetEntity:  Deal::class, inversedBy: 'periods')]
    protected $deal;

    /**
     * @var PersistentCollection|ArrayCollection|null
     **/
    #[ORM\OneToMany(targetEntity: BondUpdate::class, mappedBy: 'period')]
    protected $bondUpdates;

    /** @var PersistentCollection|ArrayCollection|null
     **/
    #[ORM\OneToMany(targetEntity: FeeUpdate::class, mappedBy: 'period')]
    protected $fees;

    /** @var PersistentCollection|ArrayCollection|null
     **/
    #[ORM\OneToMany(targetEntity: AccountUpdate::class, mappedBy: 'period')]
    protected $accounts;

    /** @var PersistentCollection|ArrayCollection|null
     */
    #[ORM\OneToMany(targetEntity: ShelfSpecificUpdate::class, mappedBy: 'period')]
    protected $shelfSpecifics;

    /** @var PersistentCollection|ArrayCollection|null
     **/
    #[ORM\OneToMany(targetEntity: TriggerUpdate::class, mappedBy: 'period')]
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
     * @return DateTime
     */
    public function getReportDate():DateTime
    {
        return $this->reportDate;
    }

    /**
     * @param DateTime $reportDate
     */
    public function setReportDate (DateTime $reportDate):void
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