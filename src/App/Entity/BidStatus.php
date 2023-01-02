<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 */

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="\App\Repository\BidStatus")
 * @ORM\Table(name="BidStatus")
 */
class BidStatus extends AnnotationMappings
{
    /**
     * \Doctrine\ORM\Mapping\Id
     * \Doctrine\ORM\Mapping\Column(type="integer")
     * \Doctrine\ORM\Mapping\GeneratedValue
     **/
    protected int $id;

    /** \Doctrine\ORM\Mapping\Column(type="string", nullable=false)   */
    protected string $status;

    /**
     * \Doctrine\ORM\Mapping\OneToMany(targetEntity = "\App\Entity\Bid", mappedBy="status")
     * @var ArrayCollection
     */
    protected $bids;

    function __construct()
    {
        $this->bids = new ArrayCollection();
    }

    public function getId():int { return $this->id; }

    function addBid(Bid $bid):void {
        $this->bids->add($bid);
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @return ArrayCollection
     */
    public function getBids(): ArrayCollection
    {
        return $this->bids;
    }

}