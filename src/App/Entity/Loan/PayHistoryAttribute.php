<?php

namespace App\Entity\Loan;

use App\Entity\DomainObject;
use App\Entity\Loan;
use App\Service\CreatePropertiesArrayTrait;
use Doctrine\ORM\Mapping\ChangeTrackingPolicy;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="\App\Repository\Loan\PayHistoryAttribute")
 * @ORM\Table(name="PayHistoryAttribute")
 * @ORM\ChangeTrackingPolicy("NOTIFY")
 */
class PayHistoryAttribute extends DomainObject
{
    use CreatePropertiesArrayTrait;

    /**
     * @ORM\Id
     * @ORM\Column (type="integer")
     * @ORM\GeneratedValue
     * @var int
     */
    protected int $id;

    /**
     * @ORM\OneToOne(targetEntity="\App\Entity\Loan", inversedBy="payHistoryAttribute")
     * @var Loan
     */
    protected $loan;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var ?string
     */
    protected ?string $history1;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var ?string
     */
    protected ?string $history2;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var ?string
     */
    protected ?string $history3;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var ?string
     */
    protected ?string $history4;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var ?string
     */
    protected ?string $history5;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var ?string
     */
    protected ?string $history6;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var ?string
     */
    protected ?string $history7;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var ?string
     */
    protected ?string $history8;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var ?string
     */
    protected ?string $history9;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var ?string
     */
    protected ?string $history10;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var ?string
     */
    protected ?string $history11;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var ?string
     */
    protected ?string $history12;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return Loan
     */
    public function getLoan(): Loan
    {
        return $this->loan;
    }

    /**
     * @param Loan $loan
     * @return void
     */
    public function setLoan(Loan $loan): void
    {
        $this->loan = $loan;
    }

    /**
     * @return string|null
     */
    public function getHistory1(): ?string
    {
        return $this->history1;
    }

    /**
     * @param string|null $history1
     * @return void
     */
    public function setHistory1(?string $history1): void
    {
        $this->history1 = $history1;
    }

    /**
     * @return string|null
     */
    public function getHistory2(): ?string
    {
        return $this->history2;
    }

    /**
     * @param string|null $history2
     * @return void
     */
    public function setHistory2(?string $history2): void
    {
        $this->history2 = $history2;
    }

    /**
     * @return string|null
     */
    public function getHistory3(): ?string
    {
        return $this->history3;
    }

    /**
     * @param string|null $history3
     * @return void
     */
    public function setHistory3(?string $history3): void
    {
        $this->history3 = $history3;
    }

    /**
     * @return string|null
     */
    public function getHistory4(): ?string
    {
        return $this->history4;
    }

    /**
     * @param string|null $history4
     * @return void
     */
    public function setHistory4(?string $history4): void
    {
        $this->history4 = $history4;
    }

    /**
     * @return string|null
     */
    public function getHistory5(): ?string
    {
        return $this->history5;
    }

    /**
     * @param string|null $history5
     * @return void
     */
    public function setHistory5(?string $history5): void
    {
        $this->history5 = $history5;
    }

    /**
     * @return string|null
     */
    public function getHistory6(): ?string
    {
        return $this->history6;
    }

    /**
     * @param string|null $history6
     * @return void
     */
    public function setHistory6(?string $history6): void
    {
        $this->history6 = $history6;
    }

    /**
     * @return string|null
     */
    public function getHistory7(): ?string
    {
        return $this->history7;
    }

    /**
     * @param string|null $history7
     * @return void
     */
    public function setHistory7(?string $history7): void
    {
        $this->history7 = $history7;
    }

    /**
     * @return string|null
     */
    public function getHistory8(): ?string
    {
        return $this->history8;
    }

    /**
     * @param string|null $history8
     * @return void
     */
    public function setHistory8(?string $history8): void
    {
        $this->history8 = $history8;
    }

    /**
     * @return string|null
     */
    public function getHistory9(): ?string
    {
        return $this->history9;
    }

    /**
     * @param string|null $history9
     * @return void
     */
    public function setHistory9(?string $history9): void
    {
        $this->history9 = $history9;
    }

    /**
     * @return string|null
     */
    public function getHistory10(): ?string
    {
        return $this->history10;
    }

    /**
     * @param string|null $history10
     * @return void
     */
    public function setHistory10(?string $history10): void
    {
        $this->history10 = $history10;
    }

    /**
     * @return string|null
     */
    public function getHistory11(): ?string
    {
        return $this->history11;
    }

    /**
     * @param string|null $history11
     * @return void
     */
    public function setHistory11(?string $history11): void
    {
        $this->history11 = $history11;
    }

    /**
     * @return string|null
     */
    public function getHistory12(): ?string
    {
        return $this->history12;
    }

    /**
     * @param string|null $history12
     * @return void
     */
    public function setHistory12(?string $history12): void
    {
        $this->history12 = $history12;
    }

}