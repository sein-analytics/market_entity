<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 * Date: 4/9/18
 * Time: 5:53 PM
 */

namespace App\Entity\Typed;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="LienType")
 */
class LienType extends MappedTypeAbstract
{

    protected $mappedUserType;



}