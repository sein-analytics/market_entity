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
 * @ORM\Entity(repositoryClass="\App\Repository\DueDiligence")
 * @ORM\Table(name="DueDiligence")
 */
class DueDiligence
{
    use CreatePropertiesArrayTrait;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     **/
    protected int $id;


    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\MarketUser", inversedBy="diligence")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false)
     */
    protected MarketUser $user;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\Deal", inversedBy="diligence")
     * @ORM\JoinColumn(name="deal_id", referencedColumnName="id", nullable=false)
     */
    protected Deal $deal;

    /**
     * @ORM\OneToMany(targetEntity="\App\Entity\DueDiligenceIssue", mappedBy="dueDiligence")
     */
    protected $issues;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\DueDiligenceRole", inversedBy="dueDiligence")
     * @ORM\JoinColumn(name="dd_role_id", referencedColumnName="id", nullable=false)
     */
    protected DueDiligenceRole $diligenceRole;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\DueDiligenceStatus", inversedBy="dueDiligence")
     * @ORM\JoinColumn(name="dd_status_id", referencedColumnName="id", nullable=false)
     */
    protected DueDiligenceStatus $status;

    /**
     * One Bid should have one DueDiligence entity that references the user who placed the bid.
     * @ORM\OneToOne(targetEntity="\App\Entity\Bid", inversedBy="dueDiligence")
     * @ORM\JoinColumn(name="bid_id", referencedColumnName="id", nullable=true)
     */
    protected Bid $bid;

    /**
     * All other members of the Due Diligence team will have a reference due diligence ID
     * associated with the user that placed the bid
     * @ORM\ManyToOne(targetEntity="\App\Entity\DueDiligence", inversedBy="ddMembers")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id", nullable=true)
     *
     */
    protected DueDiligence $parentId;

    /**
     * All other members of the Due Diligence team will have a reference due diligence ID
     * associated with the user that placed the bid
     * @ORM\OneToMany(targetEntity="\App\Entity\DueDiligence", mappedBy="parentId")
     */
    protected $ddMembers;

    /**
     * @ORM\ManyToMany(targetEntity="\App\Entity\DealFile", inversedBy="diligence")
     */
    protected $files;

    /**
     * @ORM\OneToMany(targetEntity="\App\Entity\DueDilLoanStatus", mappedBy="diligence")
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

    public function addReviewToDueDil(DueDilReviewStatus $stat):void
    {
        $this->reviewStatuses->add($stat);
    }

    public function addFileToDueDil(DealFile $file):void
    {
        $this->files->add($file);
    }

    public function addFile(DealFile $file):void
    {
        $this->files->add($file);
    }

    function addMDueDiligenceIssue(DueDiligenceIssue $issue):void
    {
        $this->issues->add($issue);
    }

    public function getId():int { return $this->id; }

    /**
     * @param MarketUser $user
     */
    public function setUser(MarketUser $user):void
    {
        $this->user = $user;
    }

    public function getUser() : MarketUser { return $this->user; }

    public function getDeal() :Deal { return $this->deal; }

    /**
     * @param Deal $deal
     */
    public function setDeal(Deal $deal):void
    {
        $this->deal = $deal;
    }

    public function getIssues():ArrayCollection { return $this->issues; }

    public function getDiligenceRole():DueDiligenceRole { return $this->diligenceRole; }

    /**
     * @param DueDiligenceRole $diligenceRole
     */
    public function setDiligenceRole(DueDiligenceRole $diligenceRole):void
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
    public function setStatus(DueDiligenceStatus $status):void
    {
        $this->status = $status;
    }

    public function getFiles():ArrayCollection { return $this->files; }

    public function getReviewStatuses():ArrayCollection { return $this->reviewStatuses; }

    /**
     * @return Bid|null
     */
    public function getBid():Bid|null { return $this->bid; }

    /**
     * @param Bid $bid
     */
    public function setBid(Bid $bid):void { $this->bid = $bid; }

}