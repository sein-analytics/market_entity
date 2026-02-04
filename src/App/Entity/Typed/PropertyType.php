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

#[ORM\Table(name: 'PropertyType')]
#[ORM\Entity(repositoryClass: MappedType::class)]
class PropertyType extends MappedTypeAbstract
{
    protected $mappedUserType;

    function __construct()
    {
        parent::__construct();
    }

    #[ORM\Column(type: 'string', nullable: false)]
    protected $typeMain  = '';

    /**
     * @return string
     */
    public function getTypeMain() { return $this->typeMain; }


}