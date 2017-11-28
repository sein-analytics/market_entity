<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 * Date: 6/28/16
 * Time: 3:06 PM
 */

namespace App\Entity;

use App\Service\CreatePropertiesArrayTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="Rating")
 */
class Rating
{
    use NotifyChangeTrait, CreatePropertiesArrayTrait;

    /**
     * @ORM\Id @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     **/
    protected $id;

    /** @ORM\Column(type="decimal", precision=5, scale=3, nullable=false) **/
    protected $rating;

    /** @ORM\ManyToMany(targetEntity="\App\Entity\MarketUser", inversedBy="ratings") **/
    protected $users;
    
    public function __construct()
    {
        $this->users = new ArrayCollection();
    }

    function addUser(MarketUser $user){
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
     * @return ArrayCollection
     */
    public function getUsers()
    {
        return $this->users;
    }



}