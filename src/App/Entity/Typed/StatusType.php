<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 * Date: 11/5/17
 * Time: 11:04 AM
 */

namespace App\Entity\Typed;

use \App\Repository\Typed\MappedType;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'StatusType')]
#[ORM\Entity(repositoryClass: MappedType::class)]
class StatusType extends MappedTypeAbstract
{
    protected $mappedUserType;

    function __construct()
    {
        parent::__construct();
    }
}