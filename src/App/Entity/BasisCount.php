<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 * Date: 9/21/18
 * Time: 11:44 AM
 */

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\NotifyPropertyChanged;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\PersistentCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="BasisCount")
 *
 */
class BasisCount implements NotifyPropertyChanged
{
    use NotifyChangeTrait;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     * @var int
     **/
    protected $id;

    /** @ORM\Column(type="string", nullable=false)   */
    protected $basis;

    /** @ORM\Column(type="string", nullable=false)
     * @var string
     */
    protected $formula;

    /**
     * @ORM\OneToMany(targetEntity = "\App\Entity\Bond", mappedBy="basisCount")
     * @var ArrayCollection
     */
    protected $bonds;

    public function __construct()
    {
        $this->bonds = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId():int { return $this->id; }

    /**
     * @return mixed
     */
    public function getBasis() { return $this->basis; }

    /**
     * @return ArrayCollection|PersistentCollection
     */
    public function getUsedBy() { return $this->bonds; }

    public function getFormula() :string  { return $this->formula; }

}