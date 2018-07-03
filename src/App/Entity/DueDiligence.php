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
     */
    protected $issues;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\DueDiligenceRole", inversedBy="dueDiligence")
     * @ORM\JointColumn(name="dd_role_id", referencedColumnName="id", nullable=true)
     */
    protected $diligenceRole;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\DueDiligenceStatus", inversedBy="dueDiligence")
     * @ORM\JointColumn(name="dd_status_id", referencedColumnName="id", nullable=true)
     */
    protected $status;

    /**
     * @ORM\ManyToMany(targetEntity="\App\Entity\DealFile", inversedBy="diligence")
     */
    protected $files;

    function __construct()
    {
        $this->issues = new ArrayCollection();
        $this->files = new ArrayCollection();
        $this->user = new MarketUser();
        $this->deal = new Deal();
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


}