<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 */

namespace App\Entity\Data;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="Cbsa")
 */
class Cbsa
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     **/
    protected int $id;

    /**
     * @ORM\Column(type="integer", nullable=false)  *
     */
    protected int $cbsaCode;

    /**
     * @ORM\Column(type="string", nullable=false)  *
     */
    protected string $cbsaTitle;

    /**
     * @ORM\OneToMany(targetEntity="\App\Entity\Loan", mappedBy="msaCode")
     * @var ArrayCollection
     **/
    protected $loans;

}