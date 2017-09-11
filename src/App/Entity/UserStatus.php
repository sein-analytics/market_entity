<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 */

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="UserStatus")
 */
class UserStatus
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     **/
    protected $id;

    /** @ORM\Column(type="string", nullable=false)   */
    protected $status;

    /**
     * @ORM\OneToMany(targetEntity = "\App\Entity\MarketUser", mappedBy="status")
     * @var ArrayCollection
     */
    protected $users;
}