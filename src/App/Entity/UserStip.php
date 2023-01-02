<?php


namespace App\Entity;

use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\OneToOne;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\ManyToMany;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\JoinColumns;
use Doctrine\ORM\Mapping\JoinTable;
use Doctrine\ORM\Mapping\GeneratedValue;

use Doctrine\ORM\Mapping\DiscriminatorColumn;
use Doctrine\ORM\Mapping\DiscriminatorMap;

use Doctrine\ORM\Mapping\Index;
use Doctrine\ORM\Mapping\ChangeTrackingPolicy;

use Doctrine\ORM\Mapping\HasLifecycleCallbacks;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * \Doctrine\ORM\Mapping\Entity(repositoryClass="\App\Repository\UserStip")
 * \Doctrine\ORM\Mapping\Table(name="UserStip")
 * \Doctrine\ORM\Mapping\ChangeTrackingPolicy("NOTIFY")
 * \Doctrine\ORM\Mapping\HasLifeCycleCallbacks
 */
class UserStip extends DomainObject
{

    /**
     * \Doctrine\ORM\Mapping\Id
     * \Doctrine\ORM\Mapping\Column(type="integer")
     * \Doctrine\ORM\Mapping\GeneratedValue
     * @var int
     **/
    protected int $id;

    /**
     * \Doctrine\ORM\Mapping\ManyToOne(targetEntity="\App\Entity\MarketUser", inversedBy="stips")
     * \Doctrine\ORM\Mapping\JoinColumn(name="user_id", referencedColumnName="id", nullable=false)
     * @var MarketUser
     **/
    protected $user;

    /**
     * \Doctrine\ORM\Mapping\ManyToOne(targetEntity="\App\Entity\Deal", inversedBy="stips")
     * \Doctrine\ORM\Mapping\JoinColumn(name="deal_id", referencedColumnName="id", nullable=false)
     * @var Deal
     **/
    protected $deal;

    /**
     * \Doctrine\ORM\Mapping\Column(type="json", nullable=false)
     * @var array|string
     **/
    protected array|string $stips = [];

    /**
     * \Doctrine\ORM\Mapping\Column(type="string")
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