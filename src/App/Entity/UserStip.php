<?php


namespace App\Entity;
use Doctrine\ORM\Mapping\ChangeTrackingPolicy;

use Doctrine\ORM\Mapping\HasLifecycleCallbacks as HasLifecycleCallbacks;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="\App\Repository\UserStip")
 * @ORM\Table(name="UserStip")
 * @ORM\ChangeTrackingPolicy("NOTIFY")
 * @HasLifecycleCallbacks
 */
class UserStip extends DomainObject
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     * @var int
     **/
    protected int $id;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\MarketUser", inversedBy="stips")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false)
     * @var MarketUser
     **/
    protected $user;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\Deal", inversedBy="stips")
     * @ORM\JoinColumn(name="deal_id", referencedColumnName="id", nullable=false)
     * @var Deal
     **/
    protected $deal;

    /**
     * @ORM\Column(type="json", nullable=false)
     * @var array|string
     **/
    protected array|string $stips = [];

    /**
     * @ORM\Column(type="string")
     * @var string
     */
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