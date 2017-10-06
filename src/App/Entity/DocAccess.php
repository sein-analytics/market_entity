<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="DocAccess")
 */
class DocAccess
{
    /**
     * @ORM\Id @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     **/
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\MarketUser", inversedBy="documents")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false)
     * @var \App\Entity\MarketUser
     **/
    protected $user;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\Deal", inversedBy="documents")
     * @ORM\JoinColumn(name="deal_id", referencedColumnName="id", nullable=false)
     * @var \App\Entity\Deal
     **/
    protected $deal;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\DealFile", inversedBy="docAccess")
     * @ORM\JoinColumn(name="document_id", referencedColumnName="id", nullable=false)
     * @var DealFile
     */
    protected $document;

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
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param MarketUser $user
     */
    public function setUser(MarketUser $user)
    {
        $this->user = $user;
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