<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 */

namespace App\Entity;

use App\Service\CreatePropertiesArrayTrait;
use Doctrine\Common\NotifyPropertyChanged;
use Doctrine\ORM\Mapping\ChangeTrackingPolicy;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\PersistentCollection;

/**
 * @ORM\Entity(repositoryClass="\App\Repository\DealFile")
 * @ORM\Table(name="DealFile")
 * @ChangeTrackingPolicy("NOTIFY")
 *
 */
class DealFile extends DomainObject
{
    use CreatePropertiesArrayTrait;

    protected $ignoreDbProperties = [
        'appends' => null,
        'replacements' => null,
        'docAccess' => null
    ];

    protected $addUcIdToPropName = ['loan' => null];

    protected $defaultValueProperties = [];

    /**
     * @ORM\Id @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     **/
    protected $id;

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
    protected $fileName;

    /**
     * @ORM\Column(type="integer", nullable=false)
     * @var integer
     */
    protected $fileSize;

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
    protected $localPath;

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
     * @ORM\Column(type="string", nullable=false)
     * @var string
     */
    protected $virusScanId;

    /**
     * @ORM\Column(type="string", nullable=false)
     * @var string
     */
    protected $scanLocation;

    /**
     * @ORM\Column(type="boolean", nullable=false)
     * @var boolean
     */
    protected $hasViruses;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var string;
     */
    protected $helloSignId;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var string;
     */
    protected $helloSignPath;

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

    public function __construct()
    {
        $this->replacements = new ArrayCollection();
        $this->appends = new ArrayCollection();
        $this->docAccess = new ArrayCollection();
        $this->issues = new ArrayCollection();
        $this->diligence = new ArrayCollection();
    }

    public function addIssue(DueDiligenceIssue $issue){
        $this->issues->add($issue);
    }

    public function addDiligence(DueDiligence $diligence)
    {
        $this->diligence->add($diligence);
    }
    /**
     * @return mixed
     */
    public function getId() { return $this->id; }

    /**
     * @return Deal
     */
    public function getDeal() { return $this->deal; }

    /**
     * @param \App\Entity\Deal $deal
     */
    public function setDeal(Deal $deal)
    {
        $this->implementChange($this,'deal', $this->deal, $deal);
    }

    /**
     * @return string
     */
    public function getFileName() { return $this->fileName; }

    /**
     * @param string $fileName
     */
    public function setFileName(string $fileName)
    {
        $this->implementChange($this,'fileName', $this->fileName, $fileName);
    }

    /**
     * @return float
     */
    public function getFileSize() { return $this->fileSize; }

    /**
     * @param integer $fileSize
     */
    public function setFileSize(int $fileSize)
    {
        $this->implementChange($this,'fileSize', $this->fileSize, $fileSize);
    }

    /**
     * @return MimeType
     */
    public function getMimeType() { return $this->mime; }

    /**
     * @param MimeType $mime
     */
    public function setMimeType(MimeType $mime)
    {
        $this->implementChange($this,'mime', $this->mime, $mime);
    }

    /**
     * @return string | null
     */
    public function getLocalPath() { return $this->localPath; }

    /**
     * @param string $localPath
     */
    public function setLocalPath(string $localPath)
    {
        $this->implementChange($this,'localPath', $this->localPath, $localPath);
    }

    /**
     * @return string
     */
    public function getVirusScanId(): string { return $this->virusScanId; }

    /**
     * @param string $virusScanId
     */
    public function setVirusScanId(string $virusScanId)
    {
        $this->virusScanId = $virusScanId;
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
    public function getUser() { return $this->user; }

    /**
     * @return ArrayCollection
     */
    public function getReplacements() { return $this->replacements; }

    /**
     * @return ArrayCollection
     */
    public function getAppends() { return $this->appends; }

    /**
     * @return DocType
     */
    public function getDocType() { return $this->docType; }

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
    public function getDocAccess() { return $this->docAccess; }

    /**
     * @return string
     */
    public function getScanLocation(): string { return $this->scanLocation; }

    /**
     * @param string $scanLocation
     */
    public function setScanLocation(string $scanLocation)
    {
        $this->scanLocation = $scanLocation;
    }

    /**
     * @return mixed
     */
    public function getHelloSignId() { return $this->helloSignId; }

    /**
     * @param mixed $helloSignId
     */
    public function setHelloSignId($helloSignId)
    {
        $this->helloSignId = $helloSignId;
    }

    /**
     * @return string
     */
    public function getHelloSignPath(): string { return $this->helloSignPath; }

    /**
     * @param string $helloSignPath
     */
    public function setHelloSignPath(string $helloSignPath)
    {
        $this->helloSignPath = $helloSignPath;
    }

    /**
     * @return ArrayCollection
     */
    public function getIssues() { return $this->issues; }

    /**
     * @return ArrayCollection
     */
    public function getDiligence() { return $this->diligence; }

    /**
     * @return Loan
     */
    public function getLoan(): Loan { return $this->loan; }

    /**
     * @param Loan $loan
     */
    public function setLoan(Loan $loan) { $this->loan = $loan; }

    /**
     * @return MimeType
     */
    public function getMime(): MimeType { return $this->mime; }

    /**
     * @param MimeType $mime
     */
    public function setMime(MimeType $mime) { $this->mime = $mime;  }

}