<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 */

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\PersistentCollection;

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
    protected int $id;

    /**
     * @ORM\Column(type="string", nullable=false)
     * @var string
     */
    protected string $status='';

    /**
     * @ORM\OneToMany(targetEntity = "\App\Entity\MarketUser", mappedBy="status")
     * @var PersistentCollection|ArrayCollection|null
     */
    protected $users;

    /**
     * @return int
     */
    public function getId():int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getStatus():string
    {
        return $this->status;
    }

    /**
     * @param string $status
     */
    public function setStatus(string $status)
    {
        $this->status = $status;
    }

    /**
     * @return PersistentCollection|ArrayCollection|null
     */
    public function getUsers():PersistentCollection|ArrayCollection|null
    {
        return $this->users;
    }

    /**
     * @param ArrayCollection $users
     */
    public function setUsers(ArrayCollection $users)
    {
        $this->users = $users;
    }


}