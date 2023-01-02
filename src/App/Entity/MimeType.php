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

//use Doctrine\ORM\Mapping as ORM;

/**
 * \Doctrine\ORM\Mapping\Entity(repositoryClass="\App\Repository\MimeType")
 * \Doctrine\ORM\Mapping\Table(name="MimeType")
 */
class MimeType extends AnnotationMappings
{
    /**
     * \Doctrine\ORM\Mapping\Id
     * \Doctrine\ORM\Mapping\Column(type="integer")
     * \Doctrine\ORM\Mapping\GeneratedValue
     **/
    protected int $id;

    /**
     * \Doctrine\ORM\Mapping\Column(type="string", nullable=false)
     * @var string
     */
    protected string $ext;

    /**
     * \Doctrine\ORM\Mapping\Column(type="string", nullable=false)
     * @var string
     */
    protected string $mimeType;

    /**
     * \Doctrine\ORM\Mapping\OneToMany(targetEntity="\App\Entity\DealFile", mappedBy="mime")
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