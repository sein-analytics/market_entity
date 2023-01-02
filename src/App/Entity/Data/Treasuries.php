<?php


namespace App\Entity\Data;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="\App\Repository\Data\Treasuries")
 * @ORM\Table(name="Treasuries")
 */
class Treasuries
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     **/
    protected int $id;

    /**
     * @ORM\Column(type="string", nullable=false)
     * @var string
     **/
    protected string $name;

    /** @ORM\Column(type="decimal", precision=9, scale=6, nullable = true) **/
    protected float $value;

    /**
     * @return int
     */
    public function getId():int { return $this->id; }

    /**
     * @return string
     */
    public function getName(): string { return $this->name; }

    /**
     * @return float
     */
    public function getValue():float { return $this->value; }

    /**
     * @param float $value
     */
    public function setValue(float $value):void
    {
        $this->value = $value;
    }
}