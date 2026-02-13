<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 * Date: 4/15/18
 * Time: 3:20 PM
 */

namespace App\Entity\Typed;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'NewUsed')]
#[ORM\Entity]
class NewUsed extends MappedTypeAbstract
{

}