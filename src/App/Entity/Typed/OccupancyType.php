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
 * @ORM\Table(name="OccupancyType")
 */
class OccupancyType extends MappedTypeAbstract
{
    protected $mappedUserType;

    public function __construct()
    {
        parent::__construct();
    }
}