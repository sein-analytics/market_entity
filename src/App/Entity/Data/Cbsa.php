<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 */

namespace App\Entity\Data;

use App\Entity\AnnotationMappings;
use Doctrine\Common\Collections\ArrayCollection;
//use Doctrine\ORM\Mapping as ORM;

/**
 * \Doctrine\ORM\Mapping\Entity
 * \Doctrine\ORM\Mapping\Table(name="Cbsa")
 */
class Cbsa extends AnnotationMappings
{
    /**
     * \Doctrine\ORM\Mapping\Id @ORM\Column(type="integer")
     * \Doctrine\ORM\Mapping\GeneratedValue
     **/
    protected int $id;

    /**
     * Doctrine\ORM\Mapping\Column(type="integer", nullable=false)  *
     */
    protected int $cbsaCode;

    /**
     * \Doctrine\ORM\Mapping\Column(type="string", nullable=false)  *
     */
    protected string $cbsaTitle;

    /**
     * \Doctrine\ORM\Mapping\OneToMany(targetEntity="\App\Entity\Loan", mappedBy="msaCode")
     * @var ArrayCollection
     **/
    protected $loans;

}