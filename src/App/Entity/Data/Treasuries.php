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
     * @ORM\Id @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     **/
    protected $id;

    /**
     * @ORM\Column(type="string", nullable=false)
     * @var string
     **/
    protected $name;

    /** @ORM\Column(type="decimal", precision=9, scale=6, nullable = true) **/
    protected $value;

    /**
     * @return mixed
     */
    public function getId() { return $this->id; }

    /**
     * @return string
     */
    public function getName(): string { return $this->name; }

    /**
     * @return mixed
     */
    public function getValue() { return $this->value; }

    /**
     * @param mixed $value
     */
    public function setValue(float $value)
    {
        $this->value = $value;
    }
}