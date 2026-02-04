<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 */

namespace App\Entity;

use \App\Entity\Deal;
use \App\Entity\LoanTapeTemplate;
use App\Service\CreatePropertiesArrayTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'DealAsset')]
#[ORM\Entity(repositoryClass: \App\Repository\DealAsset::class)]
class DealAsset
{
    use CreatePropertiesArrayTrait;

    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    protected int $id;

    /**
     * @var ArrayCollection
     **/
    #[ORM\OneToMany(targetEntity: Deal::class, mappedBy: 'assetType')]
    protected $deals;

    /**
     * @var string
     */
    #[ORM\Column(type: 'string', nullable: false)]
    protected string $assetClass = '';

    /**
     * @var string
     */
    #[ORM\Column(type: 'string', nullable: false)]
    protected string $name = '';

    #[ORM\OneToMany(targetEntity: LoanTapeTemplate::class, mappedBy: 'type')]
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
