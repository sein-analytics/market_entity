<?php
namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="AclRole")
 */
class AclRole
{
    const SELLER = 'Seller';
    const BUYER = 'Buyer';
    const BOTH  = 'Both';

    const BUYER_TEAM = 'BuyerTeam';
    const SELLER_TEAM = 'SellerTeam';

    const ADMIN ='Admin';

    protected static $userAclRoles = [
        self::ADMIN => 0,
        self::BUYER => 1,
        self::SELLER => 2,
        self::BOTH => 3,
        self::BUYER_TEAM => 4,
        self::SELLER_TEAM => 5
    ];

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     **/
    protected $id;

    /**
     * @ORM\OneToMany(targetEntity = "\App\Entity\MarketUser", mappedBy="role")
     * @var ArrayCollection
     */
    protected $users;

    /** @ORM\Column(type="string", nullable=false)   */
    protected $role;

    public function __construct()
    {
        $this->role = self::$userAclRoles[self::BUYER];
        $this->users = new ArrayCollection();
    }
    
}