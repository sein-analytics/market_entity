<?php


namespace App\Entity\Data;

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
    protected $id;

    /**
     * @ORM\Column(type="string", unique=true)
     * @var string
     */
    protected $label;
}