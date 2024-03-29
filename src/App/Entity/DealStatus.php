<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass="\App\Repository\DealStatus")
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
    
    protected static array $statuses = array(
        self::UPLOAD        => "\\App\\Entity\\DealStatus\\Upload",
        self::AUCTION       => "\\App\\Entity\\DealStatus\\Auction",
        self::LOI           => "\\App\\Entity\\DealStatus\\Loi",
        self::DILIGENCE     => "\\App\\Entity\\DealStatus\\Diligence",
        self::CONTRACT      => "\\App\\Entity\\DealStatus\\Contract",
        self::CLOSED        => "\\App\\Entity\\DealStatus\\Closed",
    );

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     **/
    protected int $id;

    /**
     * @ORM\OneToMany(targetEntity="\App\Entity\Deal", mappedBy="status")
     * @var ArrayCollection
     **/
    protected $deals;

    /**
     * @ORM\Column(type="string", nullable=false)
     * @var string
     */
    protected string $status ='';

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

    public function addDeal(Deal $deal):void
    {
        $this->getDeals()->add($deal);
    }

    /**
     * @return string
     */
    public function getStatus():string
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