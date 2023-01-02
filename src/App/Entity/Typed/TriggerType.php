<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 * Date: 6/27/16
 * Time: 4:48 PM
 */

namespace App\Entity\Typed;

use Doctrine\ORM\Mapping as ORM;

/**
 * @author Samuel Belu-John
 * @ORM\Entity
 * @ORM\Table(name="TriggerType")
 */
class TriggerType
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
     * @ORM\OneToMany(targetEntity="\App\Entity\Typed\Triggers", mappedBy="type") */
    protected $triggers;
}