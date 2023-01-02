<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 * Date: 7/2/18
 * Time: 1:56 PM
 */

namespace App\Entity;
use Doctrine\Common\Collections\ArrayCollection;
//use Doctrine\ORM\Mapping as ORM;

/**
 * \Doctrine\ORM\Mapping\Entity(repositoryClass="\App\Repository\DueDilIssueStatus")
 * \Doctrine\ORM\Mapping\Table(name="DueDilIssueStatus")
 */
class DueDilIssueStatus extends AnnotationMappings
{
    /**
     * \Doctrine\ORM\Mapping\Id
     * \Doctrine\ORM\Mapping\Column(type="integer")
     * \Doctrine\ORM\Mapping\GeneratedValue
     * @var int
     **/
    protected int $id = 0;

    /**
     * \Doctrine\ORM\Mapping\Column(type="string", nullable=false)
     * @var string
     */
    protected string $status = '';

    /**
     * \Doctrine\ORM\Mapping\OneToMany(targetEntity="\App\Entity\DueDiligenceIssue", mappedBy="status")
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