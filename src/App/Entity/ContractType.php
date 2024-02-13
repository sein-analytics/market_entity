<?php

namespace App\Entity;

/**
 * @ORM\Table(name="ContractType")
 */
class ContractType
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     **/
    protected int $id;

    /**
     * @ORM\Column(type="string", unique=true)
     * @var string
     */
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