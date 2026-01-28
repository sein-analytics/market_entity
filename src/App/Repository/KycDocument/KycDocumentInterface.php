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

    const KD_QRY_CONTRACT_STATUS_ID_KEY = 'contract_status_id';

    const KD_QRY_CONTRACT_TYPE_ID_KEY = 'contract_type_id';

    const KD_QRY_DATE_KEY = 'date';

    const KD_QRY_FILE_NAME = 'file_name';

    const KD_QRY_CONTRACT_SIGNATURE_ID_KEY = 'contract_signature_id';

    const KD_QRY_ASSET_ID_KEY = 'asset_id';

    const KD_QRY_SECURE_URL_KEY = 'secure_url';

    const KD_QRY_KYC_DOC_REQUEST_ID_KEY = 'kyc_doc_request_id';

    const KD_ISSUER_ID_KEY = 'issuerId';

    const KD_USER_ID_KEY = 'userId';

    const KD_COMMUNITY_USER_ID_KEY = 'communityUserId';

    const KD_COMMUNITY_ISSUER_ID_KEY = 'communityIssuerId';

    const KD_ASSET_TYPE_ID = 'kycAssetTypeId';

    const KD_KYC_TYPE_KEY = 'kycTypeId';

    const KD_SENDER_SIGNATURE_KEY = 'senderSignature';

    const KD_RECEIVER_SIGNATURE_KEY = 'receiverSignature';

    const KD_DOCUMENTS_API_KEY = 'documents';

    const KD_DEALS_API_KEY = 'deals';

    const KD_REQUESTS_API_KEY = 'requests';

    const KD_ISSUER_PARAM_API_KEY = 'issuer';

    const KD_ASSET_TYPE_ID_KEY = 'assetTypeId';

    const KD_DATE_KEY = 'date';

    const KD_REQ_QRY_DESCRIPTION_KEY = 'description';

    const KD_REQ_QRY_STATUS_ID_KEY = 'kyc_doc_request_status_id';

    const KD_CONTRACT_STATUS_ID_KEY = 'contractStatusId';

    const KD_ALLOW_DOC_SIGN_KEY = 'allowDocSign';

    const KD_REQUEST_ID_KEY = 'requestId';

    const KD_DOCUMENT_REQUEST_ID = 'documentRequestId';

    const KD_FILE_NAME_KEY = 'fileName';

    const KD_USER_KEY = 'user';

    const KD_ISSUER_KEY = 'issuer';

    const KD_COMMUNITY_USER_KEY = 'communityUser';

    const KD_COMMUNITY_ISSUER_KEY = 'communityIssuer';

    const KD_INFO_KEY = 'info';

    const KD_ADDITIONAL_INFO_KEY = 'additionalInfo';

    const KD_DOCUMENT_ID_KEY = 'kycDocumentId';

    const KD_DEAL_FILE_ID_KEY = 'dealFileId';

    const KD_DOC_REQUEST_ID_KEY = 'kycDocRequestId';

    const KYC_TYPE_FINANCIAL_ID = 1;
    
    const KYC_TYPE_SERVICING_ID = 2;

    const KYC_TYPE_COLLECTION_ID = 3;

    const KYC_TYPE_CONSUMER_ID = 4;

    const KYC_TYPE_UNDERWRITING_ID = 5;

    const KYC_TYPE_RISK_POLICIES_ID = 6;
    
    const KYC_TYPE_INSURANCE_ID = 7;

    const KYC_TYPE_NDA_ID = 8;
    
    const KYC_TYPE_LOI_ID = 9;

    const KYC_TYPE_LPA_ID = 10;

    const KYC_TYPE_GENERAL_ID = 11;

    const DOC_TYPE_LPA_ID = 7;

    const DOC_TYPE_LOI_ID = 6;

    const DOC_TYPE_NDA_ID = 10;

    const KYC_SIGN_ACTION = 'sign';

    const KT_TYPE_KEY = 'type';

    const KR_STATUS_OPEN_ID = 1;

    const KR_STATUS_ACCESS_GRANTED_ID = 2;

    const KR_STATUS_ACCESS_REVOKED_ID = 3;
    
    const KR_STATUS_RESOLVED_ID = 4;

    const KD_CONTRACT_STATUS_ID_MAPPER = [
        self::KD_QRY_SENDER_SIGNATURE_KEY => 2,
        self::KD_QRY_RECEIVER_SIGNATURE_KEY => 4
    ];

    const KD_TYPE_NO_ASSET_ID_MAP = [
        self::KYC_TYPE_NDA_ID => null,
        self::KYC_TYPE_GENERAL_ID => null
    ];

    const DOC_TYPE_KYC_TYPE_MAP = [
        self::DOC_TYPE_NDA_ID => self::KYC_TYPE_NDA_ID,
        self::DOC_TYPE_LOI_ID => self::KYC_TYPE_LOI_ID,
        self::DOC_TYPE_LPA_ID => self::KYC_TYPE_LPA_ID
    ];

    const KYC_TYPE_DOC_TYPE_MAP = [
        self::KYC_TYPE_NDA_ID => self::DOC_TYPE_NDA_ID,
        self::KYC_TYPE_LOI_ID => self::DOC_TYPE_LOI_ID,
        self::KYC_TYPE_LPA_ID => self::DOC_TYPE_LPA_ID,
    ];

    const KYC_TYPES_IDS_ACTIONS = [
        self::KYC_TYPE_FINANCIAL_ID => null,
        self::KYC_TYPE_SERVICING_ID => null,
        self::KYC_TYPE_COLLECTION_ID => null,
        self::KYC_TYPE_CONSUMER_ID => null,
        self::KYC_TYPE_UNDERWRITING_ID => null,
        self::KYC_TYPE_RISK_POLICIES_ID => null,
        self::KYC_TYPE_INSURANCE_ID => null,
        self::KYC_TYPE_NDA_ID => self::KYC_SIGN_ACTION,
        self::KYC_TYPE_LOI_ID => self::KYC_SIGN_ACTION,
        self::KYC_TYPE_LPA_ID => self::KYC_SIGN_ACTION,
        self::KYC_TYPE_GENERAL_ID => null,
    ];
    

    const ASSET_TYPE_KYC_TYPE_EXCLUSION_MAP = [
        0 => [
            self::KYC_TYPE_LOI_ID, 
            self::KYC_TYPE_LPA_ID
        ],
        1 => [],
        2 => [],
        3 => [],
        4 => [],
        5 => [],
    ];

    const DEAL_KYC_TYPES_IDS = [ self::KYC_TYPE_NDA_ID, self::KYC_TYPE_LOI_ID, self::KYC_TYPE_LPA_ID ];

    const BID_KYC_TYPES_IDS = [ self::KYC_TYPE_LOI_ID, self::KYC_TYPE_LPA_ID ];

}