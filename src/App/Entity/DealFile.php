<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 */

namespace App\Entity;

use Doctrine\Common\NotifyPropertyChanged;
use Doctrine\ORM\Mapping\ChangeTrackingPolicy;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
/**
 * @ORM\Entity
 * @ORM\Table(name="DealFile")
 * @ChangeTrackingPolicy("NOTIFY")
 *
 */
class DealFile implements NotifyPropertyChanged
{
    use NotifyChangeTrait;

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
     * @ORM\Column(type="decimal", precision=8, scale=2, nullable=false)
     * @var float
     */
    protected $fileSize;

    /**
     * @ORM\Column(type="string", nullable=false)
     * @var string
     */
    protected $mimeType;

    /**
     * @ORM\Column(type="string", nullable=false)
     * @var string
     */
    protected $prefix;

    /**
     * @ORM\Column(type="string", nullable=false)
     * @var string
     */
    protected $s3Bucket;

    /**
     * @ORM\Column(type="string", nullable=false)
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

    public function __construct()
    {
        $this->replacements = new ArrayCollection();
        $this->appends = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Deal
     */
    public function getDeal()
    {
        return $this->deal;
    }

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
    public function getFileName()
    {
        return $this->fileName;
    }

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
    public function getFileSize()
    {
        return $this->fileSize;
    }

    /**
     * @param float $fileSize
     */
    public function setFileSize(float $fileSize)
    {
        $this->_onPropertyChanged('fileSize', $this->fileSize, $fileSize);
        $this->fileSize = $fileSize;
    }

    /**
     * @return mixed
     */
    public function getMimeType()
    {
        return $this->mimeType;
    }

    /**
     * @param string $mimeType
     */
    public function setMimeType(string $mimeType)
    {
        $this->_onPropertyChanged('mimeType', $this->mimeType, $mimeType);
        $this->mimeType = $mimeType;
    }

    /**
     * @return string
     */
    public function getS3Bucket()
    {
        return $this->s3Bucket;
    }

    /**
     * @param string $s3Bucket
     */
    public function setS3Path(string $s3Bucket)
    {
        $this->_onPropertyChanged('s3Bucket', $this->s3Bucket, $s3Bucket);
        $this->s3Bucket = $s3Bucket;
    }

    /**
     * @return string | null
     */
    public function getLocalPath()
    {
        return $this->localPath;
    }

    /**
     * @param string $localPath
     */
    public function setLocalPath(string $localPath)
    {
        $this->_onPropertyChanged('localPath', $this->localPath, $localPath);
        $this->localPath = $localPath;
    }

    /**
     * @return MarketUser
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @return mixed
     */
    public function getReplacements()
    {
        return $this->replacements;
    }

    /**
     * @return mixed
     */
    public function getAppends()
    {
        return $this->appends;
    }

    /**
     * @return DocType
     */
    public function getDocType()
    {
        return $this->docType;
    }

    /**
     * @return DocAccess
     */
    public function getDocAccess()
    {
        return $this->docAccess;
    }

    /**
     * @param string $prefix
     */
    public function setPrefix(string $prefix)
    {
        $this->prefix = $prefix;
    }



    /**
     * @return string
     */
    public function getPrefix()
    {
        return $this->prefix;
    }


}