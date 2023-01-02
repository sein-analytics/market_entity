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
//use Doctrine\ORM\Mapping as ORM;

/**
 * \Doctrine\ORM\Mapping\Entity(repositoryClass="\App\Repository\DueDiligence")
 * \Doctrine\ORM\Mapping\Table(name="DueDiligence")
 */
class DueDiligence extends AnnotationMappings
{
    use CreatePropertiesArrayTrait;

    /**
     * \Doctrine\ORM\Mapping\Id
     * \Doctrine\ORM\Mapping\Column(type="integer")
     * \Doctrine\ORM\Mapping\GeneratedValue
     **/
    protected int $id;


    /**
     * \Doctrine\ORM\Mapping\ManyToOne(targetEntity="\App\Entity\MarketUser", inversedBy="diligence")
     * \Doctrine\ORM\Mapping\JoinColumn(name="user_id", referencedColumnName="id", nullable=false)
     */
    protected MarketUser $user;

    /**
     * \Doctrine\ORM\Mapping\ManyToOne(targetEntity="\App\Entity\Deal", inversedBy="diligence")
     * \Doctrine\ORM\Mapping\JoinColumn(name="deal_id", referencedColumnName="id", nullable=false)
     */
    protected Deal $deal;

    /**
     * \Doctrine\ORM\Mapping\OneToMany(targetEntity="\App\Entity\DueDiligenceIssue", mappedBy="dueDiligence")
     */
    protected ArrayCollection $issues;

    /**
     * \Doctrine\ORM\Mapping\ManyToOne(targetEntity="\App\Entity\DueDiligenceRole", inversedBy="dueDiligence")
     * \Doctrine\ORM\Mapping\JoinColumn(name="dd_role_id", referencedColumnName="id", nullable=false)
     */
    protected DueDiligenceRole $diligenceRole;

    /**
     * \Doctrine\ORM\Mapping\ManyToOne(targetEntity="\App\Entity\DueDiligenceStatus", inversedBy="dueDiligence")
     * \Doctrine\ORM\Mapping\JoinColumn(name="dd_status_id", referencedColumnName="id", nullable=false)
     */
    protected DueDiligenceStatus $status;

    /**
     * One Bid should have one DueDiligence entity that references the user who placed the bid.
     * \Doctrine\ORM\Mapping\OneToOne(targetEntity="\App\Entity\Bid", inversedBy="dueDiligence")
     * \Doctrine\ORM\Mapping\JoinColumn(name="bid_id", referencedColumnName="id", nullable=true)
     */
    protected Bid $bid;

    /**
     * All other members of the Due Diligence team will have a reference due diligence ID
     * associated with the user that placed the bid
     * \Doctrine\ORM\Mapping\ManyToOne(targetEntity="\App\Entity\DueDiligence", inversedBy="ddMembers")
     * \Doctrine\ORM\Mapping\JoinColumn(name="parent_id", referencedColumnName="id", nullable=true)
     *
     */
    protected DueDiligence $parentId;

    /**
     * All other members of the Due Diligence team will have a reference due diligence ID
     * associated with the user that placed the bid
     * \Doctrine\ORM\Mapping\OneToMany(targetEntity="\App\Entity\DueDiligence", mappedBy="parentId")
     */
    protected ArrayCollection $ddMembers;

    /**
     * \Doctrine\ORM\Mapping\ManyToMany(targetEntity="\App\Entity\DealFile", inversedBy="diligence")
     */
    protected ArrayCollection $files;

    /**
     * \Doctrine\ORM\Mapping\OneToMany(targetEntity="\App\Entity\DueDilLoanStatus", mappedBy="diligence")
     */
    protected ArrayCollection  $reviewStatuses;

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