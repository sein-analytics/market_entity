<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 * Date: 9/21/18
 * Time: 11:44 AM
 */

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\PersistentCollection;
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 * @ORM\Table(name="BasisCount")
 *
 */
class BasisCount extends DomainObject
{

    const BASE_360 = 360;

    const BASE_364 = 364;

    const BASE_365 = 365;

    const BASE_366 = 366;

    const BASE_30 = 30;

    const DAY_COUNT_FACTOR = 'dayCountFactor';

    const COUPON_FACTOR = 'couponFactor';

    private static $bases = [
        self::BASE_360 => null,
        self::BASE_364 => null,
        self::BASE_365 => null,
    ];

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     * @var int
     **/
    protected $id;

    /**
     * @ORM\Column(type="string", nullable=false)
     */
    protected $basis;

    /**
     * @ORM\Column(type="json", nullable=false)
     * @var string
     */
    protected $formula;

    /**
     * @ORM\OneToMany(targetEntity = "\App\Entity\Bond", mappedBy="basisCount")
     * @var ArrayCollection
     */
    protected $bonds;

    public function __construct()
    {
        $this->bonds = new ArrayCollection();
        parent::__construct();
    }

    /**
     * @param \DateTime $startDate
     * @param \DateTime $thruDate
     * @return float|int
     */
    public function calculate30_360DayCountFactor(\DateTime $startDate, \DateTime $thruDate)
    {
        $factor = $this->factorNumerator($thruDate->diff($startDate)) / self::BASE_360;
        return $factor;
    }

    /**
     * @param \DateTime $startDate
     * @param \DateTime $thruDate
     * @param int $freq
     * @return float|int
     */
    public function calculate30_360CouponFactor(\DateTime $startDate, \DateTime $thruDate, int $freq=0)
    {
        $factor = $this->factorNumerator($startDate->diff($thruDate)) / self::BASE_360;
        return $factor;
    }

    /**
     * @param \DateTime $startDate
     * @param \DateTime $thruDate
     * @param \DateTime $couponDate
     * @param int $frequency
     * @return float|int
     */
    public function calculateActual_actualDayCountFactor(\DateTime $startDate, \DateTime $thruDate, \DateTime $couponDate, int $frequency)
    {
        $factor = $thruDate->diff($startDate)->days / ($frequency * $couponDate->diff($startDate)->days);
        return $factor;
    }

    /**
     * @param \DateTime $startDate
     * @param \DateTime $couponDate
     * @param int $frequency
     * @return float|int
     */
    public function calculateActual_actualCouponFactor(\DateTime $startDate, \DateTime $couponDate, int $frequency)
    {
        $factor = $couponDate->diff($startDate)->days / ($frequency * $couponDate->diff($startDate)->days);
        return $factor;
    }

    /**
     * @param \DateInterval $diff
     * @return float|int
     */
    public function factorNumerator(\DateInterval $diff)
    {
        return (self::BASE_360 * $diff->y + self::BASE_30 * $diff->m + $diff->d);
    }

    /**
     * @param \DateTime $startDate
     * @param \DateTime $thruDate
     * @param \DateTime $couponDate
     * @param int $base
     * @param string $calcType
     * @return bool|float|int
     */
    public function calculateActual_fixedFactors(\DateTime $startDate, \DateTime $thruDate, \DateTime $couponDate, int $base, string $calcType)
    {
        if ($calcType !== self::DAY_COUNT_FACTOR && $calcType !== self::COUPON_FACTOR)
            return false;
        if (!array_key_exists($base ,self::$bases))
            return false;
        if ($calcType === self::DAY_COUNT_FACTOR)
            return $thruDate->diff($startDate)->days / $base;
        elseif ($calcType == self::COUPON_FACTOR)
            return $couponDate->diff($startDate)->days / $base;
    }

    /**
     * @return int
     */
    public function getId():int { return $this->id; }

    /**
     * @return mixed
     */
    public function getBasis() { return $this->basis; }

    /**
     * @return ArrayCollection|PersistentCollection
     */
    public function getUsedBy() { return $this->bonds; }

    public function getFormula() :string  { return $this->formula; }

}