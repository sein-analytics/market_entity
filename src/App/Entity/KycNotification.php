<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'KycNotification')]
class KycNotification
{

    /**
     * @var int
     **/
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    protected int $id;

    #[ORM\JoinColumn(name: 'sender_id', referencedColumnName: 'id', nullable: false)]
    #[ORM\ManyToOne(targetEntity:  MarketUser::class)]
    protected MarketUser $sender;

    #[ORM\JoinColumn(name: 'issuer_id', referencedColumnName: 'id', nullable: false)]
    #[ORM\ManyToOne(targetEntity:  Issuer::class)]
    protected Issuer $issuer;

    #[ORM\JoinColumn(name: 'user_id', referencedColumnName: 'id', nullable: false)]
    #[ORM\ManyToOne(targetEntity:  MarketUser::class)]
    protected MarketUser $user;

    function __construct()
    {
        $this->sender = new MarketUser();
        $this->issuer = new Issuer();
        $this->user = new MarketUser();
    }

    /**
     * @return int
     */
    public function getId():int { return $this->id; }

    /**
     * @return MarketUser
     */
    public function getSender():MarketUser { return $this->sender; }

    /**
     * @param MarketUser $user
     */
    public function setSender(MarketUser $sender):void { $this->sender = $sender; }

    /**
     * @return Issuer
     */
    public function getIssuer():Issuer { return $this->issuer; }

    /**
     * @param Issuer $issuer
     */
    public function setIssuer(Issuer $issuer):void { $this->issuer = $issuer; }
   
    /**
     * @return MarketUser
     */
    public function getUser():MarketUser { return $this->user; }

    /**
     * @param MarketUser $user
     */
    public function setUser(MarketUser $user):void { $this->user = $user; }

}