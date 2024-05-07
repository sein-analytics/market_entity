<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

//TODO ANY CHANGES TO THE TABLE MUST BE REFLECTED IN CLODUINARY ISSUER KYC FOLDERS

/**
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="\App\Repository\KycType")
 * @ORM\Table(name="KycType")
 */
class KycType
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @var int
     **/
    protected int $id;

    /**
     * @ORM\Column(type="string", unique=true)
     * @var string
     */
    protected string $type;

    /**
     * @return int
     */
    public function getId(): int { return $this->id; }

    /**
     * @return string
     */
    public function getType(): string { return $this->type; }
    
    /**
     * @param string
     */
    public function setType(string $type):void { $this->type = $type; }
    
}