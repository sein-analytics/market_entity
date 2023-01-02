<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 */

namespace App\Entity;

use App\Service\CreatePropertiesArrayTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\OneToOne;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\ManyToMany;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\JoinColumns;
use Doctrine\ORM\Mapping\JoinTable;
use Doctrine\ORM\Mapping\GeneratedValue;

use Doctrine\ORM\Mapping\DiscriminatorColumn;
use Doctrine\ORM\Mapping\DiscriminatorMap;

use Doctrine\ORM\Mapping\Index;
use Doctrine\ORM\Mapping\ChangeTrackingPolicy;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\PersistentCollection;

/**
 *
 * \Doctrine\ORM\Mapping\Entity
 * \Doctrine\ORM\Mapping\Table(name="Period")
 * \Doctrine\ORM\Mapping\ChangeTrackingPolicy("NOTIFY")
 *
 */
class Period extends DomainObject
{
    use CreatePropertiesArrayTrait;

    /**
     * \Doctrine\ORM\Mapping\Id
     * \Doctrine\ORM\Mapping\Column(type="integer")
     * \Doctrine\ORM\Mapping\GeneratedValue *
     */
    protected int $id;

    /**
     * \Doctrine\ORM\Mapping\Column(type="integer")
     * @var int
     */
    protected int $periodIndex;

    /**
     * \Doctrine\ORM\Mapping\Column(type="datetime")
     * @var \DateTime
     **/
    protected $reportDate;

    /**
     * \Doctrine\ORM\Mapping\Column(type="integer")
     * @var int
     */
    protected int $isHistorical = 0;

    /**
     * \Doctrine\ORM\Mapping\Column(type="integer")
     * @var int
     */
    protected int $allParamsSet = 0;

    /**
     * \Doctrine\ORM\Mapping\OneToMany(targetEntity="\App\Entity\Update\PoolUpdate", mappedBy="period")
     * @var PersistentCollection|ArrayCollection|null
     **/
    protected $poolUpdates;

    /**
     * \Doctrine\ORM\Mapping\OneToMany(targetEntity="\App\Entity\Update\LoanUpdate", mappedBy="period")
     * @var PersistentCollection|ArrayCollection|null
     **/
    protected $loanUpdates;

    /**
     * \Doctrine\ORM\Mapping\ManyToOne(targetEntity="\App\Entity\Deal", inversedBy="periods")
     * @var ?Deal
     **/
    protected $deal;

    /**
     * \Doctrine\ORM\Mapping\OneToMany(targetEntity="\App\Entity\Update\BondUpdate", mappedBy="period")
     * @var PersistentCollection|ArrayCollection|null
     **/
    protected $bondUpdates;

    /**
     * \Doctrine\ORM\Mapping\OneToMany(targetEntity="\App\Entity\Typed\Update\FeeUpdate", mappedBy="period")
     *  @var PersistentCollection|ArrayCollection|null
     **/
    protected $fees;

    /**
     * \Doctrine\ORM\Mapping\OneToMany(targetEntity="\App\Entity\Typed\Update\AccountUpdate", mappedBy="period")
     *  @var PersistentCollection|ArrayCollection|null
     **/
    protected $accounts;

    /**
     * \Doctrine\ORM\Mapping\OneToMany(targetEntity="\App\Entity\Typed\Update\ShelfSpecificUpdate", mappedBy="period")
     *  @var PersistentCollection|ArrayCollection|null
     */
    protected $shelfSpecifics;

    /**
     * \Doctrine\ORM\Mapping\OneToMany(targetEntity="\App\Entity\Typed\Update\TriggerUpdate", mappedBy="period")
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