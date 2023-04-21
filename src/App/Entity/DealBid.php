<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 */

namespace App\Entity;

use App\Service\CreatePropertiesArrayTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Illuminate\Support\Arr;

use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 * @ORM\Table(name="DealBid")
 *
 * Any change in the definition should be reflected in
 * ServiceInterface.php
 */
class DealBid 
{
    use CreatePropertiesArrayTrait;
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     **/
    protected int $id;

    /**
     * @ORM\OneToMany(targetEntity="\App\Entity\Deal", mappedBy="bidType")
     * @var ArrayCollection
     **/
    protected $deals;

    /**
     * @ORM\Column(type="string", nullable=false)
     * @var string
     */
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