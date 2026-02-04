<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 */

namespace App\Entity;

use DateTime;
use App\Service\CreatePropertiesArrayTrait;
use Doctrine\ORM\Mapping\ChangeTrackingPolicy;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\PersistentCollection;

#[ORM\Table(name: 'DealFile')]
#[ORM\Entity(repositoryClass: \App\Repository\DealFile::class)]
#[ORM\ChangeTrackingPolicy('NOTIFY')]
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

    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    protected int $id;

    /**
     * @var Deal
     */
    #[ORM\JoinColumn(name: 'deal_id', referencedColumnName: 'id', nullable: false)]
    #[ORM\ManyToOne(targetEntity:  \App\Entity\Deal::class, inversedBy: 'dealDocs')]
    protected $deal;

    /**
     * @var MarketUser
     */
    #[ORM\JoinColumn(name: 'user_id', referencedColumnName: 'id', nullable: false)]
    #[ORM\ManyToOne(targetEntity:  \App\Entity\MarketUser::class, inversedBy: 'files')]
    protected $user;

    /**
     * @var Loan
     */
    #[ORM\JoinColumn(name: 'loan_id', referencedColumnName: 'id', nullable: true)]
    #[ORM\ManyToOne(targetEntity:  \App\Entity\Loan::class, inversedBy: 'files')]
    protected $loan;

    /**
     * @var DocAccess
     */
    #[ORM\OneToMany(targetEntity:  \App\Entity\DocAccess::class, mappedBy: 'document')]
    protected $docAccess;

    /**
     * @var string
     */
    #[ORM\Column(type: 'string', nullable: false)]
    protected string $fileName ='';

    /**
     * @var int
     */
    #[ORM\Column(type: 'integer', nullable: false)]
    protected int $fileSize=0;

    /**
     * @var MimeType
     */
    #[ORM\JoinColumn(name: 'mime_id', referencedColumnName: 'id', nullable: false)]
    #[ORM\ManyToOne(targetEntity:  \App\Entity\MimeType::class, inversedBy: 'files')]
    protected $mime;

    /**
     * @var string
     */
    #[ORM\Column(type: 'string', nullable: true)]
    protected string $publicPath ='';

    /**
     * @var ArrayCollection
     **/
    #[ORM\JoinTable(name: 'file_replacements')]
    #[ORM\JoinColumn(name: 'file_id', referencedColumnName: 'id')]
    #[ORM\InverseJoinColumn(name: 'replacement_id', referencedColumnName: 'id')]
    #[ORM\ManyToMany(targetEntity:  \App\Entity\DealFile::class)]
    protected $replacements;

    /**
     * @var ArrayCollection
     */
    #[ORM\JoinTable(name: 'file_appends')]
    #[ORM\JoinColumn(name: 'file_id', referencedColumnName: 'id')]
    #[ORM\InverseJoinColumn(name: 'append_id', referencedColumnName: 'id')]
    #[ORM\ManyToMany(targetEntity:  \App\Entity\DealFile::class)]
    protected $appends;

    /**
     * @var DocType
     */
    #[ORM\JoinColumn(name: 'doc_type_id', referencedColumnName: 'id', nullable: false)]
    #[ORM\ManyToOne(targetEntity:  \App\Entity\DocType::class, inversedBy: 'dealFiles')]
    protected $docType;

    /**
     * @var FileAccessCode
     */
    #[ORM\JoinColumn(name: 'access_id', referencedColumnName: 'id', nullable: true)]
    #[ORM\ManyToOne(targetEntity:  \App\Entity\FileAccessCode::class)]
    protected $accessId;

    /**
     * @var string
     */
    #[ORM\Column(type: 'string', nullable: false)]
    protected string $assetId = '';

    /**
     * @var string
     */
    #[ORM\Column(type: 'string', nullable: false)]
    protected string $scanLocation = '';

    /**
     * @var boolean
     */
    #[ORM\Column(type: 'boolean', nullable: false)]
    protected $hasViruses = 0;

    /**
     * @var ArrayCollection
     */
    #[ORM\OneToMany(targetEntity:  \App\Entity\DueDiligenceIssue::class, mappedBy: 'file')]
    protected $issues;

    /**
     * @var ArrayCollection
     */
    #[ORM\ManyToMany(targetEntity:  \App\Entity\DueDiligence::class, mappedBy: 'files')]
    protected $diligence;

    /**
     * @var DateTime|null
     **/
    #[ORM\Column(type: 'datetime', nullable: true)]
    protected $date = null;

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
     * @return DateTime
     */
    public function getDate() : ?DateTime { return $this->date; }

    /**
     * @param DateTime $date
     */
    public function setDate(DateTime $date) { $this->date = $date; }

}