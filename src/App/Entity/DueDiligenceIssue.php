<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 * Date: 7/2/18
 * Time: 1:53 PM
 */

namespace App\Entity;

use App\Service\CreatePropertiesArrayTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\PersistentCollection;

/**
 * @ORM\Entity(repositoryClass="\App\Repository\DueDiligenceIssue")
 * @ORM\Table(name="DueDiligenceIssue")
 */
class DueDiligenceIssue 
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     * @var int
     **/
    protected int $id = 0;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\DueDiligence", inversedBy="issues")
     * @ORM\JoinColumn(name="due_diligence_id", referencedColumnName="id", nullable=false)
     * @var DueDiligence
     */
    protected DueDiligence $dueDiligence;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\DueDilIssueStatus", inversedBy="issues")
     * @ORM\JoinColumn(name="status_id", referencedColumnName="id", nullable=false)
     * @var DueDilIssueStatus
     */
    protected DueDilIssueStatus $status;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var ?string
     */
    protected ?string $issue;

    /**
     * @ORM\OneToMany(targetEntity="\App\Entity\Message", mappedBy="issue")
     * @var null|ArrayCollection|PersistentCollection
     */
    protected null|ArrayCollection|PersistentCollection $messages;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\DealFile", inversedBy="issues")
     * @ORM\JoinColumn(name="file_id", referencedColumnName="id", nullable=false)
     * @var DealFile
     */
    protected DealFile $file;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\MessagePriority", inversedBy="issues")
     * @ORM\JoinColumn(name="priority_id", referencedColumnName="id", nullable=false)
     * @var MessagePriority
     */
    protected MessagePriority $priority;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\Loan", inversedBy="issues")
     * @ORM\JoinColumn(name="loan_id", referencedColumnName="id", nullable=true)
     * @var Loan
     */
    protected Loan $loan;

    /**
     * @ORM\Column(type="boolean", nullable=false)
     * @var bool
     */
    protected bool $notifySeller = false;

    /**
     * @ORM\Column(type="boolean", nullable=false)
     * @var bool
     */
    protected bool $notifyTeam = false;

    /**
     * @ORM\Column(type="datetime", nullable=false)
     * @var \DateTime
     **/
    protected \DateTime $openDate;

    /**
     * @ORM\Column(type="datetime", nullable=false)
     * @var \DateTime
     **/
    protected \DateTime $closedDate;

    /**
     * @ORM\Column(type="string", nullable=false, unique=true)
     * @var ?string
     */
    protected ?string $annotationId;

    public function __construct()
    {
        $this->messages = new ArrayCollection();
        $this->dueDiligence = new DueDiligence();
        $this->status = new DueDilIssueStatus();
        $this->priority = new MessagePriority();
        $this->openDate = new \DateTime();
        $this->closedDate = new \DateTime();
        $this->loan = new Loan();
    }

    /**
     * @return int
     */
    public function getId() :int { return $this->id; }

    /**
     * @return DueDiligence
     */
    public function getDueDiligence(): DueDiligence
    {
        return $this->dueDiligence;
    }

    /**
     * @param DueDiligence $dueDiligence
     */
    public function setDueDiligence(DueDiligence $dueDiligence):void
    {
        $this->dueDiligence = $dueDiligence;
    }

    /**
     * @return DueDilIssueStatus
     */
    public function getStatus(): DueDilIssueStatus
    {
        return $this->status;
    }

    /**
     * @param DueDilIssueStatus $status
     */
    public function setStatus(DueDilIssueStatus $status):void
    {
        $this->status = $status;
    }

    /**
     * @return string
     */
    public function getIssue() :string { return $this->issue; }

    /**
     * @param mixed $issue
     */
    public function setIssue(string  $issue):void { $this->issue = $issue; }

    /**
     * @return ArrayCollection|PersistentCollection|null
     */
    public function getMessages(): ArrayCollection|PersistentCollection|null
    { return $this->messages; }


    /**
     * @return DealFile
     */
    public function getFile():DealFile { return $this->file; }

    /**
     * @param DealFile $file
     */
    public function setFile(DealFile $file):void { $this->file = $file; }

    /**
     * @return MessagePriority
     */
    public function getPriority(): MessagePriority { return $this->priority; }

    /** @param MessagePriority $priority */

    public function setPriority(MessagePriority $priority):void
    {
        $this->priority = $priority;
    }

    /**
     * @return bool
     */
    public function getNotifySeller() :bool { return $this->notifySeller; }


    /**
     * @param bool $notify
     */
    public function setNotifySeller(bool $notify):void
    {
        $this->notifySeller = $notify;
    }

    /**
     * @return bool
     */
    public function getNotifyTeam() :bool { return $this->notifyTeam; }

    /**
     * @param bool $notify
     */
    public function setNotifyTeam(bool $notify):void
    {
        $this->notifyTeam = $notify;
    }

    /**
     * @return \DateTime
     */
    public function getOpenDate(): \DateTime { return $this->openDate; }

    /**
     * @param \DateTime $openDate
     */
    public function setOpenDate(\DateTime $openDate):void
    {
        $this->openDate = $openDate;
    }

    /**
     * @return \DateTime
     */
    public function getClosedDate(): \DateTime { return $this->closedDate; }

    /**
     * @param \DateTime $closedDate
     */
    public function setClosedDate(\DateTime $closedDate):void
    {
        $this->closedDate = $closedDate;
    }

    /**
     * @return Loan
     */
    public function getLoan(): Loan { return $this->loan; }

    /**
     * @param Loan $loan
     */
    public function setLoan(Loan $loan):void { $this->loan = $loan; }

    /**
     * @return string
     */
    public function getAnnotationId(): string
    {
        return $this->annotationId;
    }

    /**
     * @param string $annotationId
     */
    public function setAnnotationId(string $annotationId): void
    {
        $this->annotationId = $annotationId;
    }

}