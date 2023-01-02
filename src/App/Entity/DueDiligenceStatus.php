<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 * Date: 7/3/18
 * Time: 11:19 AM
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="DueDiligenceStatus")
 */
class DueDiligenceStatus 
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     **/
    protected int $id = 0;

    /**
     * @ORM\Column(type="string", nullable=false)
     * @var string
     */
    protected string $status = '';

    /**
     * @ORM\OneToMany(targetEntity="\App\Entity\DueDiligence", mappedBy="status")
     * @var ArrayCollection
     */
    protected $dueDiligence;

    public function __construct()
    {
        $this->dueDiligence = new ArrayCollection();
    }

    public function addDueDiligence(DueDiligence $dueDiligence)
    {
        $this->dueDiligence->add($dueDiligence);
    }

    /**
     * @return string
     */
    public function getId():string { return $this->id; }

    /**
     * @return string
     */
    public function getStatus():string { return $this->status; }

    /**
     * @return ArrayCollection
     */
    public function getDueDiligence():ArrayCollection { return $this->dueDiligence; }


}