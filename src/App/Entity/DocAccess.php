<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 */

namespace App\Entity;

use App\Service\CreatePropertiesArrayTrait;
//use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * \Doctrine\ORM\Mapping\Entity(repositoryClass="\App\Repository\DocAccess")
 * \Doctrine\ORM\Mapping\Table(name="DocAccess")
 */
class DocAccess extends AnnotationMappings
{
    use CreatePropertiesArrayTrait;

    /**
     * \Doctrine\ORM\Mapping\Id
     * \Doctrine\ORM\Mapping\Column(type="integer")
     * \Doctrine\ORM\Mapping\GeneratedValue
     **/
    protected int $id;

    /**
     * \Doctrine\ORM\Mapping\ManyToOne(targetEntity="\App\Entity\MarketUser", inversedBy="documents")
     * \Doctrine\ORM\Mapping\JoinColumn(name="user_id", referencedColumnName="id", nullable=false)
     * @var MarketUser
     **/
    protected $user;

    /**
     * \Doctrine\ORM\Mapping\ManyToOne(targetEntity="\App\Entity\Deal", inversedBy="documents")
     * \Doctrine\ORM\Mapping\JoinColumn(name="deal_id", referencedColumnName="id", nullable=false)
     * @var Deal
     **/
    protected $deal;

    /**
     * \Doctrine\ORM\Mapping\ManyToOne(targetEntity="\App\Entity\DealFile", inversedBy="docAccess")
     * \Doctrine\ORM\Mapping\JoinColumn(name="document_id", referencedColumnName="id", nullable=false)
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