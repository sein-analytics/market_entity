<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 * Date: 4/9/18
 * Time: 5:53 PM
 */

namespace App\Entity;

/**
 * @ORM\Entity
 * @ORM\Table(name="LienType")
 */
class LienType
{
    /**
     * @ORM\Id @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     **/
    protected $id;

    /** @ORM\Column(type="integer", nullable=false) **/
    protected $label;

    /** @ORM\Column(type="string", nullable=false) **/
    protected $slug;

    /**
     * @return mixed
     */
    public function getId() { return $this->id; }

    /**
     * @return mixed
     */
    public function getLabel() { return $this->label; }

    /**
     * @return mixed
     */
    public function getSlug(){ return $this->slug; }


}