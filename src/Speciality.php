<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 */

namespace App\Entity;

use App\Entity\MarketUser;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="Speciality")
 */
class Speciality
{
    /**
     * @ORM\Id @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     **/
    protected $id;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\MarketUser", inversedBy="specialities")
     * @var ArrayCollection
     **/
    protected $users;

    /**
     * @ORM\Column(type="string", nullable=false)
     * @var string
     **/
    protected $speciality;
}