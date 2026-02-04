<?php
namespace App\Entity;

use \App\Entity\MarketUser;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'AclRole')]
#[ORM\Entity(repositoryClass: \App\Repository\AclRole::class)]
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
     * @var int
     **/
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    protected int $id;

    /**
     * @var ArrayCollection
     */
    #[ORM\OneToMany(targetEntity: MarketUser::class, mappedBy: 'role')]
    protected $users;

    /**
     * @var string
     */
    #[ORM\Column(type: 'string', nullable: false)]
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