<?php

namespace App\Repository\DealFile;

interface DealFileInterface
{
    const DEFAULT_VIRUS_BOOL = 0;

    const DEFAULT_SCAN_LOC = 'https://www.virustotal.com/file/0bff379d5_temp_default/analysis/1509569818/';

    const DOT_OPERATOR = '.';

    const DEFAULT_ACC_CODE = 2;

    /**
     * ToDo any changes in DealFile entity
     * props must be reflected in the interface
     * */
    const DF_ID = 'id';

    const DF_DEAL_ID = 'deal_id';

    const DF_USER_ID = 'user_id';

    const DF_LOAN_ID = 'loan_id';

    const DF_MIME_ID = 'mime_id';

    const DF_TYPE_ID = 'doc_type_id';

    const DF_FILE_NAME = 'file_name';

    const DF_FILE_SIZE = 'file_size';

    const DF_ASSET_ID = 'asset_id';

    const DF_SCAN_LOC = 'scan_location';

    const DF_VIRUS_IND = 'has_viruses';

    const DF_PUB_PATH = 'public_path';

    const DF_SIG_ID = 'signature_id';

    const DF_SIG_PATH = 'signature_path';

    const DF_ACC_MODE = 'access_id';

    const DF_COMMUNITY_USER_ID = 'community_user_id';

    const DF_CONTRACT_SIGNATURE_ID = 'contract_signature_id'; 

    const DF_DATE = 'date';

    /**
     * ToDo any changes in the DAM JSON API
     * should be reflected below
     */

    const DAM_ID_API = 'id';

    const DAM_LOAN_API = 'loanId';

    const DAM_FILE_TYPE = 'format';

    const DAM_FILE_NAME = 'original_filename';

    const DAM_FILE_SIZE = 'bytes';

    const DAM_ASSET_ID = 'asset_id';

    const DAM_PUB_PATH = 'public_id';

    const DAM_ACC_MODE = 'access_mode';

    const DAM_SECURE_URL = 'secure_url';

    const DAM_CREATED_AT = 'created_at';

    const DAM_TO_DF_ARR = [
        self::DAM_FILE_NAME => self::DF_FILE_NAME,
        self::DAM_FILE_SIZE => self::DF_FILE_SIZE,
        self::DAM_ASSET_ID => self::DF_ASSET_ID,
        self::DAM_SECURE_URL => self::DF_PUB_PATH,
        self::DAM_ACC_MODE => self::DF_ACC_MODE,
        self::DAM_LOAN_API => self::DF_LOAN_ID,
        self::DAM_FILE_TYPE => self::DF_MIME_ID,
        self::DAM_CREATED_AT => self::DF_DATE
    ];

    const BASE_INSERT_ARR = [
        self::DF_ID => null,
        self::DF_DEAL_ID => null,
        self::DF_USER_ID => null,
        self::DF_LOAN_ID => null,
        self::DF_MIME_ID => null,
        self::DF_TYPE_ID => null,
        self::DF_FILE_NAME => null,
        self::DF_FILE_SIZE => null,
        self::DF_ASSET_ID => null,
        self::DF_SCAN_LOC => self::DEFAULT_SCAN_LOC,
        self::DF_VIRUS_IND => self::DEFAULT_VIRUS_BOOL,
        self::DF_ACC_MODE => null,
        self::DF_PUB_PATH => null,
        self::DF_SIG_ID => null,
        self::DF_SIG_PATH => null,
        self::DF_COMMUNITY_USER_ID => null,
        self::DF_CONTRACT_SIGNATURE_ID => null,
        self::DF_DATE => null,
    ];
}