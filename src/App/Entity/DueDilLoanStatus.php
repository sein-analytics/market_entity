<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 * Date: 7/3/18
 * Time: 3:00 PM
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass="\App\Repository\DueDilLoanStatus")
 * @ORM\Table(name="DueDilLoanStatus")
 */
class DueDilLoanStatus 
{
    protected array $logObject = [
        'userId' => null,
        'date' => null,
        'action' => null
    ];

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     **/
    protected int $id = 0;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\DueDiligence", inversedBy="reviewStatuses")
     * @ORM\JoinColumn(name="dd_id", referencedColumnName="id", nullable=false)
     * @var DueDiligence
     */
    protected $diligence;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\Loan", inversedBy="reviewStatuses")
     * @ORM\JoinColumn(name="ln_id", referencedColumnName="id", nullable=false)
     * @var Loan
     */
    protected $loan;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\DueDilReviewStatus", inversedBy="reviewStatuses")
     * @ORM\JoinColumn(name="status_id", referencedColumnName="id", nullable=false)
     * @var DueDilReviewStatus
     */
    protected $reviewStatus;

    /**
     * @ORM\Column(type="json", nullable=false)
     */
    protected $logger;

    /**
     * @ORM\Column(type="integer")
     */
    protected $issuesCount = 0;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @var \DateTime
     **/
    protected $lastModified = null;

    public function __construct()
    {
        $this->logger = $this->logObject;
        $this->loan = new AssetType\Residential();
        $this->diligence = new DueDiligence();
        $this->reviewStatus = new DueDilReviewStatus();
    }

    /**
     * @return array
     */
    public function getLogObject(): array { return $this->logObject; }


    /**
     * @return int
     */
    public function getId():int
    {
        return $this->id;
    }

    /**
     * @return DueDiligence
     */
    public function getDiligence(): DueDiligence { return $this->diligence; }

    /**
     * @param DueDiligence $diligence
     */
    public function setDiligence(DueDiligence $diligence):void { $this->diligence = $diligence; }

    /**
     * @return Loan
     */
    public function getLoan(): Loan { return $this->loan; }

    /**
     * @param Loan $loan
     */
    public function setLoan(Loan $loan):void { $this->loan = $loan; }

    /**
     * @return DueDilReviewStatus
     */
    public function getReviewStatus(): DueDilReviewStatus { return $this->reviewStatus; }

    /**
     * @param DueDilReviewStatus $reviewStatus
     */
    public function setReviewStatus(DueDilReviewStatus $reviewStatus):void
    {
        $this->reviewStatus = $reviewStatus;
    }

    /**
     * @return array
     */
    public function getLogger(): array { return $this->logger; }

    /**
     * @param array $logger
     */
    public function setLogger(array $logger):void
    {
        $this->logger = $logger;
    }

    /**
     * @return int
     */
    public function getIssuesCount(): int { return $this->issuesCount; }

    /**
     * @param int $issuesCount
     */
    public function setIssuesCount(int $issuesCount):void
    {
        $this->issuesCount = $issuesCount;
    }

    /**
     * @return \DateTime
     */
    public function getLastModified() : \DateTime
    {
        return $this->lastModified;
    }

    /**
     * @param \DateTime $date
     */
    public function setLastModified(\DateTime $lastModified)
    {
        $this->lastModified = $lastModified;
    }

}