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
     * @var \App\Entity\Deal
     */
    protected $deal;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\MarketUser", inversedBy="files")
     */
    protected $user;


    /**
     * @ORM\OneToMany(targetEntity="\App\Entity\DocAccess", mappedBy="document")
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
    protected $s3Path;

    /**
     * @ORM\Column(type="string", nullable=false)
     * @var string
     */
    protected $localPath;

    /** @ORM\OneToOne(targetEntity="\App\Entity\DealFile") **/
    protected $replacedBy;

    /** @ORM\OneToONe(targetEntity="\App\Entity\DealFile")  */
    protected $appendedTo;

    public function __construct()
    {
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
    public function getS3Path()
    {
        return $this->s3Path;
    }

    /**
     * @param string $s3Path
     */
    public function setS3Path(string $s3Path)
    {
        $this->_onPropertyChanged('s3Path', $this->s3Path, $s3Path);
        $this->s3Path = $s3Path;
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




}