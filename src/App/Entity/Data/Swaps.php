<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 * Date: 3/13/18
 * Time: 10:00 AM
 */

namespace App\Entity\Data;

//use Doctrine\ORM\Mapping as ORM;
use App\Entity\AnnotationMappings;

/**
 * \Doctrine\ORM\Mapping\Entity(repositoryClass="\App\Repository\Data\Swaps")
 * \Doctrine\ORM\Mapping\Table(name="Swaps")
 */
class Swaps extends AnnotationMappings
{
    /**
     * \Doctrine\ORM\Mapping\Id @ORM\Column(type="integer")
     * \Doctrine\ORM\Mapping\GeneratedValue
     **/
    protected int $id;

    /**
     * \Doctrine\ORM\Mapping\Column(type="string", nullable=false)
     * @var string
     **/
    protected string $name;

    /** \Doctrine\ORM\Mapping\Column(type="decimal", precision=9, scale=6, nullable = false) **/
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