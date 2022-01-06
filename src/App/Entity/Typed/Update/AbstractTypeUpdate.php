<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 */

namespace App\Entity\Typed\Update;

use App\Entity\DomainObject;
use Doctrine\ORM\Mapping\ChangeTrackingPolicy;
use Doctrine\ORM\Mapping\MappedSuperclass;
use App\Entity\Period;
use Doctrine\ORM\Mapping as ORM;

/**
 * @MappedSuperClass
 * @ChangeTrackingPolicy("NOTIFY")
 * */
abstract class AbstractTypeUpdate extends DomainObject
    implements TypedUpdateInterface
{
    /**
     * @ORM\Column(type="integer", nullable=false)
     **/
    protected $updateStatus = 1;

    /** @ORM\Column(type="integer", nullable=true)   */
    protected $isHistory;
    
    

    /**
     * @return mixed
     */
    public function getIsHistory()
    {
        return $this->isHistory;
    }

    /**
     * @param mixed $isHistory
     */
    public function setIsHistory($isHistory)
    {
        $this->implementChange($this,'isHistory', $this->isHistory, $isHistory);
    }

    /**
     * @return mixed
     */
    public function getUpdateStatus()
    {
        return $this->updateStatus;
    }

    /**
     * @param mixed $updateStatus
     */
    public function setUpdateStatus($updateStatus)
    {
        $this->implementChange($this,'updateStatus', $this->updateStatus, $updateStatus);
    }

}