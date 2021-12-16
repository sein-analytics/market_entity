<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 * Date: 10/5/17
 * Time: 4:07 PM
 */

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="\App\Repository\MimeType")
 * @ORM\Table(name="MimeType")
 */
class MimeType
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     **/
    protected $id;

    /**
     * @ORM\Column(type="string", nullable=false)
     * @var string
     */
    protected $ext;

    /**
     * @ORM\Column(type="string", nullable=false)
     * @var string
     */
    protected $mimeType;

    /**
     * @ORM\OneToMany(targetEntity="\App\Entity\DealFile", mappedBy="mime")
     * @var ArrayCollection
     */
    protected $files;

    public function __construct()
    {
        $this->files = new ArrayCollection();
    }

    public function addFile(DealFile $file){
        $this->files->add($file);
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getExt() { return $this->ext; }

    /**
     * @return string
     */
    public function getMimeType() { return $this->mimeType; }

    /**
     * @return ArrayCollection
     */
    public function getFiles() { return $this->files; }

}