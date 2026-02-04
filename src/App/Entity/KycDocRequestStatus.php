<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'KycDocRequestStatus')]
#[ORM\Entity]
class KycDocRequestStatus
{

    /**
     * @var int
     **/
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    protected int $id;

    /**
     * @var string
     */
    #[ORM\Column(type: 'string', unique: true)]
    protected string $status;

    /**
     * @return int
     */
    public function getId(): int { return $this->id; }

    /**
     * @return string
     */
    public function getStatus(): string { return $this->status; }
    
    /**
     * @param string
     */
    public function setStatus(string $status):void { $this->status = $status; }
    
}