<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="\App\Repository\MortgagePaymentCode")
 * @ORM\Table(name="MortgagePaymentCode")
 * @ORM\ChangeTrackingPolicy("NOTIFY")
 */
class MortgagePaymentCode
{
    /**
     * @ORM\Id
     * @ORM\Column (type="integer")
     * @ORM\GeneratedValue
     * @var int
     */
    protected int $id;

    /**
     * @ORM\Column(type="string", nullable=false)
     * @var string
     */
    protected string $code;

    /**
     * @ORM\Column(type="string", nullable=false)
     * @var string
     */
    protected string $slugs;

    public function getId(): int
    {
        return $this->id;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function getSlugs(): string
    {
        return $this->slugs;
    }


}