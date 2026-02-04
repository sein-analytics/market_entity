<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 */

namespace App\Entity\Data;

use \App\Entity\Loan;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'Cbsa')]
#[ORM\Entity]
class Cbsa
{
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    protected int $id;

    #[ORM\Column(type: 'integer', nullable: false)]
    protected int $cbsaCode;

    #[ORM\Column(type: 'string', nullable: false)]
    protected string $cbsaTitle;

    /**
     * @var ArrayCollection
     **/
    #[ORM\OneToMany(targetEntity: Loan::class, mappedBy: 'msaCode')]
    protected $loans;

}