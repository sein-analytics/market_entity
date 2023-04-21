<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 */

namespace App\Entity;

use App\Service\CreatePropertiesArrayTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="\App\Repository\DealAsset")
 * @ORM\Table(name="DealAsset")
 */
class DealAsset
{
    use CreatePropertiesArrayTrait;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     **/
    protected int $id;

    /**
     * @ORM\OneToMany(targetEntity="\App\Entity\Deal", mappedBy="assetType")
     * @var ArrayCollection
     **/
    protected $deals;

    /**
     * @ORM\Column(type="string", nullable=false)
     * @var string
     */
    protected string $assetClass = '';

    /**
     * @ORM\Column(type="string", nullable=false)
     * @var string
     */
    protected string $name = '';

    /**
     * @ORM\OneToMany(targetEntity="\App\Entity\LoanTapeTemplate", mappedBy="type")
     */
    protected $templates;

    public function __construct()
    {
        $this->deals = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId():int { return $this->id; }

    /**
     * @return ArrayCollection
     */
    public function getDeals():ArrayCollection { return $this->deals; }

    /**
     * @return string
     */
    public function getAssetClass():string { return $this->assetClass; }

    /**
     * @return string
     */
    public function getName():string { return $this->name; }


}
