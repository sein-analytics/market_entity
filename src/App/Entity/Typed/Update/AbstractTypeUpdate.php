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
 * @ORM\MappedSuperclass
 * @ORM\ChangeTrackingPolicy("NOTIFY")
 * */
abstract class AbstractTypeUpdate extends DomainObject
    implements TypedUpdateInterface
{
    /**
     * @var int $updateStatus
     * @ORM\Column(type="integer", nullable=false)
     **/
    protected int $updateStatus = 1;

    /**
     * @var int|null $isHistory
     * @ORM\Column(type="integer", nullable=true)
     */
    protected int|null $isHistory;


    /**
     * @return int|null
     */
    public function getIsHistory():?int
    {
        return $this->isHistory;
    }

    /**
     * @param int $isHistory
     */
    public function setIsHistory(int $isHistory):void
    {
        $this->implementChange($this,'isHistory', $this->isHistory, $isHistory);
    }

    /**
     * @return int
     */
    public function getUpdateStatus():int
    {
        return $this->updateStatus;
    }

    /**
     * @param int  $updateStatus
     */
    public function setUpdateStatus(int $updateStatus):void
    {
        $this->implementChange($this,'updateStatus', $this->updateStatus, $updateStatus);
    }

}