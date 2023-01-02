<?php
namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
//use Doctrine\ORM\Mapping as ORM;

/**
 * \Doctrine\ORM\Mapping\Entity(repositoryClass="\App\Repository\AclRole")
 * \Doctrine\ORM\Mapping\Table(name="AclRole")
 */
class AclRole extends AnnotationMappings
{
    const SELLER = 'Seller';
    const BUYER = 'Buyer';
    const BOTH  = 'Both';

    const BUYER_TEAM = 'BuyerTeam';
    const SELLER_TEAM = 'SellerTeam';

    const ADMIN ='Admin';

    protected static array $userAclRoles = [
        self::ADMIN => 0,
        self::BUYER => 1,
        self::SELLER => 2,
        self::BOTH => 3,
        self::BUYER_TEAM => 4,
        self::SELLER_TEAM => 5
    ];

    /**
     * \Doctrine\ORM\Mapping\Id
     * \Doctrine\ORM\Mapping\Column(type="integer")
     * \Doctrine\ORM\Mapping\GeneratedValue
     * @var int
     **/
    protected int $id;

    /**
     * \Doctrine\ORM\Mapping\OneToMany(targetEntity = "\App\Entity\MarketUser", mappedBy="role")
     * @var ArrayCollection
     */
    protected $users;

    /** \Doctrine\ORM\Mapping\Column(type="string", nullable=false)
     * @var string
     */
    protected string $role = '';

    public function __construct()
    {
        $this->users = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getId() :int { return $this->id; }

    /**
     * @return mixed
     */
    public function getRole() : string { return $this->role; }

}