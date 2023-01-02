<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 */

namespace App\Entity\Bond;
use App\Entity\DomainObject;
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
use App\Entity\Update\BondUpdate;

/**
 * \Doctrine\ORM\Mapping\Entity
 * \Doctrine\ORM\Mapping\Table(name="ComponentUpdate")
 *
 */
class ComponentUpdate extends DomainObject
{

    /**
     * \Doctrine\ORM\Mapping\Id @ORM\GeneratedValue
     * \Doctrine\ORM\Mapping\Column(type="integer")
     * @var int
     **/
    protected $id;

    /**
     * \Doctrine\ORM\Mapping\ManyToOne(targetEntity="\App\Entity\Bond\Component", inversedBy="updates")
     * @var Component
     **/
    protected $component;

    /**
     * \Doctrine\ORM\Mapping\Column(type="decimal", precision=14, scale=2, nullable=true) *
     */
    protected float $startingBalance;

    /**
     * \Doctrine\ORM\Mapping\Column(type="decimal", precision=14, scale=2, nullable=true) *
     */
    protected float $endingBalance;

    /**
     * \Doctrine\ORM\Mapping\ManyToOne(targetEntity="\App\Entity\Update\BondUpdate", inversedBy="components")
     * @var BondUpdate
     **/
    protected $bondUpdate;

    /**
     * \Doctrine\ORM\Mapping\Column(type="decimal", precision=14, scale=2) *
     */
    protected float $principalPaid;

    /**
     * \Doctrine\ORM\MappingORM\Column(type="decimal", precision=14, scale=2) *
     */
    protected float $cumulativeLosses;

    /**
     * \Doctrine\ORM\Mapping\Column(type="decimal", precision=14, scale=2) *
     */
    protected float $interestDue;

    /**
     * \Doctrine\ORM\Mapping\Column(type="decimal", precision=14, scale=2) *
     */
    protected float $interestPaid;

    /**
     * \Doctrine\ORM\Mapping\Column(type="decimal", precision=14, scale=2) *
     */
    protected float $interestUnpaid;

    /**
     * \Doctrine\ORM\Mapping\Column(type="decimal", precision=14, scale=2) *
     */
    protected float $interestOnUnpaidInterest;

    /**
     * \Doctrine\ORM\Mapping\Column(type="decimal", precision=14, scale=2) *
     */
    protected float $basisCarry;

    /**
     * @return int
     */
    public function getId():int
    {
        return $this->id;
    }

    /**
     * @return Component|null
     */
    public function getComponent():?Component
    {
        return $this->component;
    }

    /**
     * @param Component $component
     */
    public function setComponent(Component $component)
    {
        $this->component = $component;
    }

    /**
     * @return float
     */
    public function getStartingBalance():float
    {
        return $this->startingBalance;
    }

    /**
     * @param float $startingBalance
     */
    public function setStartingBalance(float $startingBalance):void
    {
        $this->startingBalance = $startingBalance;
    }

    /**
     * @return float|null
     */
    public function getEndingBalance():?float
    {
        return $this->endingBalance;
    }

    /**
     * @param float $endingBalance
     */
    public function setEndingBalance(float $endingBalance):void
    {
        $this->endingBalance = $endingBalance;
    }

    /**
     * @return BondUpdate|null
     */
    public function getBondUpdate():?BondUpdate
    {
        return $this->bondUpdate;
    }

    /**
     * @param BondUpdate $bondUpdate
     */
    public function setBondUpdate(BondUpdate $bondUpdate):void
    {
        $this->bondUpdate = $bondUpdate;
    }

    /**
     * @return float|null
     */
    public function getPrincipalPaid():?float
    {
        return $this->principalPaid;
    }

    /**
     * @param float $principalPaid
     */
    public function setPrincipalPaid(float $principalPaid):void
    {
        $this->principalPaid = $principalPaid;
    }

    /**
     * @return float|null
     */
    public function getCumulativeLosses():?float
    {
        return $this->cumulativeLosses;
    }

    /**
     * @param float $cumulativeLosses
     */
    public function setCumulativeLosses(float $cumulativeLosses):void
    {
        $this->cumulativeLosses = $cumulativeLosses;
    }

    /**
     * @return float|null
     */
    public function getInterestDue():?float
    {
        return $this->interestDue;
    }

    /**
     * @param float $interestDue
     */
    public function setInterestDue(float $interestDue):void
    {
        $this->interestDue = $interestDue;
    }

    /**
     * @return float|null
     */
    public function getInterestPaid():?float
    {
        return $this->interestPaid;
    }

    /**
     * @param float $interestPaid
     */
    public function setInterestPaid(float $interestPaid):void
    {
        $this->interestPaid = $interestPaid;
    }

    /**
     * @return float|null
     */
    public function getInterestUnpaid():?float
    {
        return $this->interestUnpaid;
    }

    /**
     * @param float $interestUnpaid
     */
    public function setInterestUnpaid(float $interestUnpaid):void
    {
        $this->interestUnpaid = $interestUnpaid;
    }

    /**
     * @return float|null
     */
    public function getInterestOnUnpaidInterest():?float
    {
        return $this->interestOnUnpaidInterest;
    }

    /**
     * @param float $interestOnUnpaidInterest
     */
    public function setInterestOnUnpaidInterest(float $interestOnUnpaidInterest):void
    {
        $this->interestOnUnpaidInterest = $interestOnUnpaidInterest;
    }

    /**
     * @return float|null
     */
    public function getBasisCarry():?float
    {
        return $this->basisCarry;
    }

    /**
     * @param float $basisCarry
     */
    public function setBasisCarry( float $basisCarry):void
    {
        $this->basisCarry = $basisCarry;
    }
}