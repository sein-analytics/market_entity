<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 * Date: 11/5/17
 * Time: 11:04 AM
 */

namespace App\Entity\Typed;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="\App\Repository\Typed\MappedType")
 * @ORM\Table(name="LoanType")
 */
class LoanType extends MappedTypeAbstract
{
    /**
     * @ORM\OneToMany(targetEntity="\App\Entity\MappedUserType", mappedBy="loanType")
     */
    protected $mappedUserType;

    function __construct()
    {
        parent::__construct();
    }
}