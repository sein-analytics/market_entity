<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 * Date: 7/2/18
 * Time: 1:53 PM
 */

namespace App\Entity;

use \App\Entity\Message;
use DateTime;
use App\Service\CreatePropertiesArrayTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\PersistentCollection;

#[ORM\Table(name: 'DueDiligenceIssue')]
#[ORM\Entity(repositoryClass: \App\Repository\DueDiligenceIssue::class)]
class DueDiligenceIssue 
{
    /**
     * @var int
     **/
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    protected int $id = 0;

    /**
     * @var DueDiligence
     */
    #[ORM\JoinColumn(name: 'due_diligence_id', referencedColumnName: 'id', nullable: false)]
    #[ORM\ManyToOne(targetEntity:  \App\Entity\DueDiligence::class, inversedBy: 'issues')]
    protected DueDiligence $dueDiligence;

    /**
     * @var DueDilIssueStatus
     */
    #[ORM\JoinColumn(name: 'status_id', referencedColumnName: 'id', nullable: false)]
    #[ORM\ManyToOne(targetEntity:  \App\Entity\DueDilIssueStatus::class, inversedBy: 'issues')]
    protected DueDilIssueStatus $status;

    /**
     * @var ?string
     */
    #[ORM\Column(type: 'string', nullable: true)]
    protected ?string $issue;

    /**
     * @var null|ArrayCollection|PersistentCollection
     */
    #[ORM\OneToMany(targetEntity: Message::class, mappedBy: 'issue')]
    protected null|ArrayCollection|PersistentCollection $messages;

    /**
     * @var DealFile
     */
    #[ORM\JoinColumn(name: 'file_id', referencedColumnName: 'id', nullable: false)]
    #[ORM\ManyToOne(targetEntity:  \App\Entity\DealFile::class, inversedBy: 'issues')]
    protected DealFile $file;

    /**
     * @var MessagePriority
     */
    #[ORM\JoinColumn(name: 'priority_id', referencedColumnName: 'id', nullable: false)]
    #[ORM\ManyToOne(targetEntity:  \App\Entity\MessagePriority::class, inversedBy: 'issues')]
    protected MessagePriority $priority;

    /**
     * @var Loan
     */
    #[ORM\JoinColumn(name: 'loan_id', referencedColumnName: 'id', nullable: true)]
    #[ORM\ManyToOne(targetEntity:  \App\Entity\Loan::class, inversedBy: 'issues')]
    protected Loan $loan;

    /**
     * @var bool
     */
    #[ORM\Column(type: 'boolean', nullable: false)]
    protected bool $notifySeller = false;

    /**
     * @var bool
     */
    #[ORM\Column(type: 'boolean', nullable: false)]
    protected bool $notifyTeam = false;

    /**
     * @var DateTime
     **/
    #[ORM\Column(type: 'datetime', nullable: false)]
    protected DateTime $openDate;

    /**
     * @var DateTime
     **/
    #[ORM\Column(type: 'datetime', nullable: false)]
    protected DateTime $closedDate;

    /**
     * @var ?string
     */
    #[ORM\Column(type: 'string', nullable: false, unique: true)]
    protected ?string $annotationId;

    public function __construct()
    {
        $this->messages = new ArrayCollection();
        $this->dueDiligence = new DueDiligence();
        $this->status = new DueDilIssueStatus();
        $this->priority = new MessagePriority();
        $this->openDate = new DateTime();
        $this->closedDate = new DateTime();
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
     * @return DateTime
     */
    public function getOpenDate(): DateTime { return $this->openDate; }

    /**
     * @param DateTime $openDate
     */
    public function setOpenDate(DateTime $openDate):void
    {
        $this->openDate = $openDate;
    }

    /**
     * @return DateTime
     */
    public function getClosedDate(): DateTime { return $this->closedDate; }

    /**
     * @param DateTime $closedDate
     */
    public function setClosedDate(DateTime $closedDate):void
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