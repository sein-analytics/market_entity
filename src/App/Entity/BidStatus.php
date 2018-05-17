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
class BidStatus
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     **/
    protected $id;

    /** @ORM\Column(type="string", nullable=false)   */
    protected $status;

    /**
     * @ORM\OneToMany(targetEntity = "\App\Entity\Bid", mappedBy="status")
     * @var ArrayCollection
     */
    protected $bids;

    function __construct()
    {
        $this->bids = new ArrayCollection();
    }

    public function getId() { return $this->id; }

    function addBid(Bid $bid){
        $this->bids->add($bid);
    }

    /**
     * @return mixed
     */
    public function getStatus()
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