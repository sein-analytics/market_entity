<?php

namespace App\Repository\Bid;

use App\Entity\Bid;
use App\Entity\MarketUser;
use App\Entity\Pool;

interface BidInterface
{
    const BID_DEAL = "deal_id";
    const OVERRIDDEN_STATUS = 1;
    const PLACED_STATUS = 2;
    const DD_STATUS = 4;
    const LOI_STATUS_1 = 3;
    const LOI_STATUS_2 = 7;
    const MLPA_STATUS_1 = 5;
    const MLPA_STATUS_2 = 10;
    const CLOSED_STATUS = 13;
    // Any modifications to the keys below should be reflected in methods
    // that call the activity count methods below
    const DD_KEY = 'dueDiligence';
    const LOI_KEY = 'loi';
    const MLPA_KEY = 'mlpa';

    const POOL_ENTITY = Pool::class;

    const KO_ID_KEY = "id";

    const KO_BID_ID_KEY = "bidId";

    const KO_POOL_ID_KEY = "poolId";

    const KO_DEAL_ID_KEY = "dealId";

    const DD_BID_REQUESTS_COLLECTION_NAME = "bid_requests";

    const DD_BID_REQUESTEDS_LOANS_COLLECTION_NAME = "requested_loans";

    const DD_BID_REQUESTS_REQUEST_KEY = "request";

    const DD_REQUESTED_LOANS_REQUEST_ID_KEY = "requestId";

    const DD_REQUESTED_LOANS_RESOLVED_KEY = "resolved";

    const DD_REQUESTED_LOANS_ALL_RESOLVED_KEY = "allResolved";

    const DD_BIDH_HISTORY_REPLIES_KEY = "replies";

    const DD_BID_HISTORY_LOAN_ITEM_KEY = "loan";

    const BID_QRY_STATUS_ID_KEY = "status_id";

    const BID_STATUS_UPDATE_ID_MAP = [
        self::OVERRIDDEN_STATUS => self::LOI_STATUS_2,
        self::PLACED_STATUS => self::LOI_STATUS_2,
        self::LOI_STATUS_2 => self::DD_STATUS,
        self::DD_STATUS => self::MLPA_STATUS_2,
        self::MLPA_STATUS_2 => self::CLOSED_STATUS,
    ];

}