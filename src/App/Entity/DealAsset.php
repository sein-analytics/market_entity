<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 */

namespace App\Entity;

use App\Service\CreatePropertiesArrayTrait;
use Doctrine\Common\Collections\ArrayCollection;
//use Doctrine\ORM\Mapping as ORM;

/**
 * \Doctrine\ORM\Mapping\Entity(repositoryClass="\App\Repository\DealAsset")
 * \Doctrine\ORM\Mapping\Table(name="DealAsset")
 */
class DealAsset extends AnnotationMappings
{
    use CreatePropertiesArrayTrait;

    /**
     * \Doctrine\ORM\Mapping\Id
     * \Doctrine\ORM\Mapping\Column(type="integer")
     * \Doctrine\ORM\Mapping\GeneratedValue
     **/
    protected int $id;

    /**
     * \Doctrine\ORM\Mapping\OneToMany(targetEntity="\App\Entity\Deal", mappedBy="assetType")
     * @var ArrayCollection
     **/
    protected $deals;

    /**
     * \Doctrine\ORM\Mapping\Column(type="string", nullable=false)
     * @var string
     */
    protected string $assetClass = '';

    /**
     * \Doctrine\ORM\Mapping\Column(type="string", nullable=false)
     * @var string
     */
    protected string $name = '';

    /**
     * \Doctrine\ORM\Mapping\OneToMany(targetEntity="\App\Entity\LoanTapeTemplate", mappedBy="type")
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
