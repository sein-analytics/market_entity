<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\NotifyPropertyChanged;
use Doctrine\ORM\Mapping\ChangeTrackingPolicy;
/**
 * @ORM\Entity
 * @ORM\Table(name="Pool")
 * @ChangeTrackingPolicy("NOTIFY")
 * @ORM\HasLifeCycleCallbacks
 */
class Pool implements NotifyPropertyChanged
{
    use NotifyChangeTrait;

    /**
     * @ORM\Id @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     **/
    protected $id;

    /** @ORM\ManyToOne(targetEntity="\App\Entity\Deal", inversedBy="pools")
     * @var \App\Entity\Deal
     **/
    protected $deal;

    /** 
     * @ORM\OneToMany(targetEntity="\App\Entity\Loan", mappedBy="pool")
     * @var ArrayCollection
     **/
    protected $loans;

    /** 
     * @ORM\OneToMany(targetEntity="\App\Entity\Bond", mappedBy="pool", fetch="LAZY")
     * @var ArrayCollection 
     **/
    protected $bonds;

    /** @ORM\Column(type="integer") **/
    protected $bondsCount = 0;

    /** @ORM\Column(type="decimal", precision=14, scale=2) **/
    protected $bondsTotalBalance = 0;

    /** @ORM\Column(type = "decimal", precision=14, scale=2) **/
    protected $loanTotalBalance = 0;

    /** @ORM\Column(type = "integer") **/
    protected $loansCount = 0;

    /** @ORM\Column(type="decimal", precision=14, scale=2) **/
    protected $originalBalance;

    /** @ORM\Column(type="string", nullable=true) */
    protected $poolStructure;

    /** @ORM\Column(type = "boolean") **/
    protected $isCrossed = false;

    /** @ORM\Column(type="integer", nullable=true) **/
    protected $isPogroup;

    /** @ORM\Column(type="integer", nullable=true) **/
    protected $isIoGroup;

    /** @ORM\Column(type="integer", nullable=true) */
    protected $addReserveToCreditSupport;
    
    /** 
     * @ORM\OneToMany(targetEntity="\App\Entity\Update\PoolUpdate", mappedBy="pool", fetch="LAZY")
     * @var ArrayCollection 
     **/
    protected $poolUpdates;

    /** @ORM\ManyToMany(targetEntity="\App\Entity\Typed\ShelfSpecific\PoolSpecific", mappedBy="pools")   */
    protected $specifics;

    /** @ORM\ManyToMany(targetEntity="\App\Entity\Typed\Fee\PoolFee", mappedBy="pools")   */
    protected $fees;

    /** @ORM\ManyToMany(targetEntity="\App\Entity\Typed\Account\PoolAccount", mappedBy="pools")   */
    protected $accounts;

    /** @ORM\ManyToMany(targetEntity="\App\Entity\Typed\Trigger\PoolTrigger", mappedBy="pools")   */
    protected $triggers;

    public function __construct()
    {
        $this->loans        = new ArrayCollection();
        $this->bonds        = new ArrayCollection();
        $this->poolUpdates  = new  ArrayCollection();
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
    public function getDeal()
    {
        return $this->deal;
    }

    /**
     * @param mixed $deal
     */
    public function setDeal($deal)
    {
        $this->_onPropertyChanged('deal', $this->deal, $deal);
        $this->deal = $deal;
    }

    /**
     * @return ArrayCollection
     */
    public function getLoans()
    {
        return $this->loans;
    }

    /**
     * @param Loan $loan
     * @return $this
     * @throws \Exception
     */
    public function addLoan(Loan $loan)
    {
        $loanId = $loan->getId();
        if(!isset($loanId)) {
            throw new \Exception("Cannot add a loan to pool with out ID");
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
     * @return mixed
     */
    public function getBonds()
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
     * @return mixed
     */
    public function getBondsCount()
    {
        return $this->bondsCount;
    }

    /**
     * @param mixed $bondsCount
     */
    public function setBondsCount($bondsCount)
    {
        $this->_onPropertyChanged('bondsCount', $this->bondsCount, $bondsCount);
        $this->bondsCount = $bondsCount;
    }

    /**
     * @return mixed
     */
    public function getBondsTotalBalance()
    {
        return $this->bondsTotalBalance;
    }

    /**
     * @param mixed $bondsTotalBalance
     */
    public function setBondsTotalBalance($bondsTotalBalance)
    {
        $this->_onPropertyChanged('bondsTotalBalance', $this->bondsTotalBalance, $bondsTotalBalance);
        $this->bondsTotalBalance = $bondsTotalBalance;
    }

    /**
     * @return mixed
     */
    public function getLoanTotalBalance()
    {
        return $this->loanTotalBalance;
    }

    /**
     * @param mixed $loanTotalBalance
     */
    public function setLoanTotalBalance($loanTotalBalance)
    {
        $this->_onPropertyChanged('loanTotalBalance', $this->loanTotalBalance, $loanTotalBalance);
        $this->loanTotalBalance = $loanTotalBalance;
    }

    /**
     * @return mixed
     */
    public function getLoansCount()
    {
        return $this->loansCount;
    }

    /**
     * @param mixed $loansCount
     */
    public function setLoansCount($loansCount)
    {
        $this->_onPropertyChanged('loansCount', $this->loansCount, $loansCount);
        $this->loansCount = $loansCount;
    }

    /**
     * @return mixed
     */
    public function getOriginalBalance()
    {
        return $this->originalBalance;
    }

    /**
     * @param mixed $originalBalance
     */
    public function setOriginalBalance($originalBalance)
    {
        $this->_onPropertyChanged('originalBalance', $this->originalBalance, $originalBalance);
        $this->originalBalance = $originalBalance;
    }

    /**
     * @return mixed
     */
    public function getPoolStructure()
    {
        return $this->poolStructure;
    }

    /**
     * @param mixed $poolStructure
     */
    public function setPoolStructure($poolStructure)
    {
        $this->_onPropertyChanged('poolStructure', $this->poolStructure, $poolStructure);
        $this->poolStructure = $poolStructure;
    }

    /**
     * @return mixed
     */
    public function getIsCrossed()
    {
        return $this->isCrossed;
    }

    /**
     * @param mixed $isCrossed
     */
    public function setIsCrossed($isCrossed)
    {
        $this->_onPropertyChanged('isCrossed', $this->isCrossed, $isCrossed);
        $this->isCrossed = $isCrossed;
    }

    /**
     * @return mixed
     */
    public function getIsPogroup()
    {
        return $this->isPogroup;
    }

    /**
     * @param mixed $isPogroup
     */
    public function setIsPogroup($isPogroup)
    {
        $this->_onPropertyChanged('isPogroup', $this->isPogroup, $isPogroup);
        $this->isPogroup = $isPogroup;
    }

    /**
     * @return mixed
     */
    public function getIsIoGroup()
    {
        return $this->isIoGroup;
    }

    /**
     * @param mixed $isIoGroup
     */
    public function setIsIoGroup($isIoGroup)
    {
        $this->_onPropertyChanged('isIoGroup', $this->isIoGroup, $isIoGroup);
        $this->isIoGroup = $isIoGroup;
    }

    /**
     * @return mixed
     */
    public function getAddReserveToCreditSupport()
    {
        return $this->addReserveToCreditSupport;
    }

    /**
     * @param mixed $addReserveToCreditSupport
     */
    public function setAddReserveToCreditSupport($addReserveToCreditSupport)
    {
        $this->_onPropertyChanged('addReserveToCreditSupport', $this->addReserveToCreditSupport, $addReserveToCreditSupport);
        $this->addReserveToCreditSupport = $addReserveToCreditSupport;
    }
    
    
}