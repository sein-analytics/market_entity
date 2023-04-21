<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 * Date: 6/27/16
 * Time: 4:18 PM
 */

namespace App\Entity\Typed;

use Doctrine\ORM\Mapping as ORM;
/**
 * @author Samuel Belu-John
 * @ORM\Entity
 * @ORM\Table(name="ShelfSpecificType")
 */
class ShelfSpecificType
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    protected int $id;

    /**
     * @ORM\Column(type="string")
     */
    protected string $label;

    /**
     * @ORM\Column(type="string")
     */
    protected string $slug;

    /** 
     * @ORM\OneToMany(targetEntity="\App\Entity\Typed\ShelfSpecific", mappedBy="type")
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