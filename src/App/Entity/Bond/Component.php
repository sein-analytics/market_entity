<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 */

namespace App\Entity\Bond;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use App\Entity\Bond;
use Doctrine\ORM\PersistentCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="Component")
 */
class Component
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @var int
     **/
    protected int $id;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\Bond", inversedBy="components")
     * @var Bond
     **/
    protected $bond;

    /**
     * @ORM\Column(type="integer") *
     */
    protected int $componentNumber;

    /**
     * @ORM\Column(type="string") *
     */
    protected string $componentName;

    /**
     * @ORM\Column(type="decimal", precision=6, scale=5, nullable=true) *
     */
    protected float $fixedRate;

    /**
     * @ORM\Column(type="string", nullable=true) *
     */
    protected string $rateFormula;

    /**
     * @ORM\OneToOne(targetEntity="\App\Entity\Bond\ComponentUpdate") *
     */
    protected $latestUpdate;

    /**
     * @ORM\OneToMany(targetEntity="\App\Entity\Bond\ComponentUpdate", mappedBy="component")
     * @var ArrayCollection;
     **/
    protected $updates;

    /**
     * @ORM\Column(type="string", nullable=true) *
     */
    protected string $componentBasis;

    /**
     * @ORM\Column(type="string", nullable=true) *
     */
    protected string $floatingIndex;

    /**
     * @ORM\Column(type="string", nullable=true) *
     */
    protected string $indexMaturity;

    /**
     * @ORM\Column(type="string", nullable=true) *
     */
    protected string $spreadArray;

    public function __construct()
    {
        $this->updates = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId():int
    {
        return $this->id;
    }

    /**
     * @return Bond|null
     */
    public function getBond():?Bond
    {
        return $this->bond;
    }

    /**
     * @param Bond $bond
     */
    public function setBond(Bond $bond)
    {
        $this->bond = $bond;
    }

    /**
     * @return int
     */
    public function getComponentNumber():int
    {
        return $this->componentNumber;
    }

    /**
     * @param int $componentNumber
     */
    public function setComponentNumber(int $componentNumber):void
    {
        $this->componentNumber = $componentNumber;
    }

    /**
     * @return string
     */
    public function getComponentName():string
    {
        return $this->componentName;
    }

    /**
     * @param string $componentName
     */
    public function setComponentName(string $componentName):void
    {
        $this->componentName = $componentName;
    }

    /**
     * @return float|null
     */
    public function getFixedRate():?float
    {
        return $this->fixedRate;
    }

    /**
     * @param float $fixedRate
     */
    public function setFixedRate(float $fixedRate):void
    {
        $this->fixedRate = $fixedRate;
    }

    /**
     * @return string|null
     */
    public function getRateFormula():?string
    {
        return $this->rateFormula;
    }

    /**
     * @param string $rateFormula
     */
    public function setRateFormula(string $rateFormula):void
    {
        $this->rateFormula = $rateFormula;
    }

    /**
     * @return ComponentUpdate|null
     */
    public function getLatestUpdate():?ComponentUpdate
    {
        return $this->latestUpdate;
    }

    /**
     * @param ComponentUpdate $latestUpdate
     */
    public function setLatestUpdate(ComponentUpdate $latestUpdate):void
    {
        $this->latestUpdate = $latestUpdate;
    }

    /**
     * @return ArrayCollection|PersistentCollection|null
     */
    public function getUpdates():ArrayCollection|PersistentCollection|null
    {
        return $this->updates;
    }

    public function addUpdate(ComponentUpdate $update)
    {
        //$date = $

    }


    /**
     * @return string|null
     */
    public function getComponentBasis():?string
    {
        return $this->componentBasis;
    }

    /**
     * @param string $componentBasis
     */
    public function setComponentBasis(string $componentBasis):void
    {
        $this->componentBasis = $componentBasis;
    }

    /**
     * @return string|null
     */
    public function getFloatingIndex():?string
    {
        return $this->floatingIndex;
    }

    /**
     * @param string $floatingIndex
     */
    public function setFloatingIndex(string $floatingIndex):void
    {
        $this->floatingIndex = $floatingIndex;
    }

    /**
     * @return string|null
     */
    public function getIndexMaturity():?string
    {
        return $this->indexMaturity;
    }

    /**
     * @param string $indexMaturity
     */
    public function setIndexMaturity(string $indexMaturity):void
    {
        $this->indexMaturity = $indexMaturity;
    }

    /**
     * @return mixed
     */
    public function getSpreadArray()
    {
        return $this->spreadArray;
    }

    /**
     * @param mixed $spreadArray
     */
    public function setSpreadArray($spreadArray)
    {
        $this->spreadArray = $spreadArray;
    }
}