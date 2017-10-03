<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 * Date: 10/2/17
 * Time: 5:31 PM
 */

namespace App\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="DueDiligence")
 */
class DueDiligence
{
    /**
     * @ORM\Id @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     **/
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\DueDiligenceRole", inversedBy="diligence")
     * @ORM\JoinColumn(name="due_diligence_role_id", referencedColumnName="id", nullable=false)
     * @var DueDiligenceRole
     */
    protected $role;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\MarketUser", inversedBy="diligence")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false)
     * @var MarketUser
     */
    protected $user;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\Deal", inversedBy="diligence")
     * @ORM\JoinColumn(name="deal_id", referencedColumnName="id", nullable=false)
     * @var Deal
     */
    protected $deal;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return DueDiligenceRole
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * @param DueDiligenceRole $role
     */
    public function setRole(DueDiligenceRole $role)
    {
        $this->role = $role;
    }

    /**
     * @param MarketUser $user
     */
    public function setUser(MarketUser $user)
    {
        $this->user = $user;
    }

    /**
     * @return MarketUser
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @return Deal
     */
    public function getDeal()
    {
        return $this->deal;
    }

    /**
     * @param Deal $deal
     */
    public function setDeal(Deal $deal)
    {
        $this->deal = $deal;
    }


}