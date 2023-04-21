<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 * Date: 11/5/17
 * Time: 11:22 AM
 */

namespace App\Entity;

use App\Entity\Typed\ArmIndexType;
use App\Entity\Typed\DocumentationType;
use App\Entity\Typed\LoanType;
use App\Entity\Typed\OccupancyType;
use App\Entity\Typed\PropertyType;
use App\Entity\Typed\PurposeType;
use App\Entity\Typed\StatusType;
use App\Service\CreatePropertiesArrayTrait;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\ChangeTrackingPolicy;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks as HasLifecycleCallbacks;


class MappedUserType
{
    /*
     * @ORM\Entity(repositoryClass="\App\Repository\MappedUserType")
     * @ORM\Table(name="MappedUserType")
     * @ChangeTrackingPolicy("NOTIFY")
     * @HasLifecycleCallbacks
     */


    use CreatePropertiesArrayTrait;

    protected $id;


    protected $user;


    protected $armIndex;

    protected $loanType;

    protected $propertyType;

    protected $purposeType;

    protected $occupancyType;

    protected $statusType;

    protected $documentationType;

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
    public function getUser() { return $this->user; }

    /**
     * @return ArmIndexType
     */
    public function getArmIndex() { return $this->armIndex; }

    /**
     * @return LoanType
     */
    public function getLoanType() { return $this->loanType; }

    /**
     * @return PropertyType
     */
    public function getPropertyType() { return $this->propertyType; }

    /**
     * @return PurposeType
     */
    public function getPurposeType() { return $this->purposeType; }

    /**
     * @return OccupancyType
     */
    public function getOccupancyType() { return $this->occupancyType; }

    /**
     * @return StatusType
     */
    public function getStatusType() { return $this->statusType; }

    /**
     * @return DocumentationType
     */
    public function getDocumentationType() { return $this->documentationType; }

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