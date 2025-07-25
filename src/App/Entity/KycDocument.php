<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass="\App\Repository\KycDocument")
 * @ORM\Table(name="KycDocument")
 */
class KycDocument
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @var int
     **/
    protected int $id;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\Issuer")
     * @ORM\JoinColumn(name="issuer_id", referencedColumnName="id", nullable=false)
     */
    protected Issuer $issuer;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\MarketUser")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false)
     */
    protected MarketUser $user;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\MarketUser")
     * @ORM\JoinColumn(name="community_user_id", referencedColumnName="id", nullable=true)
     */
    protected ?MarketUser $communityUser;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\Issuer")
     * @ORM\JoinColumn(name="community_issuer_id", referencedColumnName="id", nullable=true)
     */
    protected ?Issuer $communityIssuer;
    
        /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\ContractType")
     * @ORM\JoinColumn(name="contract_type_id", referencedColumnName="id", nullable=false)
     */
    protected ContractType $contractType;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\DealAsset")
     * @ORM\JoinColumn(name="kyc_asset_type_id", referencedColumnName="id", nullable=true)
     */
    protected ?DealAsset $assetType;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\KycType")
     * @ORM\JoinColumn(name="kyc_type_id", referencedColumnName="id", nullable=false)
     */
    protected KycType $kycType;


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
     * @ORM\Column(type="string", nullable=true)
     * @var ?string
     */
     protected ?string $fileName;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @var \DateTime|null
     **/
    protected $date = null;

    /**
     * @ORM\ManyToMany(targetEntity="\App\Entity\Issuer", mappedBy="kycDocuments")
     * @var ArrayCollection
     */
    protected $accessIssuer;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\ContractSignature")
     * @ORM\JoinColumn(name="contract_signature_id", referencedColumnName="id", unique=true, nullable=true)
     */
    protected ?ContractSignature $contractSignature;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\KycDocRequest")
     * @ORM\JoinColumn(name="kyc_doc_request_id", referencedColumnName="id", unique=true, nullable=true)
    */
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
     * @return \DateTime
     */
    public function getDate() : ?\DateTime { return $this->date; }

    /**
     * @param \DateTime $date
     */
    public function setDate(\DateTime $date) { $this->date = $date; }
    
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