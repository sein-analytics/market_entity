<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 * Date: 11/5/17
 * Time: 11:07 AM
 */

namespace App\Entity\Typed;

//use Doctrine\ORM\Mapping as ORM;

/**
 * \Doctrine\ORM\Mapping\Entity(repositoryClass="\App\Repository\Typed\MappedType")
 * \Doctrine\ORM\Mapping\Table(name="ArmIndexType")
 */
class ArmIndexType extends MappedTypeAbstract
{
    protected $mappedUserType;

    public function __construct()
    {
        parent::__construct();
    }

}