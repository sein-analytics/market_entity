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

#[ORM\Table(name: 'MimeType')]
#[ORM\Entity(repositoryClass: \App\Repository\MimeType::class)]
class MimeType 
{
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    protected int $id;

    /**
     * @var string
     */
    #[ORM\Column(type: 'string', nullable: false)]
    protected string $ext;

    /**
     * @var string
     */
    #[ORM\Column(type: 'string', nullable: false)]
    protected string $mimeType;

    /**
     * @var PersistentCollection|ArrayCollection|null
     */
    #[ORM\OneToMany(targetEntity:  \App\Entity\DealFile::class, mappedBy: 'mime')]
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