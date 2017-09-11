<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 */

namespace App\Entity\Bond;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use App\Entity\Bond;

/**
 * @ORM\Entity
 * @ORM\Table(name="Component")
 */
class Component
{
    /**
     * @ORM\Id @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @var int
     **/
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\Bond", inversedBy="components")
     * @var Bond
     **/
    protected $bond;

    /** @ORM\Column(type="integer") **/
    protected $componentNumber;

    /** @ORM\Column(type="string") **/
    protected $componentName;

    /** @ORM\Column(type="decimal", precision=6, scale=5, nullable=true) **/
    protected $fixedRate;

    /** @ORM\Column(type="string", nullable=true) **/
    protected $rateFormula;

    /** @ORM\OneToOne(targetEntity="\App\Entity\Bond\ComponentUpdate") **/
    protected $latestUpdate;

    /**
     * @ORM\OneToMany(targetEntity="\App\Entity\Bond\ComponentUpdate", mappedBy="component")
     * @var ArrayCollection;
     **/
    protected $updates;

    /** @ORM\Column(type="string", nullable=true) **/
    protected $componentBasis;

    /** @ORM\Column(type="string", nullable=true) **/
    protected $floatingIndex;

    /** @ORM\Column(type="string", nullable=true) **/
    protected $indexMaturity;

    /** @ORM\Column(type="string", nullable=true) **/
    protected $spreadArray;

    public function __construct()
    {
        $this->updates = new ArrayCollection();
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
    public function getBond()
    {
        return $this->bond;
    }

    /**
     * @param mixed $bond
     */
    public function setBond($bond)
    {
        $this->bond = $bond;
    }

    /**
     * @return mixed
     */
    public function getComponentNumber()
    {
        return $this->componentNumber;
    }

    /**
     * @param mixed $componentNumber
     */
    public function setComponentNumber($componentNumber)
    {
        $this->componentNumber = $componentNumber;
    }

    /**
     * @return mixed
     */
    public function getComponentName()
    {
        return $this->componentName;
    }

    /**
     * @param mixed $componentName
     */
    public function setComponentName($componentName)
    {
        $this->componentName = $componentName;
    }

    /**
     * @return mixed
     */
    public function getFixedRate()
    {
        return $this->fixedRate;
    }

    /**
     * @param mixed $fixedRate
     */
    public function setFixedRate($fixedRate)
    {
        $this->fixedRate = $fixedRate;
    }

    /**
     * @return mixed
     */
    public function getRateFormula()
    {
        return $this->rateFormula;
    }

    /**
     * @param mixed $rateFormula
     */
    public function setRateFormula($rateFormula)
    {
        $this->rateFormula = $rateFormula;
    }

    /**
     * @return mixed
     */
    public function getLatestUpdate()
    {
        return $this->latestUpdate;
    }

    /**
     * @param ComponentUpdate $latestUpdate
     */
    public function setLatestUpdate(ComponentUpdate $latestUpdate)
    {
        $this->latestUpdate = $latestUpdate;
    }

    /**
     * @return mixed
     */
    public function getUpdates()
    {
        return $this->updates;
    }

    public function addUpdate(ComponentUpdate $update)
    {
        //$date = $

    }


    /**
     * @return mixed
     */
    public function getComponentBasis()
    {
        return $this->componentBasis;
    }

    /**
     * @param mixed $componentBasis
     */
    public function setComponentBasis($componentBasis)
    {
        $this->componentBasis = $componentBasis;
    }

    /**
     * @return mixed
     */
    public function getFloatingIndex()
    {
        return $this->floatingIndex;
    }

    /**
     * @param mixed $floatingIndex
     */
    public function setFloatingIndex($floatingIndex)
    {
        $this->floatingIndex = $floatingIndex;
    }

    /**
     * @return mixed
     */
    public function getIndexMaturity()
    {
        return $this->indexMaturity;
    }

    /**
     * @param mixed $indexMaturity
     */
    public function setIndexMaturity($indexMaturity)
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