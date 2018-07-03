<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 * Date: 10/2/17
 * Time: 5:31 PM
 */

namespace App\Entity;
use App\Service\CreatePropertiesArrayTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="DueDiligence")
 */
class DueDiligence
{
    use NotifyChangeTrait, CreatePropertiesArrayTrait;

    /**
     * @ORM\Id @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     **/
    protected $id;


    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\MarketUser", inversedBy="diligence")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false)
     * @var MarketUser
     */
    protected $user;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\Deal", inversedBy="diligence")
     * @ORM\JoinColumn(name="deal_id", referencedColumnName="id", nullable=false)
     * @var Deal
     */
    protected $deal;

    /**
     * @ORM\OneToMany(targetEntity="\App\Entity\DueDiligenceIssue", mappedBy="dueDiligence")
     * @var ArrayCollection
     */
    protected $issues;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\DueDiligenceRole", inversedBy="dueDiligence")
     * @ORM\JoinColumn(name="dd_role_id", referencedColumnName="id", nullable=false)
     * @var DueDiligenceRole
     */
    protected $diligenceRole;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\DueDiligenceStatus", inversedBy="dueDiligence")
     * @ORM\JoinColumn(name="dd_status_id", referencedColumnName="id", nullable=false)
     * @var DueDiligenceStatus
     */
    protected $status;

    /**
     * @ORM\ManyToMany(targetEntity="\App\Entity\DealFile", inversedBy="diligence")
     * @var ArrayCollection
     */
    protected $files;

    /**
     * @ORM\OneToMany(targetEntity="\App\Entity\DueDilLoanStatus", mappedBy="diligence")
     * @var ArrayCollection
     */
    protected $reviewStatuses;

    function __construct()
    {
        $this->issues = new ArrayCollection();
        $this->files = new ArrayCollection();
        $this->reviewStatuses = new ArrayCollection();
        $this->user = new MarketUser();
        $this->deal = new Deal();
    }

    public function addReviewToDueDil(DueDilReviewStatus $stat)
    {
        $this->reviewStatuses->add($stat);
    }

    public function addFileToDueDil(DealFile $file)
    {
        $this->files->add($file);
    }

    public function addFile(DealFile $file)
    {
        $this->files->add($file);
    }

    function addMDueDiligenceIssue(DueDiligenceIssue $issue)
    {
        $this->issues->add($issue);
    }

    /**
     * @return mixed
     */
    public function getId() { return $this->id; }

    /**
     * @param MarketUser $user
     */
    public function setUser(MarketUser $user)
    {
        $this->user = $user;
    }

    /**
     * @return MarketUser
     */
    public function getUser() : MarketUser { return $this->user; }

    /**
     * @return Deal
     */
    public function getDeal() :Deal { return $this->deal; }

    /**
     * @param Deal $deal
     */
    public function setDeal(Deal $deal)
    {
        $this->deal = $deal;
    }

    /**
     * @return ArrayCollection
     */
    public function getIssues() { return $this->issues; }

    /**
     * @return DueDiligenceRole
     */
    public function getDiligenceRole() { return $this->diligenceRole; }

    /**
     * @param DueDiligenceRole $diligenceRole
     */
    public function setDiligenceRole(DueDiligenceRole $diligenceRole)
    {
        $this->diligenceRole = $diligenceRole;
    }

    /**
     * @return DueDiligenceStatus
     */
    public function getStatus() : DueDiligenceStatus { return $this->status; }

    /**
     * @param DueDiligenceStatus $status
     */
    public function setStatus(DueDiligenceStatus $status)
    {
        $this->status = $status;
    }

    /**
     * @return ArrayCollection
     */
    public function getFiles() { return $this->files; }

    /**
     * @return ArrayCollection
     */
    public function getReviewStatuses() { return $this->reviewStatuses; }

}