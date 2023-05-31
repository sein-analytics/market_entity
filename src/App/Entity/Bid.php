<?php

namespace App\Entity;
use App\Service\CreatePropertiesArrayTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Illuminate\Support\Facades\App;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity (repositoryClass="\App\Repository\Bid")
 * @ORM\Table (name="Bid")
 * @ORM\ChangeTrackingPolicy("NOTIFY")
 */
class Bid extends DomainObject
{
    use CreatePropertiesArrayTrait;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected int $id;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\MarketUser", inversedBy="bids")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false)
     * @var MarketUser
     */
    protected $user;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\Deal", inversedBy="bids")
     * @ORM\JoinColumn(name="deal_id", referencedColumnName="id", nullable=false)
     * @var Deal
     */
    protected $deal;

    /**
     * @ORM\ManyToMany(targetEntity="\App\Entity\Loan", inversedBy="bids")
     * @var ArrayCollection
     */
    protected $loans;

    /**
     * @ORM\Column(type="decimal", precision=9, scale=3, nullable=false)
     */
    protected float $price = 0.0;

    /**
     * @ORM\Column(type="decimal", precision=14, scale=2, nullable=false)
     */
    protected $effectiveBalance = 0.0;

    /**
     * @ORM\Column(type="decimal", precision=14, scale=2, nullable=true)
     */
    protected float $proportionalBalance = 0.0;

    /**
     * @ORM\Column(type="json", nullable=true)
     * @var array
     **/
    protected $bidHistory;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\BidStatus", inversedBy="bids")
     * @ORM\JoinColumn(name="status_id", referencedColumnName="id", nullable=false)
     * @var BidStatus
     */
    protected $status;

    /**
     * @ORM\Column(type="datetime", nullable=false)
     * @var \DateTime
     **/
    protected $date;

    /**
     * One Bid should have one DueDiligence entity that references the user who placed the bid.
     * @ORM\OneToOne(targetEntity="\App\Entity\DueDiligence", mappedBy="bid")
     * @var DueDiligence|null
     */
    protected $dueDiligence;

    /**
     * @return int
     */
    public function getId():int
    {
        return $this->id;
    }


    /**
     * @return MarketUser
     */
    public function getUser() : MarketUser
    {
        return $this->user;
    }

    /**
     *
     * @param MarketUser $user
     */
    public function setUser(MarketUser $user)
    {
        $this->user = $user;
    }

    /**
     * @return Deal
     */
    public function getDeal():Deal
    {
        return $this->deal;
    }

    /**
     * @param Deal $deal
     */
    public function setDeal(Deal $deal):void
    {
        $this->implementChange($this, 'deal', $this->deal, $deal);
    }

    /**
     * @return float
     */
    public function getPrice():float
    {
        return $this->price;
    }

    /**
     * @param float $price
     */
    public function setPrice(float $price):void
    {
        $this->updateBidHistory($price);
        $this->price = $price;
    }

    protected function updateBidHistory($price):void
    {
        if(!isset($this->bidHistory)){
            $hist = array(
                date("F j, Y, g:i a") => $price,
            );
        }else{
            $hist = $this->getBidHistory();
            $hist[date("F j, Y, g:i a")] = $price;
        }
        $this->bidHistory = $hist;
    }

    /**
     * @return float
     */
    public function getEffectiveBalance():float
    {
        return $this->effectiveBalance;
    }

    /**
     * @param float $effectiveBalance
     */
    public function setEffectiveBalance(float $effectiveBalance):void
    {
        $this->implementChange($this, 'effectiveBalance', $this->effectiveBalance, $effectiveBalance);
    }

    /**
     * @return float
     */
    public function getProportionalBalance(): float
    {
        return $this->proportionalBalance;
    }

    /**
     * @param float $proportionalBalance
     */
    public function setProportionalBalance(float $proportionalBalance):void
    {
        $this->implementChange($this, 'proportionalBalance', $this->proportionalBalance, $proportionalBalance);
    }

    /**
     * @return array
     */
    public function getBidHistory():?array
    {
        return $this->bidHistory;
    }

    /**
     * @return ArrayCollection
     */
    public function getLoan():ArrayCollection
    {
        return $this->loans;
    }

    /**
     * @param ArrayCollection $loans
     */
    public function setLoans(ArrayCollection $loans)
    {
        $this->implementChange($this, 'loan', $this->loans, $loans);
    }

    /**
     * @return BidStatus
     */
    public function getStatus() : BidStatus
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus(BidStatus $status)
    {
        $this->implementChange($this, 'status', $this->status, $status);
    }

    /**
     * @return \DateTime
     */
    public function getDate() : \DateTime
    {
        return $this->date;
    }

    /**
     * @param \DateTime $date
     */
    public function setDate(\DateTime $date)
    {
        $this->implementChange($this, 'date', $this->date, $date);
    }

    /**
     * @return DueDiligence|null
     */
    public function getDueDiligence():DueDiligence|null { return $this->dueDiligence; }

    /**
     * @param DueDiligence $dueDiligence
     */
    public function setDueDiligence(DueDiligence $dueDiligence) { $this->dueDiligence = $dueDiligence; }

}