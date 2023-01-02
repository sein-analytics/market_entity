<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 * Date: 6/27/16
 * Time: 4:48 PM
 */

namespace App\Entity\Typed;

//use Doctrine\ORM\Mapping as ORM;
use App\Entity\AnnotationMappings;

/**
 * @author Samuel Belu-John
 * \Doctrine\ORM\Mapping\Entity
 * \Doctrine\ORM\Mapping\Table(name="TriggerType")
 */
class TriggerType extends AnnotationMappings
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
     * \Doctrine\ORM\Mapping\OneToMany(targetEntity="\App\Entity\Typed\Triggers", mappedBy="type") */
    protected $triggers;
}