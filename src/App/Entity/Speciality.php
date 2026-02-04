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

#[ORM\Table(name: 'Speciality')]
#[ORM\Entity]
class Speciality 
{
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    protected int $id;

    /**
     * @var PersistentCollection|ArrayCollection|null
     **/
    #[ORM\ManyToMany(targetEntity: MarketUser::class, inversedBy: 'specialities')]
    protected $users;

    /**
     * @var string
     **/
    #[ORM\Column(type: 'string', nullable: false)]
    protected string $speciality;

    /**
     * @var string
     **/
    #[ORM\Column(type: 'string', nullable: false, unique: true)]
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