<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 * Date: 11/5/17
 * Time: 11:04 AM
 */

namespace App\Entity\Typed;

//use Doctrine\ORM\Mapping as ORM;

/**
 * \Doctrine\ORM\Mapping\Entity(repositoryClass="\App\Repository\Typed\MappedType")
 * \Doctrine\ORM\Mapping\Table(name="LoanType")
 */
class LoanType extends MappedTypeAbstract
{
    protected $mappedUserType;

    function __construct()
    {
        parent::__construct();
    }
}