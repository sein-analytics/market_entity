<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 */

namespace App\Entity;

use App\Service\CreatePropertiesArrayTrait;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\OneToOne;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\ManyToMany;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\JoinColumns;
use Doctrine\ORM\Mapping\JoinTable;
use Doctrine\ORM\Mapping\GeneratedValue;

use Doctrine\ORM\Mapping\DiscriminatorColumn;
use Doctrine\ORM\Mapping\DiscriminatorMap;

use Doctrine\ORM\Mapping\Index;
use Doctrine\ORM\Mapping\ChangeTrackingPolicy;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\PersistentCollection;

/**
 * \Doctrine\ORM\Mapping\Entity(repositoryClass="\App\Repository\DealFile")
 * \Doctrine\ORM\Mapping\Table(name="DealFile")
 * \Doctrine\ORM\Mapping\ChangeTrackingPolicy("NOTIFY")
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
     * \Doctrine\ORM\Mapping\Id
     * \Doctrine\ORM\Mapping\Column(type="integer")
     * \Doctrine\ORM\Mapping\GeneratedValue
     **/
    protected int $id;

    /**
     * \Doctrine\ORM\Mapping\ManyToOne(targetEntity="\App\Entity\Deal", inversedBy="dealDocs")
     * \Doctrine\ORM\Mapping\JoinColumn(name="deal_id", referencedColumnName="id", nullable=false)
     * @var Deal
     */
    protected $deal;

    /**
     * \Doctrine\ORM\Mapping\ManyToOne(targetEntity="\App\Entity\MarketUser", inversedBy="files")
     * \Doctrine\ORM\Mapping\JoinColumn(name="user_id", referencedColumnName="id", nullable=false)
     * @var MarketUser
     */
    protected $user;

    /**
     * \Doctrine\ORM\Mapping\ManyToOne(targetEntity="\App\Entity\Loan", inversedBy="files")
     * \Doctrine\ORM\Mapping\JoinColumn(name="loan_id", referencedColumnName="id", nullable=true)
     * @var Loan
     */
    protected $loan;

    /**
     * \Doctrine\ORM\Mapping\OneToMany(targetEntity="\App\Entity\DocAccess", mappedBy="document")
     * @var DocAccess
     */
    protected $docAccess;

    /**
     * \Doctrine\ORM\Mapping\Column(type="string", nullable=false)
     * @var string
     */
    protected string $fileName ='';

    /**
     * \Doctrine\ORM\Mapping\Column(type="integer", nullable=false)
     * @var int
     */
    protected int $fileSize=0;

    /**
     * \Doctrine\ORM\Mapping\ManyToOne(targetEntity="\App\Entity\MimeType", inversedBy="files")
     * \Doctrine\ORM\Mapping\JoinColumn(name="mime_id", referencedColumnName="id", nullable=false)
     * @var MimeType
     */
    protected $mime;

    /**
     * \Doctrine\ORM\Mapping\Column(type="string", nullable=true)
     * @var string
     */
    protected string $publicPath ='';

    /**
     * \Doctrine\ORM\Mapping\ManyToMany(targetEntity="\App\Entity\DealFile")
     * \Doctrine\ORM\Mapping\JoinTable(name="file_replacements",
     *     joinColumns={\Doctrine\ORM\Mapping\JoinColumn(name="file_id", referencedColumnName="id")},
     *     inverseJoinColumns={\Doctrine\ORM\Mapping\JoinColumn(name="replacement_id", referencedColumnName="id")}
     *     )
     * @var ArrayCollection
     **/
    protected $replacements;

    /**
     * \Doctrine\ORM\Mapping\ManyToMany(targetEntity="\App\Entity\DealFile")
     * \Doctrine\ORM\Mapping\JoinTable(name="file_appends",
     *     joinColumns={\Doctrine\ORM\Mapping\JoinColumn(name="file_id", referencedColumnName="id")},
     *     inverseJoinColumns={\Doctrine\ORM\Mapping\JoinColumn(name="append_id", referencedColumnName="id")}
     *     )
     * @var ArrayCollection
     */
    protected $appends;

    /**
     * \Doctrine\ORM\Mapping\ManyToOne(targetEntity="\App\Entity\DocType", inversedBy="dealFiles")
     * \Doctrine\ORM\Mapping\JoinColumn(name="doc_type_id", referencedColumnName="id", nullable=false)
     * @var DocType
     */
    protected $docType;

    /**
     * \Doctrine\ORM\Mapping\ManyToOne(targetEntity="\App\Entity\FileAccessCode")
     * \Doctrine\ORM\Mapping\JoinColumn(name="access_id", referencedColumnName="id", nullable=true)
     * @var FileAccessCode
     */
    protected $accessId;

    /**
     * \Doctrine\ORM\Mapping\Column(type="string", nullable=false)
     * @var string
     */
    protected string $assetId = '';

    /**
     * \Doctrine\ORM\Mapping\Column(type="string", nullable=false)
     * @var string
     */
    protected string $scanLocation = '';

    /**
     * \Doctrine\ORM\Mapping\Column(type="boolean", nullable=false)
     * @var boolean
     */
    protected $hasViruses = 0;

    /**
     * \Doctrine\ORM\Mapping\Column(type="string", nullable=true)
     * @var ?string;
     */
    protected ?string $signatureId;

    /**
     * \Doctrine\ORM\Mapping\Column(type="string", nullable=true)
     * @var ?string;
     */
    protected ?string $signaturePath;

    /**
     * \Doctrine\ORM\Mapping\OneToMany(targetEntity="\App\Entity\DueDiligenceIssue", mappedBy="file")
     * @var ArrayCollection
     */
    protected $issues;

    /**
     * \Doctrine\ORM\Mapping\ManyToMany(targetEntity="\App\Entity\DueDiligence", mappedBy="files")
     * @var ArrayCollection
     */
    protected $diligence;

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

}