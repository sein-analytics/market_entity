<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 * Date: 11/5/17
 * Time: 11:22 AM
 */

namespace App\Entity;

use App\Entity\Typed\ArmIndexType;
use App\Entity\Typed\LoanType;
use App\Entity\Typed\OccupancyType;
use App\Entity\Typed\PropertyType;
use App\Entity\Typed\PurposeType;
use App\Entity\Typed\StatusType;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="MappedUserType")
 * @ChangeTrackingPolicy("NOTIFY")
 * @ORM\HasLifeCycleCallbacks
 */
class MappedUserType
{
    use NotifyChangeTrait;

    /**
     * @ORM\Id @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     **/
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\MarketUser", inversedBy="mappedTypes")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false)
     * @var MarketUser
     **/
    protected $user;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\Typed\ArmIndexType", inversedBy="mappedUserType")
     * @ORM\JoinColumn(name="arm_index_id", referencedColumnName="id", nullable=false)
     * @var ArmIndexType
     */
    protected $armIndex;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\Typed\LoanType", inversedBy="mappedUserType")
     * @ORM\JoinColumn(name="loan_type_id", referencedColumnName="id", nullable=false)
     * @var LoanType
     */
    protected $loanType;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\Typed\PropertyType", inversedBy="mappedUserType")
     * @ORM\JoinColumn(name="loan_type_id", referencedColumnName="id", nullable=false)
     * @var PropertyType
     */
    protected $propertyType;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\Typed\PurposeType", inversedBy="mappedUserType")
     * @ORM\JoinColumn(name="purpose_type_id", referencedColumnName="id", nullable=false)
     * @var PurposeType
     */
    protected $purposeType;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\Typed\OccupanctType", inversedBy="mappedUserType")
     * @ORM\JoinColumn(name="occupancy_type_id", referencedColumnName="id", nullable=false)
     * @var OccupancyType
     */
    protected $occupancyType;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\Typed\StatusType", inversedBy="mappedUserType")
     * @ORM\JoinColumn(name="status_type_id", referencedColumnName="id", nullable=false)
     * @var StatusType
     */
    protected $statusType;

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
    public function getUser(): MarketUser { return $this->user; }

    /**
     * @return ArmIndexType
     */
    public function getArmIndex(): ArmIndexType { return $this->armIndex; }

    /**
     * @return LoanType
     */
    public function getLoanType(): LoanType { return $this->loanType; }

    /**
     * @return PropertyType
     */
    public function getPropertyType(): PropertyType { return $this->propertyType; }

    /**
     * @return PurposeType
     */
    public function getPurposeType(): PurposeType { return $this->purposeType; }

    /**
     * @return OccupancyType
     */
    public function getOccupancyType(): OccupancyType { return $this->occupancyType; }

    /**
     * @return StatusType
     */
    public function getStatusType(): StatusType { return $this->statusType; }

    /**
     * @param MarketUser $user
     */
    public function setUser(MarketUser $user)
    {
        $this->user = $user;
    }

    /**
     * @param ArmIndexType $armIndex
     */
    public function setArmIndex(ArmIndexType $armIndex)
    {
        $this->armIndex = $armIndex;
    }

    /**
     * @param LoanType $loanType
     */
    public function setLoanType(LoanType $loanType)
    {
        $this->loanType = $loanType;
    }

    /**
     * @param PropertyType $propertyType
     */
    public function setPropertyType(PropertyType $propertyType)
    {
        $this->propertyType = $propertyType;
    }

    /**
     * @param PurposeType $purposeType
     */
    public function setPurposeType(PurposeType $purposeType)
    {
        $this->purposeType = $purposeType;
    }

    /**
     * @param OccupancyType $occupancyType
     */
    public function setOccupancyType(OccupancyType $occupancyType)
    {
        $this->occupancyType = $occupancyType;
    }

    /**
     * @param StatusType $statusType
     */
    public function setStatusType(StatusType $statusType)
    {
        $this->statusType = $statusType;
    }

}