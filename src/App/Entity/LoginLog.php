<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 */

namespace App\Entity;

use DateTime;
use App\Service\CreatePropertiesArrayTrait;
 

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks as HasLifecycleCallbacks;

#[ORM\Table(name: 'LoginLog')]
#[ORM\Entity(repositoryClass: \App\Repository\LoginLog::class)]
 
#[HasLifecycleCallbacks]
class LoginLog extends DomainObject
{
    use CreatePropertiesArrayTrait;

    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    protected int $id;

    /**
     * @var MarketUser
     **/
    #[ORM\JoinColumn(name: 'user_id', referencedColumnName: 'id', nullable: false)]
    #[ORM\ManyToOne(targetEntity:  MarketUser::class, inversedBy: 'logins')]
    protected $user;

    /**
     * @var string
     */
    #[ORM\Column(type: 'string', nullable: false)]
    protected string $ip='';

    /**
     * @var string
     */
    #[ORM\Column(type: 'string', nullable: false)]
    protected string $userName='';

    /**
     * @var ?string
     */
    #[ORM\Column(type: 'string', nullable: true, unique: true)]
    protected ?string $mobileConfirmation;

    /**
     * @var ?DateTime
     */
    #[ORM\Column(type: 'datetime', nullable: false)]
    protected $startTime;

    /**
     * @var ?DateTime
     */
    #[ORM\Column(type: 'datetime', nullable: false)]
    protected $endTime;

    /**
     * @var DateTime
     */
    #[ORM\Column(type: 'time', nullable: false)]
    protected $sessionDuration = '00:00:00';

    /**
     * @var DateTime
     */
    #[ORM\Column(type: 'datetime', nullable: false)]
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
     * @return ?DateTime
     */
    public function getStartTime():?DateTime
    {
        return $this->startTime;
    }

    /**
     * @param DateTime $startTime
     */
    public function setStartTime(DateTime $startTime):void
    {
        $this->implementChange($this,'startTime', $this->startTime, $startTime);
    }

    /**
     * @return ?DateTime
     */
    public function getEndTime():?DateTime
    {
        return $this->endTime;
    }

    /**
     * @param DateTime $endTime
     */
    public function setEndTime(DateTime $endTime):void
    {
        $this->implementChange($this, 'endTime', $this->endTime, $endTime);
    }

    /**
     * @return DateTime
     */
    public function getSessionDuration():DateTime
    {
        return $this->sessionDuration;
    }

    /**
     * @return DateTime
     */
    public function getLastSeen():DateTime
    {
        return $this->lastSeen;
    }

    /**
     * @param DateTime $lastSeen
     */
    public function setLastSeen(DateTime $lastSeen):void
    {
        $this->lastSeen = $lastSeen;
    }

}