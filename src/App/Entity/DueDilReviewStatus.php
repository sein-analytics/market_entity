<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 * Date: 7/3/18
 * Time: 3:06 PM
 */

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * \Doctrine\ORM\Mapping\Entity
 * \Doctrine\ORM\Mapping\Table(name="DueDilReviewStatus")
 */
class DueDilReviewStatus extends AnnotationMappings
{
    /**
     * \Doctrine\ORM\Mapping\Id
     * \Doctrine\ORM\Mapping\Column(type="integer")
     * \Doctrine\ORM\Mapping\GeneratedValue
     * @var int
     **/
    protected int $id = 0;

    /**
     * \Doctrine\ORM\Mapping\Column(type="string", nullable=false)
     * @var string
     */
    protected string $status = '';

    /**
     * \Doctrine\ORM\Mapping\Column(type="string", nullable=false)
     * @var string  */
    protected string $plusAction = '';

    /**
     * \Doctrine\ORM\Mapping\Column(type="string", nullable=false)
     * @var string  */
    protected string $minusAction = '';

    /**
     * \Doctrine\ORM\Mapping\OneToMany(targetEntity="\App\Entity\DueDilLoanStatus", mappedBy="reviewStatus")
     * @var ArrayCollection
     */
    protected $reviewStatuses;

    public function __construct()
    {
        $this->reviewStatuses = new ArrayCollection();
    }

    public function addDueDilLoanStatus(DueDilLoanStatus $status)
    {
        $this->reviewStatuses->add($status);
    }

    /**
     * @return int
     */
    public function getId(): int { return $this->id; }

    /**
     * @return string
     */
    public function getStatus(): string { return $this->status; }

    /**
     * @return string
     */
    public function getPlusAction(): string { return $this->plusAction; }

    /**
     * @return string
     */
    public function getMinusAction(): string { return $this->minusAction; }

    /**
     * @return ArrayCollection
     */
    public function getStats(): ArrayCollection { return $this->reviewStatuses; }


}