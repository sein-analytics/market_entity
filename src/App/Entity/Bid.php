<?php

namespace App\Entity;
use App\Service\CreatePropertiesArrayTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\NotifyPropertyChanged;
use Doctrine\ORM\Mapping\ChangeTrackingPolicy;
use Doctrine\ORM\Mapping as ORM;
use Illuminate\Support\Facades\App;

/**
 * @ORM\Entity(repositoryClass="\App\Repository\Bid")
 * @ORM\Table(name="Bid")
 * @ChangeTrackingPolicy("NOTIFY")
 */
class Bid implements NotifyPropertyChanged
{
    use NotifyChangeTrait, CreatePropertiesArrayTrait;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\MarketUser", inversedBy="bids")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false)
     * @var \App\Entity\MarketUser
     */
    protected $user;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\Deal", inversedBy="bids")
     * @ORM\JoinColumn(name="deal_id", referencedColumnName="id", nullable=false)
     * @var \App\Entity\Deal
     */
    protected $deal;

    /**
     * @ORM\ManyToMany(targetEntity="\App\Entity\Loan", inversedBy="bids")
     * @var ArrayCollection
     */
    protected $loans;

    /** @ORM\Column(type="decimal", precision=9, scale=3, nullable=false) */
    protected $price = 0.0;

    /** @ORM\Column(type="decimal", precision=14, scale=2, nullable=false) */
    protected $effectiveBalance = 0.0;

    /** @ORM\Column(type="decimal", precision=14, scale=2, nullable=true) */
    protected $proportionalBalance = 0.0;

    /** @ORM\Column(type="json", nullable=true)
     * @var array
     **/
    protected $bidHistory;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\BidStatus", inversedBy="bids")
     * @ORM\JoinColumn(name="status_id", referencedColumnName="id", nullable=false)
     * @var \App\Entity\BidStatus
     */
    protected $status;

    /** @ORM\Column(type="datetime", nullable=false)
     * @var \DateTime
     **/
    protected $date;

    /**
     * One Bid should have one DueDiligence entity that references the user who placed the bid.
     * @OneToOne(targetEntity="\App\Entity\DueDiligence", mappedBy="bid")
     * @var \App\Entity\DueDiligence|null
     */
    protected $dueDiligence;

    /**
     * @return mixed
     */
    public function getId()
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
    public function getDeal() : Deal
    {
        return $this->deal;
    }

    /**
     * @param Deal $deal
     */
    public function setDeal(Deal $deal)
    {
        $this->_onPropertyChanged('deal', $this->deal, $deal);
        $this->deal = $deal;
    }

    /**
     * @return float
     */
    public function getPrice() : float
    {
        return $this->price;
    }

    /**
     * @param float $price
     */
    public function setPrice(float $price)
    {
        $this->updateBidHistory($price);
        $this->price = $price;
    }

    protected function updateBidHistory($price)
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
    public function getEffectiveBalance() : float
    {
        return $this->effectiveBalance;
    }

    /**
     * @param mixed $effectiveBalance
     */
    public function setEffectiveBalance(float $effectiveBalance)
    {
        $this->_onPropertyChanged('effectiveBalance', $this->effectiveBalance, $effectiveBalance);
        $this->effectiveBalance = $effectiveBalance;
    }

    /**
     * @return mixed
     */
    public function getProportionalBalance()
    {
        return $this->proportionalBalance;
    }

    /**
     * @param mixed $proportionalBalance
     */
    public function setProportionalBalance($proportionalBalance)
    {
        $this->_onPropertyChanged('proportionalBalance', $this->proportionalBalance, $proportionalBalance);
        $this->proportionalBalance = $proportionalBalance;
    }

    /**
     * @return array
     */
    public function getBidHistory()
    {
        return $this->bidHistory;
    }

    /**
     * @return ArrayCollection
     */
    public function getLoan()
    {
        return $this->loans;
    }

    /**
     * @param ArrayCollection $loans
     */
    public function setLoans(ArrayCollection $loans)
    {
        $this->_onPropertyChanged('loan', $this->loans, $loans);
        $this->loans = $loans;
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
        $this->_onPropertyChanged('status', $this->status, $status);
        $this->status = $status;
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
        $this->_onPropertyChanged('date', $this->date, $date);
        $this->date = $date;
    }

    /**
     * @return DueDiligence|null
     */
    public function getDueDiligence(): ?DueDiligence
    {
        return $this->dueDiligence;
    }
}