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
     * @ORM\Id 
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     **/
    protected int $id;

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
    protected string $abbreviation;

    /**
     * @ORM\Column(type="string", nullable=false)
     * @var string
     **/
    protected string $name;

    public function __construct()
    {
        $this->users = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId():int
    {
        return $this->id;
    }

    /**
     * @return ArrayCollection
     */
    public function getUsers():ArrayCollection
    {
        return $this->users;
    }

    /**
     * @param MarketUser $user
     */
    public function addUser(MarketUser $user):void
    {
        $this->users->add($user);
    }

    /**
     * @return string
     */
    public function getAbbreviation():string
    {
        return $this->abbreviation;
    }

    /**
     * @param string $abbreviation
     */
    public function setAbbreviation(string $abbreviation):void
    {
        $this->abbreviation = $abbreviation;
    }

    /**
     * @return string
     */
    public function getName():string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name):void
    {
        $this->name = $name;
    }

}