<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 * Date: 11/5/17
 * Time: 11:04 AM
 */

namespace App\Entity\Typed;

use App\Entity\MappedUserType;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="PurposeType")
 */
class PurposeType extends MappedTypeAbstract
{
    /**
     * @ORM\OneToMany(targetEntity="\App\Entity\MappedUserType", mappedBy="purposeType")
     * @var  ArrayCollection
     * */
    protected $mappedUserType;

    public function __construct()
    {
        parent::__construct();
    }

}