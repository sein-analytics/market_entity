<?php


namespace App\Entity\Data;
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity()
 * @ORM\Table(name="CunaRegion")
 */
class CunaRegion
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(name="id", type="integer")
     * @var int
     **/
    protected int $id;

    /**
     * @ORM\Column(type="string", unique=true)
     * @var string
     */
    protected string $label;
}