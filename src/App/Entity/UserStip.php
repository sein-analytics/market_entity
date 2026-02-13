<?php


namespace App\Entity;
 

use Doctrine\ORM\Mapping\HasLifecycleCallbacks as HasLifecycleCallbacks;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'UserStip')]
#[ORM\Entity(repositoryClass: \App\Repository\UserStip::class)]
 
#[HasLifecycleCallbacks]
class UserStip extends DomainObject
{

    /**
     * @var int
     **/
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    protected int $id;

    /**
     * @var MarketUser
     **/
    #[ORM\JoinColumn(name: 'user_id', referencedColumnName: 'id', nullable: false)]
    #[ORM\ManyToOne(targetEntity:  MarketUser::class, inversedBy: 'stips')]
    protected $user;

    /**
     * @var Deal
     **/
    #[ORM\JoinColumn(name: 'deal_id', referencedColumnName: 'id', nullable: false)]
    #[ORM\ManyToOne(targetEntity:  Deal::class, inversedBy: 'stips')]
    protected $deal;

    /**
     * @var array|string
     **/
    #[ORM\Column(type: 'json', nullable: false)]
    protected array|string $stips = [];

    /**
     * @var string
     */
    #[ORM\Column(type: 'string')]
    protected string $name = '';

    public function __construct()
    {
        $this->user = new MarketUser();
        $this->deal = new Deal();
        parent::__construct();
    }

    public function setStips(array|string $stips)
    {
        if (is_array($stips))
            $string = json_encode($stips);
        else
            $string = $stips;
        $this->implementChange($this,'stips', $this->stips, $string);
    }

    /**
     * @param MarketUser $user
     */
    public function setUser(MarketUser $user) { $this->user = $user; }

    /**
     * @param Deal $deal
     */
    public function setDeal(Deal $deal) { $this->deal = $deal; }

    function setName(string $name) { $this->name = $name; }

    /**
     * @return int
     */
    public function getId():int { return $this->id; }

    /**
     * @return MarketUser
     */
    public function getUser(): MarketUser { return $this->user; }

    /**
     * @return Deal
     */
    public function getDeal(): Deal { return $this->deal; }

    /**
     * @return array|string
     */
    public function getStips(): array|string { return $this->stips; }

    function getName():string { return $this->name; }

}