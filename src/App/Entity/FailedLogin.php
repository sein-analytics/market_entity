<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 */

namespace App\Entity;

use \App\Entity\MarketUser;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'FailedLogin')]
#[ORM\Entity(repositoryClass: \App\Repository\FailedLogin::class)]
class FailedLogin 
{
    /**
     * @var int
     **/
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    protected int $id;

    /**
     * @var int
     */
    #[ORM\Column(type: 'integer', nullable: false)]
    protected int $state = 0;

    /**
     * @var ArrayCollection
     */
    #[ORM\OneToMany(targetEntity: MarketUser::class, mappedBy: 'failedAttempts')]
    protected $users;

    public function __construct()
    {
        $this->users = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId():int { return $this->id; }

    /**
     * @return ArrayCollection
     */
    public function getUsers(): ArrayCollection
    {
        return $this->users;
    }


}