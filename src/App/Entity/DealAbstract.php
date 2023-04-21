<?php
namespace App\Entity;
use Doctrine\ORM\Mapping\ChangeTrackingPolicy;

use Doctrine\ORM\Mapping as ORM;

abstract class DealAbstract extends DomainObject
{
    const PLAIN_AUCTION             = "AUCTION";

    const DUTCH_AUCTION             = "DUTCH";

    const ASSET_AUTO                = "AUTO";

    const ASSET_RESIDENTIAL         = "RESIDENTIAL";

    const ASSET_COMMERCIAL          = "COMMERCIAL";

    const ASSET_CREDITCARD          = "CREDITCARD";

    const ASSET_CRE                 = "CRE";

    const ASSET_HOMEEQUITY          = "HOMEEQUITY";

    const ASSET_EQUIPMENTLEASING    = "EQUIPMENTLEASING";

    const ALL_OR_NONE               = 'ALL';

    const SYNDICATION               = 'SYNDICATION';

    protected static array $auctionTypes = array(
        self::PLAIN_AUCTION       => "\\App\\Entity\\AuctionType\\Standard",
        self::DUTCH_AUCTION       => "\\App\\Entity\\AuctionType\\Dutch",
    );

    protected static array $bidTypes = array(
        self::ALL_OR_NONE       => "\\App\\Entity\\BidType\\AllOrNone",
        self::SYNDICATION       => "\\App\\Entity\\BidType\\Syndication",
    );

    protected static array $assetTypes = array(
        self::ASSET_AUTO            => "\\App\\Entity\\AssetType\\Auto",
        self::ASSET_RESIDENTIAL     => "\\App\\Entity\\AssetType\\Residential",
        self::ASSET_COMMERCIAL      => "\\App\\Entity\\AssetType\\Commercial",
        self::ASSET_CREDITCARD      => "\\App\\Entity\\AssetType\\CreditCard",
        self::ASSET_CRE             => "\\App\\Entity\\AssetType\\Cre",
        self::ASSET_HOMEEQUITY      => "\\App\\Entity\\AssetType\\HomeEquity",
        self::ASSET_EQUIPMENTLEASING => "\\App\\Entity\\AssetType\\Equipment"
    );

    protected $auctionType;

    protected $assetType;

    protected $bidType;

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @return array
     */
    public static function getAuctionTypes():array
    {
        return self::$auctionTypes;
    }

    /**
     * @return array
     */
    public static function getAssetTypes():array
    {
        return self::$assetTypes;
    }

    /**
     * @return array
     */
    public static function getBidTypes():array
    {
        return self::$bidTypes;
    }

    /**
     * @param $auctionType
     * @throws \Exception
     */
    public function setAuctionType($auctionType):void
    {
        if(!array_key_exists(strtoupper($auctionType), self::$auctionTypes)){
            throw new \Exception("Auction class type: $auctionType does not exist");
        }
        $this->auctionType = $auctionType;
    }


    /**
     * @param $assetType
     * @throws \Exception
     */
    public function setAssetType($assetType):void
    {
        if(!array_key_exists(strtoupper($assetType), self::$assetTypes)){
            throw new \Exception("Asset class type: $assetType does not exist");
        }
        $this->assetType = $assetType;
    }

    /**
     * @return array
     */
    public function getBidType()
    {
        return $this->bidType;
    }

    /**
     * @param $bidType
     * @throws \Exception
     */
    public function setBidType($bidType)
    {
        if(!array_key_exists(strtoupper($bidType), self::$bidTypes)){
            throw new \Exception("Bid class type: $bidType does not exist");
        }
        $this->bidType = $bidType;
    }
}