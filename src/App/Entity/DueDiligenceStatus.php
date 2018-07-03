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
    protected $id = 0;

    /**
     * @ORM\Column(type="string", nullable=false)
     * @var string
     */
    protected $status = '';

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
     * @return mixed
     */
    public function getId() { return $this->id; }

    /**
     * @return string
     */
    public function getStatus() { return $this->status; }

    /**
     * @return ArrayCollection
     */
    public function getDueDiligence() { return $this->dueDiligence; }


}