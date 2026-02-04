<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 * Date: 11/5/17
 * Time: 11:07 AM
 */

namespace App\Entity\Typed;

use \App\Repository\Typed\MappedType;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'ArmIndexType')]
#[ORM\Entity(repositoryClass: MappedType::class)]
class ArmIndexType extends MappedTypeAbstract
{
    protected $mappedUserType;

    public function __construct()
    {
        parent::__construct();
    }

}