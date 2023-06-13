<?php

namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity(repositoryClass="\App\Repository\KickOutsLoan")
 * @ORM\Table(name="KickOutLoan")
 */
class KickOutsLoan
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     * @var int
     **/
    protected int $id;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\Bid", inversedBy="carveOuts")
     * @ORM\JoinColumn(name="bidId", referencedColumnName="id", nullable=false)
     * @var Bid
     */
    protected $bid;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\Loan")
     * @ORM\JoinColumn(name="loanId", referencedColumnName="id", nullable=false)
     * @var Loan
     */
    protected $loan;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\Pool")
     * @ORM\JoinColumn(name="poolId", referencedColumnName="id", nullable=false)
     * @var Pool
     */
    protected $pool;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\deal")
     * @ORM\JoinColumn(name="dealId", referencedColumnName="id", nullable=false)
     * @var Deal
     */
    protected $deal;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    public function getBid():Bid {
        return $this->bid;
    }

    /**
     * @return Loan
     */
    public function getLoanId(): Loan
    {
        return $this->loan;
    }

    public function getPool():Pool {
        return $this->pool;
    }

    public function getDeal():Deal {
        return $this->deal;
    }

    /**
     * @param Bid $bid
     */
    public function setBid(Bid $bid): void
    {
        $this->bid = $bid;
    }

    public function setLoan(Loan $loan)
    {
        $this->loan = $loan;
    }

    /**
     * @param Pool $pool
     */
    public function setPool(Pool $pool): void
    {
        $this->pool = $pool;
    }

    /**
     * @param Deal $deal
     */
    public function setDeal(Deal $deal): void
    {
        $this->deal = $deal;
    }
}