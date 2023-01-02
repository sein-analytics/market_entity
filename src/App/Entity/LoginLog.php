<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 */

namespace App\Entity;

use App\Service\CreatePropertiesArrayTrait;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\OneToOne;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\ManyToMany;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\JoinColumns;
use Doctrine\ORM\Mapping\JoinTable;
use Doctrine\ORM\Mapping\GeneratedValue;

use Doctrine\ORM\Mapping\DiscriminatorColumn;
use Doctrine\ORM\Mapping\DiscriminatorMap;

use Doctrine\ORM\Mapping\Index;
use Doctrine\ORM\Mapping\ChangeTrackingPolicy;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * \Doctrine\ORM\Mapping\Entity(repositoryClass="\App\Repository\LoginLog")
 * \Doctrine\ORM\Mapping\Table(name="LoginLog")
 * \Doctrine\ORM\Mapping\ChangeTrackingPolicy("NOTIFY")
 * \Doctrine\ORM\Mapping\HasLifeCycleCallbacks
 */
class LoginLog extends DomainObject
{
    use CreatePropertiesArrayTrait;

    /**
     * \Doctrine\ORM\Mapping\Id
     * \Doctrine\ORM\Mapping\Column(type="integer")
     * \Doctrine\ORM\Mapping\GeneratedValue
     **/
    protected int $id;

    /**
     * \Doctrine\ORM\Mapping\ManyToOne(targetEntity="\App\Entity\MarketUser", inversedBy="logins")
     * \Doctrine\ORM\Mapping\JoinColumn(name="user_id", referencedColumnName="id", nullable=false)
     * @var MarketUser
     **/
    protected $user;

    /**
     * \Doctrine\ORM\Mapping\Column(type="string", nullable=false)
     * @var string
     */
    protected string $ip='';

    /**
     * \Doctrine\ORM\Mapping\Column(type="string", nullable=false)
     * @var string
     */
    protected string $userName='';

    /**
     * \Doctrine\ORM\Mapping\Column(type="string", nullable=true, unique=true)
     * @var ?string
     */
    protected ?string $mobileConfirmation;

    /**
     * \Doctrine\ORM\Mapping\Column(type="datetime", nullable=false)
     * @var ?\DateTime
     */
    protected $startTime;

    /**
     * \Doctrine\ORM\Mapping\Column(type="datetime", nullable=false)
     * @var ?\DateTime
     */
    protected $endTime;

    /**
     * \Doctrine\ORM\Mapping\Column(type="time", nullable=false)
     * @var \DateTime
     */
    protected $sessionDuration = '00:00:00';

    /**
     * \Doctrine\ORM\Mapping\Column(type="datetime", nullable=false)
     * @var \DateTime
     */
    protected $lastSeen = '00:00:00';

    /**
     * @return int
     */
    public function getId():int
    {
        return $this->id;
    }

    /**
     * @return MarketUser
     */
    public function getUser():MarketUser
    {
        return $this->user;
    }

    /**
     * @param MarketUser $user
     */
    public function setUser(MarketUser $user):void
    {
        $this->implementChange($this,'user', $this->user, $user);
    }

    /**
     * @return string
     */
    public function getIp():string
    {
        return $this->ip;
    }

    /**
     * @param string  $ip
     */
    public function setIp(string $ip):void
    {
        $this->implementChange($this, 'ip', $this->ip, $ip);
    }

    /**
     * @return string
     */
    public function getUserName():string
    {
        return $this->userName;
    }

    /**
     * @param string $userName
     */
    public function setUserName(string $userName)
    {
        $this->implementChange($this,'userName', $this->userName, $userName);
    }


    /**
     * @return ?string
     */
    public function getMobileConfirmation():?string
    {
        return $this->mobileConfirmation;
    }

    /**
     * @param string $mobileConfirmation
     */
    public function setMobileConfirmation(string $mobileConfirmation)
    {
        $this->implementChange($this, 'mobileConfirmation', $this->mobileConfirmation, $mobileConfirmation);
    }

    /**
     * @return ?\DateTime
     */
    public function getStartTime():?\DateTime
    {
        return $this->startTime;
    }

    /**
     * @param \DateTime $startTime
     */
    public function setStartTime(\DateTime $startTime):void
    {
        $this->implementChange($this,'startTime', $this->startTime, $startTime);
    }

    /**
     * @return ?\DateTime
     */
    public function getEndTime():?\DateTime
    {
        return $this->endTime;
    }

    /**
     * @param \DateTime $endTime
     */
    public function setEndTime(\DateTime $endTime):void
    {
        $this->implementChange($this, 'endTime', $this->endTime, $endTime);
    }

    /**
     * @return \DateTime
     */
    public function getSessionDuration():\DateTime
    {
        return $this->sessionDuration;
    }

    /**
     * @return \DateTime
     */
    public function getLastSeen():\DateTime
    {
        return $this->lastSeen;
    }

    /**
     * @param \DateTime $lastSeen
     */
    public function setLastSeen(\DateTime $lastSeen):void
    {
        $this->lastSeen = $lastSeen;
    }

}