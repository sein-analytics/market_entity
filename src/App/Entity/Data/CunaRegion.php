<?php


namespace App\Entity\Data;
use Doctrine\ORM\Mapping as ORM;
#[ORM\Table(name: 'CunaRegion')]
#[ORM\Entity]
class CunaRegion
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
}