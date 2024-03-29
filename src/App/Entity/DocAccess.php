<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 */

namespace App\Entity;

use App\Service\CreatePropertiesArrayTrait;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass="\App\Repository\DocAccess")
 * @ORM\Table(name="DocAccess")
 */
class DocAccess
{
    use CreatePropertiesArrayTrait;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     **/
    protected int $id;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\MarketUser", inversedBy="documents")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false)
     * @var MarketUser
     **/
    protected $user;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\Deal", inversedBy="documents")
     * @ORM\JoinColumn(name="deal_id", referencedColumnName="id", nullable=false)
     * @var Deal
     **/
    protected $deal;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\DealFile", inversedBy="docAccess")
     * @ORM\JoinColumn(name="document_id", referencedColumnName="id", nullable=false)
     * @var DealFile
     */
    protected $document;

    /**
     * @return int
     */
    public function getId():int
    {
        return $this->id;
    }

    /**
     * @return MarketUser
     */
    public function getUser():MarketUser
    {
        return $this->user;
    }

    /**
     * @param MarketUser $user
     */
    public function setUser(MarketUser $user):void
    {
        $this->user = $user;
    }

    /**
     * @return Deal
     */
    public function getDeal():Deal
    {
        return $this->deal;
    }

    /**
     * @param Deal $deal
     */
    public function setDeal(Deal $deal):void
    {
        $this->deal = $deal;
    }


}