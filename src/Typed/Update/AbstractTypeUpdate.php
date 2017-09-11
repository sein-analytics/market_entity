<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 */

namespace App\Entity\Typed\Update;

use App\Entity\NotifyChangeTrait;
use Doctrine\Common\NotifyPropertyChanged;
use Doctrine\ORM\Mapping\ChangeTrackingPolicy;
use Doctrine\ORM\Mapping\MappedSuperclass;
use App\Entity\Period;
use Doctrine\ORM\Mapping as ORM;

/**
 * @MappedSuperClass
 * @ChangeTrackingPolicy("NOTIFY")
 * */
abstract class AbstractTypeUpdate implements NotifyPropertyChanged, TypedUpdateInterface
{
    use NotifyChangeTrait;
    
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
        $this->_onPropertyChanged('isHistory', $this->isHistory, $isHistory);
        $this->isHistory = $isHistory;
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
        $this->_onPropertyChanged('updateStatus', $this->updateStatus, $updateStatus);
        $this->updateStatus = $updateStatus;
    }

}