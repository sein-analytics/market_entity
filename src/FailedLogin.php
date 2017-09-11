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
 * @ORM\Table(name="FailedLogin")
 */
class FailedLogin
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     **/
    protected $id;

    /** @ORM\Column(type="integer", nullable=false)   */
    protected $state;

    /**
     * @ORM\OneToMany(targetEntity = "\App\Entity\MarketUser", mappedBy="failedAttempts")
     * @var ArrayCollection
     */
    protected $users;
}