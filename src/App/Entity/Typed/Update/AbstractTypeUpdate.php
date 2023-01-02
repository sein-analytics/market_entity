<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 */

namespace App\Entity\Typed\Update;

use App\Entity\DomainObject;
use Doctrine\ORM\Mapping\ChangeTrackingPolicy;
use Doctrine\ORM\Mapping\MappedSuperclass;
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
use App\Entity\Period;
use Doctrine\Tests\Common\Annotations\Null;

//use Doctrine\ORM\Mapping as ORM;

/**
 * \Doctrine\ORM\Mapping\MappedSuperClass
 * \Doctrine\ORM\Mapping\ChangeTrackingPolicy("NOTIFY")
 * */
abstract class AbstractTypeUpdate extends DomainObject
    implements TypedUpdateInterface
{
    /**
     * @var int $updateStatus
     * \Doctrine\ORM\Mapping\Column(type="integer", nullable=false)
     **/
    protected int $updateStatus = 1;

    /**
     * @var int|null $isHistory
     * \Doctrine\ORM\Mapping\Column(type="integer", nullable=true)
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