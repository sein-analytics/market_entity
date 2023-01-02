<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 * Date: 10/5/17
 * Time: 4:07 PM
 */

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\PersistentCollection;

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
    protected int $id;

    /**
     * @ORM\Column(type="string", nullable=false)
     * @var string
     */
    protected string $ext;

    /**
     * @ORM\Column(type="string", nullable=false)
     * @var string
     */
    protected string $mimeType;

    /**
     * @ORM\OneToMany(targetEntity="\App\Entity\DealFile", mappedBy="mime")
     * @var PersistentCollection|ArrayCollection|null
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
     * @return int
     */
    public function getId():int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getExt():string { return $this->ext; }

    /**
     * @return string
     */
    public function getMimeType():string { return $this->mimeType; }

    /**
     * @return PersistentCollection|ArrayCollection|null
     */
    public function getFiles():PersistentCollection|ArrayCollection|null
    { return $this->files; }

}