<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 */

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="\App\Repository\DealAsset")
 * @ORM\Table(name="DealAsset")
 */
class DealAsset
{

    /**
     * @ORM\Id @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     **/
    protected $id;

    /** @ORM\OneToMany(targetEntity="\App\Entity\Deal", mappedBy="assetType")
     * @var ArrayCollection
     **/
    protected $deals;

    /** @ORM\Column(type="string", nullable=false) **/
    protected $assetClass;

    /** @ORM\Column(type="string", nullable=false) **/
    protected $name;

    public function __construct()
    {
        $this->deals = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getId() { return $this->id; }

    /**
     * @return ArrayCollection
     */
    public function getDeals() { return $this->deals; }

    /**
     * @return string
     */
    public function getAssetClass() { return $this->assetClass; }

    /**
     * @return string
     */
    public function getName() { return $this->name; }


}
