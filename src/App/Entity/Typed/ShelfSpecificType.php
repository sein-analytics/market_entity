<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 * Date: 6/27/16
 * Time: 4:18 PM
 */

namespace App\Entity\Typed;

use App\Entity\AnnotationMappings;
use Doctrine\ORM\Mapping as ORM;
/**
 * @author Samuel Belu-John
 * \Doctrine\ORM\Mapping\Entity
 * \Doctrine\ORM\Mapping\Table(name="ShelfSpecificType")
 */
class ShelfSpecificType extends AnnotationMappings
{
    /**
     * \Doctrine\ORM\Mapping\Id
     * \Doctrine\ORM\Mapping\Column(type="integer")
     * \Doctrine\ORM\Mapping\GeneratedValue
     */
    protected int $id;

    /**
     * \Doctrine\ORM\Mapping\Column(type="string")
     */
    protected string $label;

    /**
     * \Doctrine\ORM\Mapping\Column(type="string")
     */
    protected string $slug;

    /** 
     * \Doctrine\ORM\Mapping\OneToMany(targetEntity="\App\Entity\Typed\ShelfSpecific", mappedBy="type")
     */
    protected $shelfSpecifics;

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
    public function getLabel():string
    {
        return $this->label;
    }

    /**
     * @param string $label
     */
    public function setLabel(string $label):void
    {
        $this->label = $label;
    }

    /**
     * @return string
     */
    public function getSlug():string
    {
        return $this->slug;
    }

    /**
     * @param string $slug
     */
    public function setSlug(string $slug):void
    {
        $this->slug = $slug;
    }

    /**
     * @return mixed
     */
    public function getShelfSpecifics()
    {
        return $this->shelfSpecifics;
    }

    /**
     * @param ShelfSpecific $shelfSpecifics
     */
    public function setShelfSpecifics(ShelfSpecific $shelfSpecifics):void
    {
        $this->shelfSpecifics = $shelfSpecifics;
    }
    
    
}