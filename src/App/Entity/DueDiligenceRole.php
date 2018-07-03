<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 * Date: 10/3/17
 * Time: 9:46 AM
 */

namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="DueDiligenceRole")
 */
class DueDiligenceRole
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     **/
    protected $id;

    /**
     * @ORM\Column(type="string", nullable=false)
     * @var string
     */
    protected $role;

    /**
     * @ORM\OneToMany(targetEntity="\App\Entity\DueDiligence", mappedBy="diligenceRole")
     * @var ArrayCollection
     */
    protected $dueDiligence;

    function __construct()
    {
        $this->dueDiligence = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    function addDueDiligence(DueDiligence $dueDiligence)
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