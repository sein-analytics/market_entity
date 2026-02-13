<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
#[ORM\Table(name: 'ContractType')]
#[ORM\Entity]
class ContractType
{

    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    protected int $id;

    /**
     * @var string
     */
    #[ORM\Column(type: 'string', unique: true)]
    protected string $contractName;

    /**
     * @return int
     */
    public function getId(): int { return $this->id; }

    /**
     * @return string
     */
    public function getContractName(): string { return $this->contractName; }
    
    /**
     * @param string
     */
    public function setContractName(string $contractName):void { $this->contractName = $contractName; }

}