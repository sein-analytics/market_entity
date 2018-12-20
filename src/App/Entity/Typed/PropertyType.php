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
 * @ORM\Table(name="PropertyType")
 */
class PropertyType extends MappedTypeAbstract
{
    protected $mappedUserType;

    function __construct()
    {
        parent::__construct();
    }

    /** @ORM\Column(type="string", nullable=false)  */
    protected $typeMain  = '';

    /**
     * @return string
     */
    public function getTypeMain() { return $this->typeMain; }


}