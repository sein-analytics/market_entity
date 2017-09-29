<?php

namespace App\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\NotifyPropertyChanged;
use Doctrine\ORM\Mapping\ChangeTrackingPolicy;
use Doctrine\ORM\Mapping as ORM;
use Illuminate\Support\Facades\App;

/**
 * @ORM\Entity
 * @ORM\Table(name="Bid")
 * @ChangeTrackingPolicy("NOTIFY")
 */
class Bid implements NotifyPropertyChanged
{
    use NotifyChangeTrait;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\MarketUser", inversedBy="bids")
     * @ORM\JoinColumn(name="user_id", referenceColumn="id", nullable=false)
     * @var \App\Entity\MarketUser
     */
    protected $user;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\Deal", inversedBy="bids")
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

    /** @ORM\Column(type="string", nullable=true) **/
    protected $bidHistory;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\BidStatus", inversedBy="bids")
     * @var \App\Entity\BidStatus
     */
    protected $status;

    /** @ORM\Column(type="datetime", nullable=false)
     * @var \DateTime
     **/
    protected $date;

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
    public function getUser()
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
     * @return mixed
     */
    public function getDeal()
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
     * @return mixed
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param mixed $price
     */
    public function setPrice($price)
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
            $hist = @unserialize($this->bidHistory);
            $hist[date("F j, Y, g:i a")] = $price;
        }
        $hist = @serialize($hist);
        $this->bidHistory = $hist;
    }

    /**
     * @return mixed
     */
    public function getEffectiveBalance()
    {
        return $this->effectiveBalance;
    }

    /**
     * @param mixed $effectiveBalance
     */
    public function setEffectiveBalance($effectiveBalance)
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
     * @return mixed
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
     * @return mixed
     */
    public function getStatus()
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
    public function getDate()
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


}