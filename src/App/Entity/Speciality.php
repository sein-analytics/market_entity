<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 */

namespace App\Entity;

use App\Entity\MarketUser;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\PersistentCollection;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="Speciality")
 */
class Speciality 
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     **/
    protected int $id;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\MarketUser", inversedBy="specialities")
     * @var PersistentCollection|ArrayCollection|null
     **/
    protected $users;

    /**
     * @ORM\Column(type="string", nullable=false)
     * @var string
     **/
    protected string $speciality;

    /**
     * @ORM\Column(type="string", nullable=false, unique=true)
     * @var string
     **/
    protected string $uuid;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return ArrayCollection|PersistentCollection|null
     */
    public function getUsers(): ArrayCollection|PersistentCollection|null
    {
        return $this->users;
    }

    /**
     * @return string
     */
    public function getSpeciality(): string
    {
        return $this->speciality;
    }

    /**
     * @return string
     */
    public function getUuid(): string
    {
        return $this->uuid;
    }


}