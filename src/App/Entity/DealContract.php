<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="\App\Repository\DealContract")
 * @ORM\Table(name="DealContract")
 */
class DealContract
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @var int
     **/
    protected int $id;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\Deal", inversedBy="contracts")
     * @ORM\JoinColumn(name="deal_id", referencedColumnName="id", nullable=false)
     */
    protected Deal $deal;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\MarketUser", inversedBy="contracts")
     * @ORM\JoinColumn(name="buyer_id", referencedColumnName="id", nullable=false)
     */
    protected MarketUser $buyer;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\ContractType")
     * @ORM\JoinColumn(name="contract_type_id", referencedColumnName="id", nullable=false)
     */
    protected ContractType $contractType;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\ContractStatus")
     * @ORM\JoinColumn(name="contract_status_id", referencedColumnName="id", nullable=false)
     */
    protected ContractStatus $contractStatus;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\DealAsset")
     * @ORM\JoinColumn(name="deal_asset_id", referencedColumnName="id", nullable=true)
     */
    protected ?DealAsset $dealAsset;

    /**
     * @ORM\Column(type="string", nullable=false)
     * @var string
     */
    protected string $assetId = '';

    /**
     * @ORM\Column(type="string", nullable=false)
     * @var string
     */
    protected string $secureUrl = '';

    function __construct()
    {
        $this->deal = new Deal();
        $this->buyer = new MarketUser();
        $this->contractType = new ContractType();
        $this->contractStatus = new ContractStatus();
    }

    /**
     * @return int
     */
    public function getId():int { return $this->id; }
    
    /**
     * @return Deal
     */
    public function getDeal():Deal { return $this->deal; }

    /**
     * @param Deal $deal
     */
    public function setDeal(Deal $deal):void { $this->deal = $deal; }

    /**
     * @return MarketUser
     */
    public function getBuyer():MarketUser { return $this->buyer; }

    /**
     * @param MarketUser $buyer
     */
    public function setBuyer(MarketUser $buyer):void { $this->deal = $buyer; }
   
    /**
     * @return ContractType
     */
    public function getContractType():ContractType { return $this->contractType; }

    /**
     * @param ContractType $contractType
     */
    public function setContractType(ContractType $contractType):void { $this->contractType = $contractType; }
    
    /**
     * @return ContractStatus
     */
    public function getContractStatus():ContractStatus { return $this->contractStatus; }

    /**
     * @param ContractStatus $contractStatus
     */
    public function setContractStatus(ContractStatus $contractStatus):void { $this->contractStatus = $contractStatus; }
    
    /**
     * @return DealAsset|null
     */
    public function getDealAsset():DealAsset|null { return $this->dealAsset; }

    /**
     * @param DealAsset $dealAsset
     */
    public function setDealAsset(DealAsset $dealAsset):void { $this->dealAsset = $dealAsset; }
    
    /**
     * @return string
     */
    public function getAssetId():string { return $this->assetId; }

    /**
     * @param string
     */
    public function setAssetId(string $assetId):void { $this->assetId = $assetId; }

    /**
     * @return string
     */
    public function getSecureUrl():string { return $this->secureUrl; }

    /**
     * @param string
     */
    public function setSecureUrl(string $secureUrl):void { $this->secureUrl = $secureUrl; }

}