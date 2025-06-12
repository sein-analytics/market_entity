<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 * Date: 3/13/18
 * Time: 10:00 AM
 */

namespace App\Entity\Data;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="\App\Repository\Data\Swaps")
 * @ORM\Table(name="Swaps")
 */
class Swaps
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

    /** @ORM\Column(type="float", precision=9, scale=6, nullable = false) **/
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
     * @param mixed $value
     */
    public function setValue(float $value)
    {
        $this->value = $value;
    }

}