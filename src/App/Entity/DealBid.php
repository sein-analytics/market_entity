<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 */

namespace App\Entity;

use App\Service\CreatePropertiesArrayTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Illuminate\Support\Arr;

//use Doctrine\ORM\Mapping as ORM;
/**
 * \Doctrine\ORM\Mapping\Entity
 * \Doctrine\ORM\Mapping\Table(name="DealBid")
 *
 * Any change in the definition should be reflected in
 * ServiceInterface.php
 */
class DealBid extends AnnotationMappings
{
    use CreatePropertiesArrayTrait;
    /**
     * \Doctrine\ORM\Mapping\Id
     * \Doctrine\ORM\Mapping\Column(type="integer")
     * \Doctrine\ORM\Mapping\GeneratedValue
     **/
    protected int $id;

    /**
     * \Doctrine\ORM\Mapping\OneToMany(targetEntity="\App\Entity\Deal", mappedBy="bidType")
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