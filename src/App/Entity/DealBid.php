<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 */

namespace App\Entity;

use \App\Entity\Deal;
use App\Service\CreatePropertiesArrayTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Illuminate\Support\Arr;

use Doctrine\ORM\Mapping as ORM;
#[ORM\Table(name: 'DealBid')]
#[ORM\Entity]
class DealBid 
{
    use CreatePropertiesArrayTrait;
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    protected int $id;

    /**
     * @var ArrayCollection
     **/
    #[ORM\OneToMany(targetEntity: Deal::class, mappedBy: 'bidType')]
    protected $deals;

    /**
     * @var string
     */
    #[ORM\Column(type: 'string', nullable: false)]
    protected string $bidClass;

    public function __construct()
    {
        $this->deals = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId():int
    {
        return $this->id;
    }

    /**
     * @return ArrayCollection
     */
    public function getDeals():ArrayCollection
    {
        return $this->deals;
    }


    /**
     * @return string
     */
    public function getBidClass():string
    {
        return $this->bidClass;
    }

}