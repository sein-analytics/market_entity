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
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    protected int $id;

    /**
     * @ORM\Column(type="string", nullable=false)
     */
    protected string $label;

    /**
     * @ORM\Column(type="string", nullable=false)
     */
    protected string $slug;

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
     * @return int
     */
    public function getId():int { return $this->id; }

    /**
     * @return string
     */
    public function getLabel():string { return $this->label; }

    /**
     * @return string
     */
    public function getSlug():string { return $this->slug; }

    function getMappedUserTypes(): ArrayCollection { return $this->mappedUserType; }
}