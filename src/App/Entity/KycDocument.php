<?php

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Table(name: 'KycDocument')]
#[ORM\Entity(repositoryClass: \App\Repository\KycDocument::class)]
class KycDocument
{

    /**
     * @var int
     **/
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    protected int $id;

    #[ORM\JoinColumn(name: 'issuer_id', referencedColumnName: 'id', nullable: false)]
    #[ORM\ManyToOne(targetEntity:  Issuer::class)]
    protected Issuer $issuer;

    #[ORM\JoinColumn(name: 'user_id', referencedColumnName: 'id', nullable: false)]
    #[ORM\ManyToOne(targetEntity:  MarketUser::class)]
    protected MarketUser $user;

    #[ORM\JoinColumn(name: 'community_user_id', referencedColumnName: 'id', nullable: true)]
    #[ORM\ManyToOne(targetEntity:  MarketUser::class)]
    protected ?MarketUser $communityUser;

    #[ORM\JoinColumn(name: 'community_issuer_id', referencedColumnName: 'id', nullable: true)]
    #[ORM\ManyToOne(targetEntity:  Issuer::class)]
    protected ?Issuer $communityIssuer;
    
        #[ORM\JoinColumn(name: 'contract_type_id', referencedColumnName: 'id', nullable: false)]
    #[ORM\ManyToOne(targetEntity:  ContractType::class)]
    protected ContractType $contractType;

    #[ORM\JoinColumn(name: 'kyc_asset_type_id', referencedColumnName: 'id', nullable: true)]
    #[ORM\ManyToOne(targetEntity:  DealAsset::class)]
    protected ?DealAsset $assetType;

    #[ORM\JoinColumn(name: 'kyc_type_id', referencedColumnName: 'id', nullable: false)]
    #[ORM\ManyToOne(targetEntity:  KycType::class)]
    protected KycType $kycType;


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
      * @var ?string
      */
     #[ORM\Column(type: 'string', nullable: true)]
     protected ?string $fileName;

    /**
     * @var DateTime|null
     **/
    #[ORM\Column(type: 'datetime', nullable: true)]
    protected $date = null;

    /**
     * @var ArrayCollection
     */
    #[ORM\ManyToMany(targetEntity:  Issuer::class, mappedBy: 'kycDocuments')]
    protected $accessIssuer;

    #[ORM\JoinColumn(name: 'contract_signature_id', referencedColumnName: 'id', unique: true, nullable: true)]
    #[ORM\OneToOne(targetEntity: ContractSignature::class)]
    protected ?ContractSignature $contractSignature;

    #[ORM\JoinColumn(name: 'kyc_doc_request_id', referencedColumnName: 'id', unique: true, nullable: true)]
    #[ORM\OneToOne(targetEntity: KycDocRequest::class)]
    protected ?KycDocRequest $kycDocRequest;
    
    function __construct()
    {
        $this->issuer = new Issuer();
        $this->user = new MarketUser();
        $this->communityIssuer = new Issuer();
        $this->communityUser = new MarketUser();
        $this->contractType = new ContractType();
        $this->accessIssuer = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId():int { return $this->id; }
    
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

    /**
     * @return MarketUser|null
     */
    public function getCommunityUser():MarketUser|null { return $this->communityUser; }

    /**
     * @param MarketUser $communityUser
     */
    public function setCommunityUser(MarketUser $communityUser):void { $this->communityUser = $communityUser; }

    /**
     * @return Issuer|null
     */
    public function getCommunityIssuer():Issuer|null { return $this->communityIssuer; }

    /**
     * @param Issuer $communityIssuer
     */
    public function setCommunityIssuer(Issuer $communityIssuer):void { $this->communityIssuer = $communityIssuer; }

    /**
     * @return ContractType
     */
    public function getContractType():ContractType { return $this->contractType; }

    /**
     * @param ContractType $contractType
     */
    public function setContractType(ContractType $contractType):void { $this->contractType = $contractType; }

    /**
     * @return DealAsset|null
     */
    public function getAssetType():DealAsset|null { return $this->assetType; }

    /**
     * @param DealAsset $assetType
     */
    public function setAssetType(DealAsset $assetType):void { $this->assetType = $assetType; }
    
    /**
     * @return KycType
     */
    public function getKycType():KycType { return $this->kycType; }

    /**
     * @param KycType $kycType
     */
    public function setKycType(KycType $kycType):void { $this->kycType = $kycType; }

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
    public function getFileName():string|null { return $this->fileName; }

    /**
     * @param string
     */
    public function setFileName(string $fileName):void { $this->fileName = $fileName; }

    /**
     * @return DateTime
     */
    public function getDate() : ?DateTime { return $this->date; }

    /**
     * @param DateTime $date
     */
    public function setDate(DateTime $date) { $this->date = $date; }
    
    public function addAccessIssuer(Issuer $accessIssuer)
    {
        $this->accessIssuer->add($accessIssuer);
    }

    /**
     * @return ArrayCollection
     */
    public function getAccessIssuer():ArrayCollection { return $this->accessIssuer; }

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