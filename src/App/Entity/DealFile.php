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
/**
 * @ORM\Entity(repositoryClass="\App\Repository\DealFile")
 * @ORM\Table(name="DealFile")
 * @ChangeTrackingPolicy("NOTIFY")
 *
 */
class DealFile implements NotifyPropertyChanged
{
    use NotifyChangeTrait, CreatePropertiesArrayTrait;

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

    public function __construct()
    {
        $this->replacements = new ArrayCollection();
        $this->appends = new ArrayCollection();
        $this->docAccess = new ArrayCollection();
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
        $this->_onPropertyChanged('deal', $this->deal, $deal);
        $this->deal = $deal;
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
        $this->_onPropertyChanged('fileName', $this->fileName, $fileName);
        $this->fileName = $fileName;
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
        $this->_onPropertyChanged('fileSize', $this->fileSize, $fileSize);
        $this->fileSize = $fileSize;
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
        $this->_onPropertyChanged('mime', $this->mime, $mime);
        $this->mime = $mime;
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
        $this->_onPropertyChanged('localPath', $this->localPath, $localPath);
        $this->localPath = $localPath;
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



}