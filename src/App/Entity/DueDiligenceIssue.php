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
/**
 * @ORM\Entity
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
    protected $id = 0;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\DueDiligence", inversedBy="issues")
     * @ORM\JoinColumn(name="due_diligence_id", referencedColumnName="id", nullable=false)
     * @var DueDiligence
     */
    protected $dueDiligence;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\DueDilIssueStatus", inversedBy="issues")
     * @ORM\JoinColumn(name="status_id", referencedColumnName="id", nullable=false)
     * @var DueDilIssueStatus
     */
    protected $status;

    /**
     * @ORM\Column(type="string", nullable=false)
     */
    protected $issue = '';

    /**
     * @ORM\OneToMany(targetEntity="\App\Entity\Message", mappedBy="issue")
     * @var ArrayCollection
     */
    protected $messages;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\DealFile", inversedBy="issues")
     * @ORM\JoinColumn(name="file_id", referencedColumnName="id", nullable=false)
     * @var DealFile
     */
    protected $file;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\MessagePriority", inversedBy="issues")
     * @ORM\JoinColumn(name="priority_id", referencedColumnName="id", nullable=false)
     * @var MessagePriority
     */
    protected $priority;

    /** @ORM\Column(type="boolean", nullable=false) */
    protected $notifySeller = true;

    /** @ORM\Column(type="boolean", nullable=false) */
    protected $notifyTeam = false;

    /** @ORM\Column(type="datetime", nullable=false)
     * @var \DateTime
     **/
    protected $openDate;

    /** @ORM\Column(type="datetime", nullable=false)
     * @var \DateTime
     **/
    protected $closetDate;

    public function __construct()
    {
        $this->messages = new ArrayCollection();
        $this->dueDiligence = new DueDiligence();
        $this->status = new DueDilIssueStatus();
        $this->priority = new MessagePriority();
        $this->openDate = new \DateTime();
        $this->closetDate = new \DateTime();
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
    public function setDueDiligence(DueDiligence $dueDiligence)
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
    public function setStatus(DueDilIssueStatus $status)
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
    public function setIssue(string  $issue) { $this->issue = $issue; }

    /**
     * @return ArrayCollection
     */
    public function getMessages() :ArrayCollection { return $this->messages; }


    /**
     * @return mixed
     */
    public function getFile() { return $this->file; }

    /**
     * @param DealFile $file
     */
    public function setFile(DealFile $file) { $this->file = $file; }

    /**
     * @return MessagePriority
     */
    public function getPriority(): MessagePriority { return $this->priority; }

    /** @param MessagePriority $priority */
    public function setPriority(MessagePriority $priority)
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
    public function setNotifySeller(bool $notify)
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
    public function setNotifyTeam(bool $notify)
    {
        $this->notifySeller = $notify;
    }

    /**
     * @return \DateTime
     */
    public function getOpenDate(): \DateTime { return $this->openDate; }

    /**
     * @param \DateTime $openDate
     */
    public function setOpenDate(\DateTime $openDate)
    {
        $this->openDate = $openDate;
    }

    /**
     * @return \DateTime
     */
    public function getClosetDate(): \DateTime { return $this->closetDate; }

    /**
     * @param \DateTime $closetDate
     */
    public function setClosetDate(\DateTime $closetDate)
    {
        $this->closetDate = $closetDate;
    }

}