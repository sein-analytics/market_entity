<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 */

namespace App\Entity;

use App\Service\CreatePropertiesArrayTrait;
use Doctrine\Common\NotifyPropertyChanged;
use Doctrine\ORM\Mapping\ChangeTrackingPolicy;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass="\App\Repository\LoginLog")
 * @ORM\Table(name="LoginLog")
 * @ChangeTrackingPolicy("NOTIFY")
 * @ORM\HasLifeCycleCallbacks
 */
class LoginLog extends DomainObject
{
    use CreatePropertiesArrayTrait;

    /**
     * @ORM\Id @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     **/
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\MarketUser", inversedBy="logins")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false)
     * @var \App\Entity\MarketUser
     **/
    protected $user;

    /** @ORM\Column(type="string", nullable=false)   */
    protected $ip;

    /** @ORM\Column(type="string", nullable=false)   */
    protected $userName;

    /** @ORM\Column(type="string", nullable=true, unique=true)   */
    protected $mobileConfirmation;

    /** @ORM\Column(type="datetime", nullable=false)   */
    protected $startTime;

    /** @ORM\Column(type="datetime", nullable=false)   */
    protected $endTime;

    /** @ORM\Column(type="time", nullable=false)   */
    protected $sessionDuration = '00:00:00';

    /** @ORM\Column(type="time")   */
    protected $lastSeen = '00:00:00';

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return MarketUser
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param MarketUser $user
     */
    public function setUser(MarketUser $user)
    {
        $this->implementChange($this,'user', $this->user, $user);
    }

    /**
     * @return mixed
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * @param mixed $ip
     */
    public function setIp($ip)
    {
        $this->implementChange($this, 'ip', $this->ip, $ip);
    }

    /**
     * @return mixed
     */
    public function getUserName()
    {
        return $this->userName;
    }

    /**
     * @param mixed $userName
     */
    public function setUserName($userName)
    {
        $this->implementChange($this,'userName', $this->userName, $userName);
    }


    /**
     * @return mixed
     */
    public function getMobileConfirmation()
    {
        return $this->mobileConfirmation;
    }

    /**
     * @param mixed $mobileConfirmation
     */
    public function setMobileConfirmation($mobileConfirmation)
    {
        $this->implementChange($this, 'mobileConfirmation', $this->mobileConfirmation, $mobileConfirmation);
    }

    /**
     * @return mixed
     */
    public function getStartTime()
    {
        return $this->startTime;
    }

    /**
     * @param \DateTime $startTime
     */
    public function setStartTime(\DateTime $startTime)
    {
        $this->implementChange($this,'startTime', $this->startTime, $startTime);
    }

    /**
     * @return mixed
     */
    public function getEndTime()
    {
        return $this->endTime;
    }

    /**
     * @param \DateTime $endTime
     */
    public function setEndTime(\DateTime $endTime)
    {
        $this->implementChange($this, 'endTime', $this->endTime, $endTime);
    }

    /**
     * @return mixed
     */
    public function getSessionDuration()
    {
        return $this->sessionDuration;
    }

    /**
     * @return string
     */
    public function getLastSeen()
    {
        return $this->lastSeen;
    }

    /**
     * @param \DateTime $lastSeen
     */
    public function setLastSeen(\DateTime $lastSeen)
    {
        $this->lastSeen = $lastSeen;
    }

}