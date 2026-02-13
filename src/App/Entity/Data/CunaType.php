<?php


namespace App\Entity\Data;
use Doctrine\ORM\Mapping as ORM;
#[ORM\Table(name: 'CunaType')]
#[ORM\Entity]
class CunaType
{
    /**
     * @var int
     **/
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    #[ORM\Column(name: 'id', type: 'integer')]
    protected int $id;

    /**
     * @var string
     */
    #[ORM\Column(type: 'string', unique: true)]
    protected string $label;

    /**
     * @return int
     */
    public function getId(): int { return $this->id; }

    /**
     * @return string
     */
    public function getLabel(): string { return $this->label; }


}