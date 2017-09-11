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
 *
 * @ORM\Entity
 * @ORM\Table(name="ShelfSpecificType")
 */
class ShelfSpecificType
{
    /** @ORM\Id @ORM\Column(type="integer") @ORM\GeneratedValue */
    protected $id;

    /** @ORM\Column(type="string") */
    protected $label;

    /** @ORM\Column(type="string") */
    protected $slug;

    /** 
     * @ORM\OneToMany(targetEntity="\App\Entity\Typed\ShelfSpecific", mappedBy="type") */
    protected $shelfSpecifics;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * @param mixed $label
     */
    public function setLabel($label)
    {
        $this->label = $label;
    }

    /**
     * @return mixed
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @param mixed $slug
     */
    public function setSlug($slug)
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
     * @param mixed $shelfSpecifics
     */
    public function setShelfSpecifics($shelfSpecifics)
    {
        $this->shelfSpecifics = $shelfSpecifics;
    }
    
    
}