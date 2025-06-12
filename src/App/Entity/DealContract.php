<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="\App\Repository\DealContract")
 * @ORM\Table(name="DealContract")
 */
class DealContract
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @var int
     **/
    protected int $id;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\Deal", inversedBy="contracts")
     * @ORM\JoinColumn(name="deal_id", referencedColumnName="id", nullable=false)
     */
    protected Deal $deal;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\Bid")
     * @ORM\JoinColumn(name="bid_id", referencedColumnName="id", nullable=true)
     */
    protected ?Bid $bid;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\MarketUser", inversedBy="contracts")
     * @ORM\JoinColumn(name="buyer_id", referencedColumnName="id", nullable=true)
     */
    protected ?MarketUser $buyer;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\MarketUser", inversedBy="contracts")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false)
     */
    protected MarketUser $user;


    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\DocType", inversedBy="dealFiles")
     * @ORM\JoinColumn(name="doc_type_id", referencedColumnName="id", nullable=false)
     */
    protected DocType $docType;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\DealAsset")
     * @ORM\JoinColumn(name="deal_asset_id", referencedColumnName="id", nullable=false)
     */
    protected DealAsset $dealAsset;

    /**
     * @ORM\Column(type="string", nullable=false)
     * @var string
     */
    protected string $assetId = '';

    /**
     * @ORM\Column(type="string", nullable=false)
     * @var string
     */
    protected string $secureUrl = '';

    /**
     * @ORM\Column(type="string", nullable=false)
     * @var string
     */
     protected string $fileName = '';

    /**
     * @ORM\Column(type="datetime", nullable=false)
     * @var \DateTime
     **/
    protected $date;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\ContractSignature")
     * @ORM\JoinColumn(name="contract_signature_id", referencedColumnName="id", unique=true, nullable=true)
     */
    protected ?ContractSignature $contractSignature;

    function __construct()
    {
        $this->deal = new Deal();
        $this->buyer = new MarketUser();
    }

    /**
     * @return int
     */
    public function getId():int { return $this->id; }
    
    /**
     * @return Deal
     */
    public function getDeal():Deal { return $this->deal; }

    /**
     * @param Deal $deal
     */
    public function setDeal(Deal $deal):void { $this->deal = $deal; }

    /**
     * @return Bid|null
     */
    public function getBid(): Bid|null{ return $this->bid; }

    /**
     * @param Bid $Bid
     */
    public function setBid(Bid $bid): void { $this->bid = $bid; }

    /**
     * @return MarketUser
     */
    public function getBuyer():?MarketUser { return $this->buyer; }

    /**
     * @param MarketUser $buyer
     */
    public function setBuyer(MarketUser $buyer):void { $this->buyer = $buyer; }
   
    /**
     * @return MarketUser
     */
    public function getUser():MarketUser { return $this->user; }

    /**
     * @param MarketUser $user
     */
    public function setUser(MarketUser $user) { $this->user = $user; }
    
    /**
     * @return DocType
     */
    public function getDocType():DocType { return $this->docType; }

    /**
     * @param DocType $docType
     */
    public function setDocType(DocType $docType) { $this->docType = $docType; }
    
    /**
     * @return DealAsset
     */
    public function getDealAsset():DealAsset { return $this->dealAsset; }

    /**
     * @param DealAsset $dealAsset
     */
    public function setDealAsset(DealAsset $dealAsset):void { $this->dealAsset = $dealAsset; }
    
    /**
     * @return string
     */
    public function getAssetId():string { return $this->assetId; }

    /**
     * @param string
     */
    public function setAssetId(string $assetId):void { $this->assetId = $assetId; }

    /**
     * @return string
     */
    public function getSecureUrl():string { return $this->secureUrl; }

    /**
     * @param string
     */
    public function setSecureUrl(string $secureUrl):void { $this->secureUrl = $secureUrl; }

    /**
     * @return null|string
     */
    public function getFileName():string { return $this->fileName; }

    /**
     * @param string
     */
    public function setFileName(string $fileName):void { $this->fileName = $fileName; }

    /**
     * @return \DateTime
     */
    public function getDate() : \DateTime { return $this->date; }

    /**
     * @param \DateTime $date
     */
    public function setDate(\DateTime $date) { $this->date = $date; }

    /**
     * @return ContractSignature|null
     */
    public function getContractSignature():ContractSignature|null { return $this->contractSignature; }

    /**
     * @param ContractSignature $contractSignature
     */
    public function setContractSignature(ContractSignature $contractSignature):void { $this->contractSignature = $contractSignature; }

}