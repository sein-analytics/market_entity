<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 * Date: 11/5/17
 * Time: 11:23 AM
 */

namespace App\Entity\Typed;


use App\Entity\MappedUserType;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

abstract class MappedTypeAbstract
{
    /**
     * @ORM\Id @ORM\Column(type="integer")
     * @ORM\GeneratedValue */
    protected $id;

    /** @ORM\Column(type="string", nullable=false) */
    protected $label;

    /** @ORM\Column(type="string", nullable=false) */
    protected $slug;

    /** @var  ArrayCollection */
    protected $mappedUserType;

    public function __construct()
    {
        $this->mappedUserType = new ArrayCollection();
    }

    public function addMappedUserType(MappedUserType $mappedUserType){
        $this->mappedUserType->add($mappedUserType);
    }
    /**
     * @return mixed
     */
    public function getId() { return $this->id; }

    /**
     * @return mixed
     */
    public function getLabel(){ return $this->label; }

    /**
     * @return mixed
     */
    public function getSlug() { return $this->slug; }

    function getMappedUserTypes(): ArrayCollection { return $this->mappedUserType; }
}