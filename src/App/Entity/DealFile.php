<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 */

namespace App\Entity;

use App\Service\CreatePropertiesArrayTrait;
use Doctrine\ORM\Mapping\ChangeTrackingPolicy;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\PersistentCollection;

/**
 * @ORM\Entity(repositoryClass="\App\Repository\DealFile")
 * @ORM\Table(name="DealFile")
 * @ORM\ChangeTrackingPolicy("NOTIFY")
 *
 */
class DealFile extends DomainObject
{
    use CreatePropertiesArrayTrait;

    protected array $ignoreDbProperties = [
        'appends' => null,
        'replacements' => null,
        'docAccess' => null
    ];

    protected array $addUcIdToPropName = ['loan' => null];

    protected array $defaultValueProperties = [];

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     **/
    protected int $id;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\Deal", inversedBy="dealDocs")
     * @ORM\JoinColumn(name="deal_id", referencedColumnName="id", nullable=false)
     * @var Deal
     */
    protected $deal;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\MarketUser", inversedBy="files")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false)
     * @var MarketUser
     */
    protected $user;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\Loan", inversedBy="files")
     * @ORM\JoinColumn(name="loan_id", referencedColumnName="id", nullable=true)
     * @var Loan
     */
    protected $loan;

    /**
     * @ORM\OneToMany(targetEntity="\App\Entity\DocAccess", mappedBy="document")
     * @var DocAccess
     */
    protected $docAccess;

    /**
     * @ORM\Column(type="string", nullable=false)
     * @var string
     */
    protected string $fileName ='';

    /**
     * @ORM\Column(type="integer", nullable=false)
     * @var int
     */
    protected int $fileSize=0;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\MimeType", inversedBy="files")
     * @ORM\JoinColumn(name="mime_id", referencedColumnName="id", nullable=false)
     * @var MimeType
     */
    protected $mime;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var string
     */
    protected string $publicPath ='';

    /**
     * @ORM\ManyToMany(targetEntity="\App\Entity\DealFile")
     * @ORM\JoinTable(name="file_replacements",
     *     joinColumns={@ORM\JoinColumn(name="file_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="replacement_id", referencedColumnName="id")}
     *     )
     * @var ArrayCollection
     **/
    protected $replacements;

    /**
     * @ORM\ManyToMany(targetEntity="\App\Entity\DealFile")
     * @ORM\JoinTable(name="file_appends",
     *     joinColumns={@ORM\JoinColumn(name="file_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="append_id", referencedColumnName="id")}
     *     )
     * @var ArrayCollection
     */
    protected $appends;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\DocType", inversedBy="dealFiles")
     * @ORM\JoinColumn(name="doc_type_id", referencedColumnName="id", nullable=false)
     * @var DocType
     */
    protected $docType;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\FileAccessCode")
     * @ORM\JoinColumn(name="access_id", referencedColumnName="id", nullable=true)
     * @var FileAccessCode
     */
    protected $accessId;

    /**
     * @ORM\Column(type="string", nullable=false)
     * @var string
     */
    protected string $assetId = '';

    /**
     * @ORM\Column(type="string", nullable=false)
     * @var string
     */
    protected string $scanLocation = '';

    /**
     * @ORM\Column(type="boolean", nullable=false)
     * @var boolean
     */
    protected $hasViruses = 0;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var ?string;
     */
    protected ?string $signatureId;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var ?string;
     */
    protected ?string $signaturePath;

    /**
     * @ORM\OneToMany(targetEntity="\App\Entity\DueDiligenceIssue", mappedBy="file")
     * @var ArrayCollection
     */
    protected $issues;

    /**
     * @ORM\ManyToMany(targetEntity="\App\Entity\DueDiligence", mappedBy="files")
     * @var ArrayCollection
     */
    protected $diligence;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\MarketUser")
     * @ORM\JoinColumn(name="community_user_id", referencedColumnName="id", nullable=true)
     */
    protected ?MarketUser $communityUser;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\ContractStatus")
     * @ORM\JoinColumn(name="contract_status_id", referencedColumnName="id", nullable=true)
     */
    protected ?ContractStatus $contractStatus;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var ?string
     */
    protected ?string $senderSignature;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var ?string
     */
    protected ?string $receiverSignature;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\ContractSignature")
     * @ORM\JoinColumn(name="contract_signature_id", referencedColumnName="id", unique=true, nullable=true)
     */
    protected ?ContractSignature $contractSignature;

    public function __construct()
    {
        $this->replacements = new ArrayCollection();
        $this->appends = new ArrayCollection();
        $this->docAccess = new ArrayCollection();
        $this->issues = new ArrayCollection();
        $this->diligence = new ArrayCollection();
        parent::__construct();
    }

    public function addIssue(DueDiligenceIssue $issue){
        $this->issues->add($issue);
    }

    public function addDiligence(DueDiligence $diligence)
    {
        $this->diligence->add($diligence);
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
    public function setDeal(Deal $deal):void
    {
        $this->implementChange($this,'deal', $this->deal, $deal);
    }

    /**
     * @return string
     */
    public function getFileName():string  { return $this->fileName; }

    /**
     * @param string $fileName
     */
    public function setFileName(string $fileName):void
    {
        $this->implementChange($this,'fileName', $this->fileName, $fileName);
    }

    /**
     * @return float
     */
    public function getFileSize():float { return $this->fileSize; }

    /**
     * @param float $fileSize
     */
    public function setFileSize(float $fileSize):void
    {
        $this->implementChange($this,'fileSize', $this->fileSize, $fileSize);
    }

    /**
     * @return MimeType
     */
    public function getMimeType():MimeType { return $this->mime; }

    /**
     * @param MimeType $mime
     */
    public function setMimeType(MimeType $mime):void
    {
        $this->implementChange($this,'mime', $this->mime, $mime);
    }

    /**
     * @return string
     */
    public function getPublicPath():string { return $this->publicPath; }

    /**
     * @param string $publicPath
     */
    public function setPublicPath(string $publicPath):void
    {
        $this->implementChange($this,'publicPath', $this->publicPath, $publicPath);
    }

    /**
     * @return string
     */
    public function getAssetId(): string { return $this->assetId; }

    /**
     * @param string $assetId
     */
    public function setAssetId(string $assetId):void
    {
        $this->assetId = $assetId;
    }

    /**
     * @return bool
     */
    public function isHasViruses(): bool
    {
        return $this->hasViruses;
    }

    /**
     * @param bool $hasViruses
     */
    public function setHasViruses(bool $hasViruses)
    {
        $this->hasViruses = $hasViruses;
    }

    /**
     * @return MarketUser
     */
    public function getUser():MarketUser { return $this->user; }

    /**
     * @return ArrayCollection
     */
    public function getReplacements():ArrayCollection { return $this->replacements; }

    /**
     * @return ArrayCollection
     */
    public function getAppends():ArrayCollection { return $this->appends; }

    /**
     * @return DocType
     */
    public function getDocType():DocType { return $this->docType; }

    /**
     * @return FileAccessCode
     */
    public function getAccessId():FileAccessCode { return $this->accessId; }

    /**
     * @param FileAccessCode $mode
     */
    public function setAccessId(FileAccessCode $mode) { $this->accessId = $mode; }

    /**
     * @param DocType $docType
     */
    public function setDocType(DocType $docType)
    {
        $this->docType = $docType;
    }

    /**
     * @return DocAccess
     */
    public function getDocAccess():DocAccess { return $this->docAccess; }

    /**
     * @return string
     */
    public function getScanLocation(): string { return $this->scanLocation; }

    /**
     * @param string $scanLocation
     */
    public function setScanLocation(string $scanLocation):void
    {
        $this->scanLocation = $scanLocation;
    }

    /**
     * @return null|string
     */
    public function getSignatureId():?string { return $this->signatureId; }

    /**
     * @param string $signatureId
     */
    public function setSignatureId(string $signatureId):void
    {
        $this->signatureId = $signatureId;
    }

    /**
     * @return string|null
     */
    public function getSignaturePath():?string { return $this->signaturePath; }

    /**
     * @param string $signaturePath
     */
    public function setSignaturePath(string $signaturePath):void
    {
        $this->signaturePath = $signaturePath;
    }

    /**
     * @return ArrayCollection
     */
    public function getIssues():ArrayCollection { return $this->issues; }

    /**
     * @return ArrayCollection
     */
    public function getDiligence():ArrayCollection { return $this->diligence; }

    /**
     * @return Loan
     */
    public function getLoan(): Loan { return $this->loan; }

    /**
     * @param Loan $loan
     */
    public function setLoan(Loan $loan):void { $this->loan = $loan; }

    /**
     * @return MimeType
     */
    public function getMime(): MimeType { return $this->mime; }

    /**
     * @param MimeType $mime
     */
    public function setMime(MimeType $mime):void { $this->mime = $mime;  }

    /**
     * @return MarketUser|null
     */
    public function getCommunityUser():MarketUser|null { return $this->communityUser; }

    /**
     * @param MarketUser $communityUser
     */
    public function setCommunityUser(MarketUser $communityUser):void { $this->communityUser = $communityUser; }

    /**
     * @return ContractStatus|null
     */
    public function getContractStatus():ContractStatus|null { return $this->contractStatus; }

    /**
     * @param ContractStatus $contractStatus
     */
    public function setContractStatus(ContractStatus $contractStatus):void { $this->contractStatus = $contractStatus; }

    /**
     * @return null|string
     */
    public function getSenderSignature():string|null { return $this->senderSignature; }

    /**
     * @param string
     */
    public function setSenderSignature(string $senderSignature):void { $this->senderSignature = $senderSignature; }

    /**
     * @return null|string
     */
    public function getReceiverSignature():string|null { return $this->receiverSignature; }

    /**
     * @param string
     */
    public function setReceiverSignature(string $receiverSignature):void { $this->receiverSignature = $receiverSignature; }

    /**
     * @return ContractSignature|null
     */
    public function getContractSignature():ContractSignature|null { return $this->contractSignature; }

    /**
     * @param ContractSignature $contractSignature
     */
    public function setContractSignature(ContractSignature $contractSignature):void { $this->contractSignature = $contractSignature; }

}