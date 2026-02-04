<?php

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'DealContract')]
#[ORM\Entity(repositoryClass: \App\Repository\DealContract::class)]
class DealContract
{

    /**
     * @var int
     **/
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    protected int $id;

    #[ORM\JoinColumn(name: 'deal_id', referencedColumnName: 'id', nullable: false)]
    #[ORM\ManyToOne(targetEntity:  \App\Entity\Deal::class, inversedBy: 'contracts')]
    protected Deal $deal;

    #[ORM\JoinColumn(name: 'bid_id', referencedColumnName: 'id', nullable: true)]
    #[ORM\ManyToOne(targetEntity:  \App\Entity\Bid::class)]
    protected ?Bid $bid;

    #[ORM\JoinColumn(name: 'buyer_id', referencedColumnName: 'id', nullable: true)]
    #[ORM\ManyToOne(targetEntity:  \App\Entity\MarketUser::class, inversedBy: 'contracts')]
    protected ?MarketUser $buyer;

    #[ORM\JoinColumn(name: 'user_id', referencedColumnName: 'id', nullable: false)]
    #[ORM\ManyToOne(targetEntity:  \App\Entity\MarketUser::class, inversedBy: 'contracts')]
    protected MarketUser $user;


    #[ORM\JoinColumn(name: 'doc_type_id', referencedColumnName: 'id', nullable: false)]
    #[ORM\ManyToOne(targetEntity:  \App\Entity\DocType::class, inversedBy: 'dealFiles')]
    protected DocType $docType;

    #[ORM\JoinColumn(name: 'deal_asset_id', referencedColumnName: 'id', nullable: false)]
    #[ORM\ManyToOne(targetEntity:  \App\Entity\DealAsset::class)]
    protected DealAsset $dealAsset;

    /**
     * @var string
     */
    #[ORM\Column(type: 'string', nullable: false)]
    protected string $assetId = '';

    /**
     * @var string
     */
    #[ORM\Column(type: 'string', nullable: false)]
    protected string $secureUrl = '';

    /**
      * @var string
      */
     #[ORM\Column(type: 'string', nullable: false)]
     protected string $fileName = '';

    /**
     * @var DateTime
     **/
    #[ORM\Column(type: 'datetime', nullable: false)]
    protected $date;

    #[ORM\JoinColumn(name: 'contract_signature_id', referencedColumnName: 'id', unique: true, nullable: true)]
    #[ORM\OneToOne(targetEntity: ContractSignature::class)]
    protected ?ContractSignature $contractSignature;

    #[ORM\JoinColumn(name: 'kyc_doc_request_id', referencedColumnName: 'id', unique: true, nullable: true)]
    #[ORM\OneToOne(targetEntity: KycDocRequest::class)]
    protected ?KycDocRequest $kycDocRequest;

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
     * @return DateTime
     */
    public function getDate() : DateTime { return $this->date; }

    /**
     * @param DateTime $date
     */
    public function setDate(DateTime $date) { $this->date = $date; }

    /**
     * @return ContractSignature|null
     */
    public function getContractSignature():ContractSignature|null { return $this->contractSignature; }

    /**
     * @param ContractSignature $contractSignature
     */
    public function setContractSignature(ContractSignature $contractSignature):void { $this->contractSignature = $contractSignature; }

    /**
     * @return KycDocRequest|null
     */
    public function getKycDocRequest():KycDocRequest|null { return $this->kycDocRequest; }

    /**
     * @param KycDocRequest $kycDocRequest
     */
    public function setKycDocRequest(KycDocRequest $kycDocRequest):void { $this->kycDocRequest = $kycDocRequest; }

}