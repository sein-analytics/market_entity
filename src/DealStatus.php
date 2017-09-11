<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="DealStatus")
 */
class DealStatus
{
    const UPLOAD = "UPLOAD";

    const AUCTION = "AUCTION";

    const LOI   = "LOI";

    const DILIGENCE= "DILIGENCE";

    const CONTRACT = "CONTRACT";

    const CLOSED = "CLOSED";
    
    protected static $statuses = array(
        self::UPLOAD        => "\\App\\Entity\\DealStatus\\Upload",
        self::AUCTION       => "\\App\\Entity\\DealStatus\\Auction",
        self::LOI           => "\\App\\Entity\\DealStatus\\Loi",
        self::DILIGENCE     => "\\App\\Entity\\DealStatus\\Diligence",
        self::CONTRACT      => "\\App\\Entity\\DealStatus\\Contract",
        self::CLOSED        => "\\App\\Entity\\DealStatus\\Closed",
    );

    /**
     * @ORM\Id @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     **/
    protected $id;

    /** @ORM\OneToMany(targetEntity="\App\Entity\Deal", mappedBy="status")
     * @var ArrayCollection
     **/
    protected $deals;

    /** @ORM\Column(type="string", nullable=false) **/
    protected $status;

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

    public function addDeal(Deal $deal)
    {
        $this->getDeals()->add($deal);
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param $status
     * @throws \Exception
     */
    public function setStatus($status)
    {
        if(!array_key_exists(strtoupper($status), self::$statuses)){
            throw new \Exception("Status class type: $status does not exist");
        }
        $this->status = $status;
    }



}