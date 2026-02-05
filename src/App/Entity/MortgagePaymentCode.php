<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'MortgagePaymentCode')]
#[ORM\Entity(repositoryClass: \App\Repository\MortgagePaymentCode::class)]
 
class MortgagePaymentCode
{
    /**
     * @var int
     */
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    protected int $id;

    /**
     * @var string
     */
    #[ORM\Column(type: 'string', nullable: false)]
    protected string $code;

    /**
     * @var string
     */
    #[ORM\Column(type: 'string', nullable: false)]
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