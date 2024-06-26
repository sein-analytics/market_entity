<?php

namespace App\Repository\KycDocument;

interface KycDocumentInterface
{

    const KD_QRY_ISSUER_ID_KEY = 'issuer_id';

    const KD_QRY_USER_ID_KEY = 'user_id';

    const KD_QRY_COMMUNITY_USER_ID_KEY = 'community_user_id';

    const KD_QRY_COMMUNITY_ISSUER_ID_KEY = 'community_issuer_id';

    const KD_QRY_ASSET_TYPE_ID = 'kyc_asset_type_id';

    const KD_QRY_KYC_TYPE_KEY = 'kyc_type_id';

    const KD_QRY_SENDER_SIGNATURE_KEY = 'sender_signature';

    const KD_QRY_RECEIVER_SIGNATURE_KEY = 'receiver_signature';

    const KD_QRY_DATE_KEY = 'date';

    const KD_QRY_FILE_NAME = 'file_name';

    const KD_ISSUER_ID_KEY = 'issuerId';

    const KD_USER_ID_KEY = 'userId';

    const KD_COMMUNITY_USER_ID_KEY = 'communityUserId';

    const KD_COMMUNITY_ISSUER_ID_KEY = 'communityIssuerId';

    const KD_ASSET_TYPE_ID = 'kycAssetTypeId';

    const KD_KYC_TYPE_KEY = 'kycTypeId';

    const KD_SENDER_SIGNATURE_KEY = 'senderSignature';

    const KD_RECEIVER_SIGNATURE_KEY = 'receiverSignature';

    const KD_DOCUMENTS_API_KEY = 'documents';

    const KD_REQUESTS_API_KEY = 'requests';

    const KD_ISSUER_PARAM_API_KEY = 'issuer';

    const KD_ASSET_TYPE_ID_KEY = 'assetTypeId';

    const KD_DATE_KEY = 'date';

    const KD_REQ_QRY_DESCRIPTION_KEY = 'description';

    const KD_CONTRACT_STATUS_ID_MAPPER = [
        self::KD_QRY_SENDER_SIGNATURE_KEY => 2,
        self::KD_QRY_RECEIVER_SIGNATURE_KEY => 4
    ];

    const KD_TYPE_NO_ASSET_ID_MAP = [
        1 => null,
        7 => null,
        8 => null
    ];

}