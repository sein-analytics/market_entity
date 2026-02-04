<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 */

namespace App\Entity;

use \App\Entity\Update\PoolUpdate;
use \App\Entity\Typed\ShelfSpecific\PoolSpecific;
use \App\Entity\Typed\Fee\PoolFee;
use \App\Entity\Typed\Account\PoolAccount;
use \App\Entity\Typed\Trigger\PoolTrigger;
use Exception;
use App\Service\CreatePropertiesArrayTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping\ChangeTrackingPolicy;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\PersistentCollection;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks as HasLifecycleCallbacks;

#[ORM\Table(name: 'Pool')]
#[ORM\Entity(repositoryClass: \App\Repository\Pool::class)]
#[ORM\ChangeTrackingPolicy('NOTIFY')]
#[HasLifecycleCallbacks]
class Pool extends DomainObject
{
    use CreatePropertiesArrayTrait;

    protected array $ignoreDbProperties = [
        'bonds' => null, 'loans' => null, 'accounts' => null, 'specifics' => null,
        'triggers' => null, 'fees' => null, 'latestPeriod' => 'null'
    ];

    protected array $addUcIdToPropName = [
        'deal' => null,
    ];

    protected array $defaultValueProperties = [
        'poolStructure' => null,
        'isCrossed' => null,
        'isPoGroup' => null,
        'isIoGroup' => null,
        'addReserveToCredit' => null,
    ];

    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    protected int $id;

    /**
     * @var ?Deal
     **/
    #[ORM\ManyToOne(targetEntity:  \App\Entity\Deal::class, inversedBy: 'pools')]
    protected $deal;

    /**
     * @var PersistentCollection|ArrayCollection|null
     **/
    #[ORM\OneToMany(targetEntity:  \App\Entity\Loan::class, mappedBy: 'pool')]
    protected $loans;

    /**
     * @var PersistentCollection|ArrayCollection|null
     **/
    #[ORM\OneToMany(targetEntity:  \App\Entity\Bond::class, mappedBy: 'pool', fetch: 'LAZY')]
    protected $bonds;

    /**
     * @var int
     */
    #[ORM\Column(type: 'integer')]
    protected int $bondsCount = 0;

    /**
     * @var float
     */
    #[ORM\Column(type: 'float', precision: 14, scale: 2)]
    protected float $bondsTotalBalance = 0.0;

    /**
     * @var float
     */
    #[ORM\Column(type: 'float', precision: 14, scale: 2)]
    protected float $loanTotalBalance = 0.0;

    /**
     * @var int
     */
    #[ORM\Column(type: 'integer')]
    protected int $loansCount = 0;

    /**
     * @var float
     */
    #[ORM\Column(type: 'float', precision: 14, scale: 2)]
    protected float $originalBalance=0.0;

    /**
     * @var ?string
     */
    #[ORM\Column(type: 'string', nullable: true)]
    protected ?string $poolStructure;

    /**
     * @var bool
     * **/
    #[ORM\Column(type: 'boolean', nullable: false)]
    protected bool $isCrossed = false;

    /**
     * @var bool
     **/
    #[ORM\Column(type: 'boolean', nullable: false)]
    protected bool $isPogroup = false;

    /**
     * @var bool
     **/
    #[ORM\Column(type: 'boolean', nullable: false)]
    protected bool $isIoGroup = false;

    /**
     * @var bool
     */
    #[ORM\Column(type: 'boolean', nullable: false)]
    protected bool $addReserveToCreditSupport = false;
    
    /**
     * @var PersistentCollection|ArrayCollection|null
     **/
    #[ORM\OneToMany(targetEntity: PoolUpdate::class, mappedBy: 'pool', fetch: 'LAZY')]
    protected $poolUpdates;

    /**
     * @var PersistentCollection|ArrayCollection|null
     */
    #[ORM\ManyToMany(targetEntity: PoolSpecific::class, mappedBy: 'pools')]
    protected $specifics;

    /**
     * @var PersistentCollection|ArrayCollection|null
     */
    #[ORM\ManyToMany(targetEntity: PoolFee::class, mappedBy: 'pools')]
    protected $fees;

    /**
     * @var PersistentCollection|ArrayCollection|null
     */
    #[ORM\ManyToMany(targetEntity: PoolAccount::class, mappedBy: 'pools')]
    protected $accounts;

    /**
     * @var PersistentCollection|ArrayCollection|null
     */
    #[ORM\ManyToMany(targetEntity: PoolTrigger::class, mappedBy: 'pools')]
    protected $triggers;

    public function __construct()
    {
        $this->loans        = new ArrayCollection();
        $this->bonds        = new ArrayCollection();
        $this->poolUpdates  = new  ArrayCollection();
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
     * @return ?Deal
     */
    public function getDeal():?Deal
    {
        return $this->deal;
    }

    /**
     * @param Deal $deal
     */
    public function setDeal(Deal $deal):void
    {
        $this->implementChange($this,'deal', $this->deal, $deal);
    }

    /**
     * @return PersistentCollection|ArrayCollection|null
     */
    public function getLoans():PersistentCollection|ArrayCollection|null
    {
        return $this->loans;
    }

    /**
     * @param Loan $loan
     * @return $this
     * @throws Exception
     */
    public function addLoan(Loan $loan)
    {
        $loanId = $loan->getId();
        if(!isset($loanId)) {
            throw new Exception("Cannot add a loan to pool with out ID");
        }
        $coll = $this->getLoans()->filter(function(Loan $ln) use($loan){
            return ($ln->getLoanId() === $loan->getLoanId());
        });
        if($coll->count() == 0){
            $this->getLoans()->add($loan);
        }
        return $this;
    }

    /**
     * @return PersistentCollection|ArrayCollection|null
     */
    public function getBonds():PersistentCollection|ArrayCollection|null
    {
        return $this->bonds;
    }

    /**
     * @param Bond $bond
     */
    public function addBond(Bond $bond)
    {
        $this->setBondsCount($this->bondsCount + 1);
        $this->setBondsTotalBalance($this->bondsTotalBalance + $bond->getOriginalBalance());
        $bond->setPool($this);
        $this->bonds->add($bond);
    }

    //public function addPoolUpdate()

    /**
     * @return int
     */
    public function getBondsCount():int
    {
        return $this->bondsCount;
    }

    /**
     * @param int $bondsCount
     */
    public function setBondsCount(int $bondsCount):void
    {
        $this->implementChange($this,'bondsCount', $this->bondsCount, $bondsCount);
    }

    /**
     * @return float
     */
    public function getBondsTotalBalance():float
    {
        return $this->bondsTotalBalance;
    }

    /**
     * @param float $bondsTotalBalance
     */
    public function setBondsTotalBalance(float $bondsTotalBalance):void
    {
        $this->implementChange($this,'bondsTotalBalance', $this->bondsTotalBalance, $bondsTotalBalance);
    }

    /**
     * @return float
     */
    public function getLoanTotalBalance():float
    {
        return $this->loanTotalBalance;
    }

    /**
     * @param float $loanTotalBalance
     */
    public function setLoanTotalBalance(float $loanTotalBalance):void
    {
        $this->implementChange($this,'loanTotalBalance', $this->loanTotalBalance, $loanTotalBalance);
    }

    /**
     * @return int
     */
    public function getLoansCount():int
    {
        return $this->loansCount;
    }

    /**
     * @param int $loansCount
     */
    public function setLoansCount(int $loansCount):void
    {
        $this->implementChange($this,'loansCount', $this->loansCount, $loansCount);
    }

    /**
     * @return float
     */
    public function getOriginalBalance():float
    {
        return $this->originalBalance;
    }

    /**
     * @param float $originalBalance
     */
    public function setOriginalBalance(float $originalBalance):void
    {
        $this->implementChange($this,'originalBalance', $this->originalBalance, $originalBalance);
    }

    /**
     * @return ?string
     */
    public function getPoolStructure():?string
    {
        return $this->poolStructure;
    }

    /**
     * @param string $poolStructure
     */
    public function setPoolStructure(string $poolStructure):void
    {
        $this->implementChange($this,'poolStructure', $this->poolStructure, $poolStructure);
    }

    /**
     * @return bool
     */
    public function getIsCrossed():bool { return $this->isCrossed; }

    /**
     * @param bool $isCrossed
     */
    public function setIsCrossed(bool $isCrossed):void
    {
        $this->implementChange($this,'isCrossed', $this->isCrossed, $isCrossed);
    }

    /**
     * @return bool
     */
    public function getIsPogroup():bool { return $this->isPogroup; }

    /**
     * @param bool $isPogroup
     */
    public function setIsPogroup(bool $isPogroup):void
    {
        $this->implementChange($this,'isPogroup', $this->isPogroup, $isPogroup);
    }

    /**
     * @return bool
     */
    public function getIsIoGroup():bool { return $this->isIoGroup; }

    /**
     * @param bool $isIoGroup
     */
    public function setIsIoGroup(bool $isIoGroup):void
    {
        $this->implementChange($this,'isIoGroup', $this->isIoGroup, $isIoGroup);
    }

    /**
     * @return bool
     */
    public function getAddReserveToCreditSupport():bool { return $this->addReserveToCreditSupport; }

    /**
     * @param bool $addReserveToCreditSupport
     */
    public function setAddReserveToCreditSupport(bool $addReserveToCreditSupport):void
    {
        $this->implementChange($this,'addReserveToCreditSupport', $this->addReserveToCreditSupport, $addReserveToCreditSupport);
    }
    
    
}