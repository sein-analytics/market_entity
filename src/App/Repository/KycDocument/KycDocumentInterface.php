<?php

namespace App\Repository\KycDocument;

interface KycDocumentInterface
{

    const KD_QRY_ISSUER_ID_KEY = 'issuer_id';

    const KD_QRY_USER_ID_KEY = 'user_id';

    const KD_QRY_COMMUNITY_USER_ID_KEY = 'community_user_id';

    const KD_QRY_COMMUNITY_ISSUER_ID_KEY = 'community_issuer_id'; 

    const KD_QRY_ASSET_TYPE_ID = 'kyc_asset_type_id';

    const KD_ISSUER_ID_KEY = 'issuerId';

    const KD_USER_ID_KEY = 'userId';

    const KD_COMMUNITY_USER_ID_KEY = 'communityUserId';

    const KD_COMMUNITY_ISSUER_ID_KEY = 'communityIssuerId';

    const KD_ASSET_TYPE_ID = 'kycAssetTypeId';

}