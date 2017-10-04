<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 * Date: 10/4/17
 * Time: 4:51 PM
 */

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="DocType")
 */
class DocType
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     **/
    protected $id;

    /**
     * @ORM\Column(type=string, nullable=false)
     * @var string
     */
    protected $type;

    /**
     * @ORM\OneToMany(targetEntity="\App\Entity\DealFile, mappedBy="docType")
     * @var ArrayCollection
     */
    protected $dealFiles;

    public function __construct()
    {
        $this->dealFiles = new ArrayCollection();
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
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return ArrayCollection
     */
    public function getDealFiles()
    {
        return $this->dealFiles;
    }


}