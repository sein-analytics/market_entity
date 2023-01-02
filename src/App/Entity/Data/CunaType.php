<?php


namespace App\Entity\Data;
use App\Entity\AnnotationMappings;
//use Doctrine\ORM\Mapping as ORM;
/**
 * \Doctrine\ORM\Mapping\Entity()
 * \Doctrine\ORM\Mapping\Table(name="CunaType")
 */
class CunaType extends AnnotationMappings
{
    /**
     * \Doctrine\ORM\Mapping\Id
     * \Doctrine\ORM\Mapping\GeneratedValue(strategy="AUTO")
     * \Doctrine\ORM\Mapping\Column(name="id", type="integer")
     * @var int
     **/
    protected int $id;

    /**
     * \Doctrine\ORM\Mapping\Column(type="string", unique=true)
     * @var string
     */
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