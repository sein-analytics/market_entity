<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 * Date: 7/2/18
 * Time: 1:56 PM
 */

namespace App\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="DueDilIssueStatus")
 */
class DueDilIssueStatus
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     * @var int
     **/
    protected $id = 0;

    /**
     * @ORM\Column(type="string", nullable=false)
     */
    protected $status = '';

    /**
     * @ORM\OneToMany(targetEntity="\App\Entity\DueDiligenceIssue", mappedBy="status")
     * @var ArrayCollection
     */
    protected $issues;

    public function __construct()
    {
        $this->issues = new ArrayCollection();
    }

    public function addIssue(DueDiligenceIssue $dueDiligenceIssue)
    {
        $this->issues->add($dueDiligenceIssue);
    }

    /**
     * @return int
     */
    public function getId() : int { return $this->id; }

    /**
     * @return string
     */
    public function getStatus() : string { return $this->status; }

    /**
     * @return ArrayCollection
     */
    public function getIssues() : ArrayCollection { return $this->issues; }


}