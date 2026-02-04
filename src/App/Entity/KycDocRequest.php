<?php

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'KycDocRequest')]
#[ORM\Entity(repositoryClass: \App\Repository\KycDocRequest::class)]
class KycDocRequest
{

    /**
     * @var int
     **/
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    protected int $id;

    #[ORM\JoinColumn(name: 'community_user_id', referencedColumnName: 'id', nullable: false)]
    #[ORM\ManyToOne(targetEntity:  MarketUser::class)]
    protected MarketUser $communityUser;

    #[ORM\JoinColumn(name: 'community_issuer_id', referencedColumnName: 'id', nullable: false)]
    #[ORM\ManyToOne(targetEntity:  Issuer::class)]
    protected Issuer $communityIssuer;

    #[ORM\JoinColumn(name: 'user_id', referencedColumnName: 'id', nullable: true)]
    #[ORM\ManyToOne(targetEntity:  MarketUser::class)]
    protected ?MarketUser $user;

    #[ORM\JoinColumn(name: 'issuer_id', referencedColumnName: 'id', nullable: false)]
    #[ORM\ManyToOne(targetEntity:  Issuer::class)]
    protected Issuer $issuer;

    #[ORM\JoinColumn(name: 'kyc_type_id', referencedColumnName: 'id', nullable: true)]
    #[ORM\ManyToOne(targetEntity:  KycType::class)]
    protected ?KycType $kycType;

    #[ORM\JoinColumn(name: 'kyc_asset_type_id', referencedColumnName: 'id', nullable: true)]
    #[ORM\ManyToOne(targetEntity:  DealAsset::class)]
    protected ?DealAsset $assetType;

    /**
     * @var string|null
     */
    #[ORM\Column(type: 'string', nullable: true)]
    protected ?string $description = null;

    #[ORM\JoinColumn(name: 'bid_id', referencedColumnName: 'id', nullable: true)]
    #[ORM\ManyToOne(targetEntity:  Bid::class)]
    protected ?Bid $bid;

    #[ORM\JoinColumn(name: 'deal_id', referencedColumnName: 'id', nullable: true)]
    #[ORM\ManyToOne(targetEntity:  Deal::class)]
    protected ?Deal $deal;

    /**
     * @var DateTime|null
     **/
    #[ORM\Column(type: 'datetime', nullable: true)]
    protected $date = null;

    #[ORM\JoinColumn(name: 'kyc_doc_request_status_id', referencedColumnName: 'id', nullable: true)]
    #[ORM\ManyToOne(targetEntity:  KycDocRequestStatus::class)]
    protected ?KycDocRequestStatus $status;

    function __construct()
    {
        $this->issuer = new Issuer();
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
     * @return MarketUser|null
     */
    public function getUser(): MarketUser|null
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
     * @return KycType|null
     */
    public function getKycType(): KycType|null
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
     * @return string|null
     */
    public function getDescription(): string|null
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
     * @return DateTime
     */
    public function getDate(): ?DateTime
    {
        return $this->date;
    }

    /**
     * @param DateTime $date
     */
    public function setDate(DateTime $date)
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
    
    /**
     * @return Deal|null
     */
    public function getDeal(): Deal|null
    {
        return $this->deal;
    }

    /**
     * @param Deal $deal
     */
    public function setDeal(Deal $deal): void
    {
        $this->deal = $deal;
    }
    
    /**
     * @return KycDocRequestStatus|null
     */
    public function getStatus(): KycDocRequestStatus|null
    {
        return $this->status;
    }

    /**
     * @param KycDocRequestStatus $status
     */
    public function setStatus(KycDocRequestStatus $status): void
    {
        $this->status = $status;
    }

}
