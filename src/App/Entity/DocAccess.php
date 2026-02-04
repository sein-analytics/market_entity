<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 */

namespace App\Entity;

use \App\Entity\DealFile;
use App\Service\CreatePropertiesArrayTrait;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Table(name: 'DocAccess')]
#[ORM\Entity(repositoryClass: \App\Repository\DocAccess::class)]
class DocAccess
{
    use CreatePropertiesArrayTrait;

    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    protected int $id;

    /**
     * @var MarketUser
     **/
    #[ORM\JoinColumn(name: 'user_id', referencedColumnName: 'id', nullable: false)]
    #[ORM\ManyToOne(targetEntity:  \App\Entity\MarketUser::class, inversedBy: 'documents')]
    protected $user;

    /**
     * @var Deal
     **/
    #[ORM\JoinColumn(name: 'deal_id', referencedColumnName: 'id', nullable: false)]
    #[ORM\ManyToOne(targetEntity:  \App\Entity\Deal::class, inversedBy: 'documents')]
    protected $deal;

    /**
     * @var DealFile
     */
    #[ORM\JoinColumn(name: 'document_id', referencedColumnName: 'id', nullable: false)]
    #[ORM\ManyToOne(targetEntity: DealFile::class, inversedBy: 'docAccess')]
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