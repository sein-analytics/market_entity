<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 * Date: 7/28/16
 * Time: 8:06 AM
 */

namespace App\Entity\Data;
use App\Entity\MarketUser;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="\App\Repository\Data\State")
 * @ORM\Table(name="State")
 */
class State
{
    /**
     * @ORM\Id @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     **/
    protected $id;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\MarketUser", mappedBy="state")
     * @var ArrayCollection
     **/
    protected $users;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Loan", mappedBy="state")
     * @var ArrayCollection
     */
    protected $loans;

    /**
     * @ORM\Column(type="string", nullable=false)
     * @var string
     **/
    protected $abbreviation;

    /**
     * @ORM\Column(type="string", nullable=false)
     * @var string
     **/
    protected $name;

    public function __construct()
    {
        $this->users = new ArrayCollection();
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

    /**
     * @param MarketUser $user
     */
    public function addUser(MarketUser $user)
    {
        $this->users->add($user);
    }

    /**
     * @return string
     */
    public function getAbbreviation()
    {
        return $this->abbreviation;
    }

    /**
     * @param string $abbreviation
     */
    public function setAbbreviation($abbreviation)
    {
        $this->abbreviation = $abbreviation;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

}