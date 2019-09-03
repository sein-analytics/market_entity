<?php


namespace App\Entity;

use Doctrine\Common\NotifyPropertyChanged;
use Doctrine\ORM\Mapping\ChangeTrackingPolicy;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass="\App\Repository\UserStip")
 * @ORM\Table(name="UserStip")
 * @ChangeTrackingPolicy("NOTIFY")
 * @ORM\HasLifeCycleCallbacks
 */
class UserStip implements NotifyPropertyChanged
{
    use NotifyChangeTrait;

    /**
     * @ORM\Id @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     * @var int
     **/
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\MarketUser", inversedBy="stips")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false)
     * @var \App\Entity\MarketUser
     **/
    protected $user;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\Deal", inversedBy="stips")
     * @ORM\JoinColumn(name="deal_id", referencedColumnName="id", nullable=false)
     * @var \App\Entity\Deal
     **/
    protected $deal;

    /**
     * @ORM\Column(type="json", nullable=false)
     * @var array
     **/
    protected $stips = [];

    /** @ORM\Column(type="string") **/
    protected $name = '';

    public function __construct()
    {
        $this->user = new MarketUser();
        $this->deal = new Deal();
    }

    public function setStips(array $stips)
    {
        $string = json_encode($stips);
        $this->_onPropertyChanged('stips', $this->stips, $string);
        $this->stips = $string;
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
    public function getId() { return $this->id; }

    /**
     * @return MarketUser
     */
    public function getUser(): MarketUser { return $this->user; }

    /**
     * @return Deal
     */
    public function getDeal(): Deal { return $this->deal; }

    /**
     * @return array
     */
    public function getStips(): array { return $this->stips; }

    function getName():string { return $this->name; }

}