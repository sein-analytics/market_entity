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

#[ORM\Table(name: 'OccupancyType')]
#[ORM\Entity(repositoryClass: MappedType::class)]
class OccupancyType extends MappedTypeAbstract
{
    protected $mappedUserType;

    public function __construct()
    {
        parent::__construct();
    }
}