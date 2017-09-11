<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 */

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 * @ORM\Table(name="DealBid")
 */
class DealBid
{
    /**
     * @ORM\Id @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     **/
    protected $id;

    /** @ORM\OneToMany(targetEntity="\App\Entity\Deal", mappedBy="bidType")
     * @var ArrayCollection
     **/
    protected $deals;

    /** @ORM\Column(type="string", nullable=false) **/
    protected $bidClass;

    public function __construct()
    {
        $this->deals = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return ArrayCollection
     */
    public function getDeals()
    {
        return $this->deals;
    }


    /**
     * @return mixed
     */
    public function getBidClass()
    {
        return $this->bidClass;
    }

}