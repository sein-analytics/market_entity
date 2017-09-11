<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 */

namespace App\Entity\Bond;
use App\Entity\NotifyChangeTrait;
use Doctrine\Common\NotifyPropertyChanged;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Update\BondUpdate;

/**
 * @ORM\Entity
 * @ORM\Table(name="ComponentUpdate")
 *
 */
class ComponentUpdate implements NotifyPropertyChanged
{
    use NotifyChangeTrait;

    /**
     * @ORM\Id @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @var int
     **/
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\Bond\Component", inversedBy="updates")
     * @var Component
     **/
    protected $component;

    /** @ORM\Column(type="decimal", precision=14, scale=2, nullable=true) **/
    protected $startingBalance;

    /** @ORM\Column(type="decimal", precision=14, scale=2, nullable=true) **/
    protected $endingBalance;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\Update\BondUpdate", inversedBy="components")
     * @var BondUpdate
     **/
    protected $bondUpdate;

    /** @ORM\Column(type="decimal", precision=14, scale=2) **/
    protected $principalPaid;

    /** @ORM\Column(type="decimal", precision=14, scale=2) **/
    protected $cumulativeLosses;

    /** @ORM\Column(type="decimal", precision=14, scale=2) **/
    protected $interestDue;

    /** @ORM\Column(type="decimal", precision=14, scale=2) **/
    protected $interestPaid;

    /** @ORM\Column(type="decimal", precision=14, scale=2) **/
    protected $interestUnpaid;

    /** @ORM\Column(type="decimal", precision=14, scale=2) **/
    protected $interestOnUnpaidInterest;

    /** @ORM\Column(type="decimal", precision=14, scale=2) **/
    protected $basisCarry;

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
    public function getComponent()
    {
        return $this->component;
    }

    /**
     * @param mixed $component
     */
    public function setComponent($component)
    {
        $this->component = $component;
    }

    /**
     * @return mixed
     */
    public function getStartingBalance()
    {
        return $this->startingBalance;
    }

    /**
     * @param mixed $startingBalance
     */
    public function setStartingBalance($startingBalance)
    {
        $this->startingBalance = $startingBalance;
    }

    /**
     * @return mixed
     */
    public function getEndingBalance()
    {
        return $this->endingBalance;
    }

    /**
     * @param mixed $endingBalance
     */
    public function setEndingBalance($endingBalance)
    {
        $this->endingBalance = $endingBalance;
    }

    /**
     * @return mixed
     */
    public function getBondUpdate()
    {
        return $this->bondUpdate;
    }

    /**
     * @param mixed $bondUpdate
     */
    public function setBondUpdate($bondUpdate)
    {
        $this->bondUpdate = $bondUpdate;
    }

    /**
     * @return mixed
     */
    public function getPrincipalPaid()
    {
        return $this->principalPaid;
    }

    /**
     * @param mixed $principalPaid
     */
    public function setPrincipalPaid($principalPaid)
    {
        $this->principalPaid = $principalPaid;
    }

    /**
     * @return mixed
     */
    public function getCumulativeLosses()
    {
        return $this->cumulativeLosses;
    }

    /**
     * @param mixed $cumulativeLosses
     */
    public function setCumulativeLosses($cumulativeLosses)
    {
        $this->cumulativeLosses = $cumulativeLosses;
    }

    /**
     * @return mixed
     */
    public function getInterestDue()
    {
        return $this->interestDue;
    }

    /**
     * @param mixed $interestDue
     */
    public function setInterestDue($interestDue)
    {
        $this->interestDue = $interestDue;
    }

    /**
     * @return mixed
     */
    public function getInterestPaid()
    {
        return $this->interestPaid;
    }

    /**
     * @param mixed $interestPaid
     */
    public function setInterestPaid($interestPaid)
    {
        $this->interestPaid = $interestPaid;
    }

    /**
     * @return mixed
     */
    public function getInterestUnpaid()
    {
        return $this->interestUnpaid;
    }

    /**
     * @param mixed $interestUnpaid
     */
    public function setInterestUnpaid($interestUnpaid)
    {
        $this->interestUnpaid = $interestUnpaid;
    }

    /**
     * @return mixed
     */
    public function getInterestOnUnpaidInterest()
    {
        return $this->interestOnUnpaidInterest;
    }

    /**
     * @param mixed $interestOnUnpaidInterest
     */
    public function setInterestOnUnpaidInterest($interestOnUnpaidInterest)
    {
        $this->interestOnUnpaidInterest = $interestOnUnpaidInterest;
    }

    /**
     * @return mixed
     */
    public function getBasisCarry()
    {
        return $this->basisCarry;
    }

    /**
     * @param mixed $basisCarry
     */
    public function setBasisCarry($basisCarry)
    {
        $this->basisCarry = $basisCarry;
    }
}