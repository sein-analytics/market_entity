<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="KycDocRequest")
 */
class KycDocRequest
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @var int
     **/
    protected int $id;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\MarketUser")
     * @ORM\JoinColumn(name="community_user_id", referencedColumnName="id", nullable=false)
     */
    protected MarketUser $communityUser;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\Issuer")
     * @ORM\JoinColumn(name="community_issuer_id", referencedColumnName="id", nullable=false)
     */
    protected Issuer $communityIssuer;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\MarketUser")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false)
     */
    protected MarketUser $user;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\Issuer")
     * @ORM\JoinColumn(name="issuer_id", referencedColumnName="id", nullable=false)
     */
    protected Issuer $issuer;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\KycType")
     * @ORM\JoinColumn(name="kyc_type_id", referencedColumnName="id", nullable=false)
     */
    protected KycType $kycType;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\DealAsset")
     * @ORM\JoinColumn(name="kyc_asset_type_id", referencedColumnName="id", nullable=true)
     */
    protected ?DealAsset $assetType;

    /**
     * @ORM\Column(type="string", nullable=false)
     * @var string
     */
    protected string $description = '';

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\Bid")
     * @ORM\JoinColumn(name="bid_id", referencedColumnName="id", nullable=true)
     */
    protected ?Bid $bid;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @var \DateTime|null
     **/
    protected $date = null;

    function __construct()
    {
        $this->issuer = new Issuer();
        $this->user = new MarketUser();
        $this->communityIssuer = new Issuer();
        $this->communityUser = new MarketUser();
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return Issuer
     */
    public function getIssuer(): Issuer
    {
        return $this->issuer;
    }

    /**
     * @param Issuer $issuer
     */
    public function setIssuer(Issuer $issuer): void
    {
        $this->issuer = $issuer;
    }

    /**
     * @return MarketUser
     */
    public function getUser(): MarketUser
    {
        return $this->user;
    }

    /**
     * @param MarketUser $user
     */
    public function setUser(MarketUser $user): void
    {
        $this->user = $user;
    }

    /**
     * @return MarketUser|null
     */
    public function getCommunityUser(): MarketUser|null
    {
        return $this->communityUser;
    }

    /**
     * @param MarketUser $communityUser
     */
    public function setCommunityUser(MarketUser $communityUser): void
    {
        $this->communityUser = $communityUser;
    }

    /**
     * @return Issuer|null
     */
    public function getCommunityIssuer(): Issuer|null
    {
        return $this->communityIssuer;
    }

    /**
     * @param Issuer $communityIssuer
     */
    public function setCommunityIssuer(Issuer $communityIssuer): void
    {
        $this->communityIssuer = $communityIssuer;
    }

    /**
     * @return DealAsset|null
     */
    public function getAssetType(): DealAsset|null
    {
        return $this->assetType;
    }

    /**
     * @param DealAsset $assetType
     */
    public function setAssetType(DealAsset $assetType): void
    {
        $this->assetType = $assetType;
    }

    /**
     * @return KycType
     */
    public function getKycType(): KycType
    {
        return $this->kycType;
    }

    /**
     * @param KycType $kycType
     */
    public function setKycType(KycType $kycType): void
    {
        $this->kycType = $kycType;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return \DateTime
     */
    public function getDate(): ?\DateTime
    {
        return $this->date;
    }

    /**
     * @param \DateTime $date
     */
    public function setDate(\DateTime $date)
    {
        $this->date = $date;
    }

    /**
     * @return Bid|null
     */
    public function getBid(): Bid|null
    {
        return $this->bid;
    }

    /**
     * @param Bid $Bid
     */
    public function setBid(Bid $bid): void
    {
        $this->bid = $bid;
    }

}
