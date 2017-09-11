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

    /** @ORM\ManyToOne(targetEntity="\App\Entity\MarketUser", inversedBy="documents")
     * @var \App\Entity\MarketUser
     **/
    protected $user;

    /** @ORM\ManyToOne(targetEntity="\App\Entity\Deal", inversedBy="documents")
     * @var \App\Entity\Deal
     **/
    protected $deal;

    /**
     * @ORM\Column(type="string", nullable=false)
     * @var string
     **/
    protected $userHash;

    /**
     * @ORM\Column(type="string", nullable=false)
     * @var string
     **/
    protected $dealHash;

    /**
     * @ORM\Column(type="string", nullable=false)
     * @var string
     **/
    protected $signedUrl;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\DealFile", inversedBy="docAccess")
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

    /**
     * @return mixed
     */
    public function getUserHash()
    {
        return $this->userHash;
    }

    /**
     * @param mixed $userHash
     */
    public function setUserHash(string $userHash)
    {
        $this->userHash = $userHash;
    }

    /**
     * @return string | null
     */
    public function getDealHash()
    {
        return $this->dealHash;
    }

    /**
     * @param string $dealHash
     */
    public function setDealHash(string $dealHash)
    {
        $this->dealHash = $dealHash;
    }

    /**
     * @return string | null
     */
    public function getSignedUrl()
    {
        return $this->signedUrl;
    }

    /**
     * @param string $signedUrl
     */
    public function setSignedUrl(string $signedUrl)
    {
        $this->signedUrl = $signedUrl;
    }


}