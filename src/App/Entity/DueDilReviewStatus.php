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
 * @ORM\Entity
 * @ORM\Table(name="DueDilReviewStatus")
 */
class DueDilReviewStatus 
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     * @var int
     **/
    protected int $id = 0;

    /**
     * @ORM\Column(type="string", nullable=false)
     * @var string
     */
    protected string $status = '';

    /**
     * @ORM\Column(type="string", nullable=false)
     * @var string  */
    protected string $plusAction = '';

    /**
     * @ORM\Column(type="string", nullable=false)
     * @var string  */
    protected string $minusAction = '';

    /**
     * @ORM\OneToMany(targetEntity="\App\Entity\DueDilLoanStatus", mappedBy="reviewStatus")
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