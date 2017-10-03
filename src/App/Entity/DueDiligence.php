<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 * Date: 10/2/17
 * Time: 5:31 PM
 */

namespace App\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="DueDiligence")
 */
class DueDiligence
{
    /**
     * @ORM\Id @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     **/
    protected $id;

    /**
     * @ORM\Column(type="string", nullable=false)
     * @var string
     */
    protected $role;

    /**
     * @ORM\OneToMany(targetEntity="\App\Entity\MarketUser", mappedBy="ddRole")
     * @var ArrayCollection
     */
    protected $users;

    function __construct()
    {
        $this->users = new ArrayCollection();
    }

    function addUser(MarketUser $user)
    {
        $this->users->add($user);
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * @return ArrayCollection
     */
    public function getUsers()
    {
        return $this->users;
    }


}