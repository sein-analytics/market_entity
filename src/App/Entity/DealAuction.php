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
 * @ORM\Entity
 * @ORM\Table(name="DealAuction")
 */
class DealAuction
{
    use CreatePropertiesArrayTrait;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     **/
    protected int $id;

    /**
     * @ORM\OneToMany(targetEntity="\App\Entity\Deal", mappedBy="auctionType")
     * @var ArrayCollection
     **/
    protected $deals;

    /**
     * @ORM\Column(type="string", nullable=false)
     * @var string
     */
    protected string $auctionClass ='';

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
    public function getAuctionClass():string
    {
        return $this->auctionClass;
    }
    
    
}