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

#[ORM\Table(name: 'DueDilIssueStatus')]
#[ORM\Entity(repositoryClass: \App\Repository\DueDilIssueStatus::class)]
class DueDilIssueStatus 
{
    /**
     * @var int
     **/
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    protected int $id = 0;

    /**
     * @var string
     */
    #[ORM\Column(type: 'string', nullable: false)]
    protected string $status = '';

    /**
     * @var ArrayCollection
     */
    #[ORM\OneToMany(targetEntity:  \App\Entity\DueDiligenceIssue::class, mappedBy: 'status')]
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