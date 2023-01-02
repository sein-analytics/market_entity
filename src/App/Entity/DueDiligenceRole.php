<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 * Date: 10/3/17
 * Time: 9:46 AM
 */

namespace App\Entity;
//use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * \Doctrine\ORM\Mapping\Entity
 * \Doctrine\ORM\Mapping\Table(name="DueDiligenceRole")
 */
class DueDiligenceRole extends AnnotationMappings
{
    /**
     * \Doctrine\ORM\Mapping\Id
     * \Doctrine\ORM\Mapping\Column(type="integer")
     * \Doctrine\ORM\Mapping\GeneratedValue
     **/
    protected int $id;

    /**
     * \Doctrine\ORM\Mapping\Column(type="string", nullable=false)
     * @var string
     */
    protected string $role = '';

    /**
     * \Doctrine\ORM\Mapping\OneToMany(targetEntity="\App\Entity\DueDiligence", mappedBy="diligenceRole")
     * @var ArrayCollection
     */
    protected $dueDiligence;

    function __construct()
    {
        $this->dueDiligence = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId():int
    {
        return $this->id;
    }

    function addDueDiligence(DueDiligence $dueDiligence):void
    {
        $this->dueDiligence->add($dueDiligence);
    }

    /**
     * @return string
     */
    public function getRole(): string
    {
        return $this->role;
    }

    /**
     * @return ArrayCollection
     */
    public function getDueDiligence(): ArrayCollection { return $this->dueDiligence; }



}