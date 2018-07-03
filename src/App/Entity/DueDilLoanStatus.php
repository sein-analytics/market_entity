<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 * Date: 7/3/18
 * Time: 3:00 PM
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="DueDilLoanStatus")
 */
class DueDilLoanStatus
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     **/
    protected $id = 0;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\DueDiligence", inversedBy="reviewStatuses")
     * @ORM\JoinColumn(name="dd_id", referencedColumnName="id", nullable=false)
     * @var DueDiligence
     */
    protected $diligence;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\Loan", inversedBy="reviewStatuses")
     * @ORM\JoinColumn(name="loan_id", referencedColumnName="id", nullable=false)
     * @var Loan
     */
    protected $loan;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\DueDilReviewStatus", inversedBy="reviewStatuses")
     * @ORM\JoinColumn(name="status_id", referencedColumnName="id", nullable=false)
     * @var DueDilReviewStatus
     */
    protected $reviewStatus;


}