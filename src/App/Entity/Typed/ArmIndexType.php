<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 * Date: 11/5/17
 * Time: 11:07 AM
 */

namespace App\Entity\Typed;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="\App\Repository\Typed\MappedType")
 * @ORM\Table(name="ArmIndexType")
 */
class ArmIndexType extends MappedTypeAbstract
{
    /**
     * @ORM\OneToMany(targetEntity="\App\Entity\MappedUserType", mappedBy="armIndex")
     */
    protected $mappedUserType;

    public function __construct()
    {
        parent::__construct();
    }

}