<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 * Date: 7/3/18
 * Time: 3:00 PM
 */

namespace App\Entity;

//use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * \Doctrine\ORM\Mapping\Entity(repositoryClass="\App\Repository\DueDilLoanStatus")
 * \Doctrine\ORM\Mapping\Table(name="DueDilLoanStatus")
 */
class DueDilLoanStatus extends AnnotationMappings
{
    protected array $logObject = [
        'userId' => null,
        'date' => null,
        'action' => null
    ];

    /**
     * \Doctrine\ORM\Mapping\Id
     * \Doctrine\ORM\Mapping\Column(type="integer")
     * \Doctrine\ORM\Mapping\GeneratedValue
     **/
    protected int $id = 0;

    /**
     * \Doctrine\ORM\Mapping\ManyToOne(targetEntity="\App\Entity\DueDiligence", inversedBy="reviewStatuses")
     * \Doctrine\ORM\Mapping\JoinColumn(name="dd_id", referencedColumnName="id", nullable=false)
     * @var DueDiligence
     */
    protected $diligence;

    /**
     * \Doctrine\ORM\Mapping\ManyToOne(targetEntity="\App\Entity\Loan", inversedBy="reviewStatuses")
     * \Doctrine\ORM\Mapping\JoinColumn(name="ln_id", referencedColumnName="id", nullable=false)
     * @var Loan
     */
    protected $loan;

    /**
     * \Doctrine\ORM\Mapping\ManyToOne(targetEntity="\App\Entity\DueDilReviewStatus", inversedBy="reviewStatuses")
     * \Doctrine\ORM\Mapping\JoinColumn(name="status_id", referencedColumnName="id", nullable=false)
     * @var DueDilReviewStatus
     */
    protected $reviewStatus;

    /**
     * \Doctrine\ORM\Mapping\Column(type="json", nullable=false)
     */
    protected $logger;

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

}