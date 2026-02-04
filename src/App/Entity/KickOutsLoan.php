<?php

namespace App\Entity;
use \App\Entity\deal;
use Doctrine\ORM\Mapping as ORM;
#[ORM\Table(name: 'KickOutLoan')]
#[ORM\Entity(repositoryClass: \App\Repository\KickOutsLoan::class)]
class KickOutsLoan
{
    /**
     * @var int
     **/
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    protected int $id;

    /**
     * @var Bid
     */
    #[ORM\JoinColumn(name: 'bidId', referencedColumnName: 'id', nullable: false)]
    #[ORM\ManyToOne(targetEntity:  \App\Entity\Bid::class, inversedBy: 'carveOuts')]
    protected $bid;

    /**
     * @var Loan
     */
    #[ORM\JoinColumn(name: 'loanId', referencedColumnName: 'id', nullable: false)]
    #[ORM\ManyToOne(targetEntity:  \App\Entity\Loan::class)]
    protected $loan;

    /**
     * @var Pool
     */
    #[ORM\JoinColumn(name: 'poolId', referencedColumnName: 'id', nullable: false)]
    #[ORM\ManyToOne(targetEntity:  \App\Entity\Pool::class)]
    protected $pool;

    /**
     * @var Deal
     */
    #[ORM\JoinColumn(name: 'dealId', referencedColumnName: 'id', nullable: false)]
    #[ORM\ManyToOne(targetEntity: deal::class)]
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