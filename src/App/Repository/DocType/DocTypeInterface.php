<?php
namespace App\Repository\DocType;

interface DocTypeInterface
{
    const DEFAULT_DOC_TYPE_KEY = self::OTHER_KEY;

    const DEFAULT_DOC_TYPE_ID = 9;

    const INCOME_CREDIT_KEY = 'income-credit';

    const ASSET_VALUE_KEY = 'appraisal';

    const DEED_NOTE_KEY = 'deed-note';

    const ORIG_CLOSING_KEY = 'origination-closing';

    const TITLE_SEARCH_KEY = 'title-search';

    const LOI_KEY = 'loi';

    const PURCHASE_CONTRACT_KEY = 'mlpa';

    const ANCILLARY_KEY  = 'ancillary';

    const NDA_KEY = 'nda';

    const OTHER_KEY  = 'KEY';

    const DC_DOC_TYPE_ID_KEY = 'docTypeId';

    const DC_INCOME_CREDIT_ID = 1;

    const DC_APPRAISAL_ID = 2;

    const DC_MORTGAGE_NOTE_ID = 3;

    const DC_ORIG_CLOSING_ID = 4;

    const DC_TITLE_SEARCH_ID = 5;

    const DC_LOI_ID = 6;

    const DC_MLPA_ID = 7;

    const DC_ANCILLIARY_ID = 8;

    const DC_OTHER_ID = 9;

    const DC_NDA_ID = 10;

    const DOC_TYPE_KEY_TO_ID = [
        self::INCOME_CREDIT_KEY => self::DC_INCOME_CREDIT_ID,
        self::ASSET_VALUE_KEY => self::DC_APPRAISAL_ID,
        self::DEED_NOTE_KEY => self::DC_MORTGAGE_NOTE_ID,
        self::ORIG_CLOSING_KEY => self::DC_ORIG_CLOSING_ID,
        self::TITLE_SEARCH_KEY => self::DC_TITLE_SEARCH_ID,
        self::LOI_KEY => self::DC_LOI_ID,
        self::PURCHASE_CONTRACT_KEY => self::DC_MLPA_ID,
        self::ANCILLARY_KEY => self::DC_ANCILLIARY_ID,
        self::OTHER_KEY => self::DEFAULT_DOC_TYPE_ID,
        self::NDA_KEY => self::DC_NDA_ID
    ];

    const DOC_TYPE_KEY_TO_BID_STATUS_IDS = [
        self::LOI_KEY => [1, 2],
        self::PURCHASE_CONTRACT_KEY => [4]
    ];

    const DOC_TYPE_ID_TO_KEY = [
        self::DC_INCOME_CREDIT_ID => self::INCOME_CREDIT_KEY,
        self::DC_APPRAISAL_ID => self::ASSET_VALUE_KEY,
        self::DC_MORTGAGE_NOTE_ID => self::DEED_NOTE_KEY,
        self::DC_ORIG_CLOSING_ID => self::ORIG_CLOSING_KEY,
        self::DC_TITLE_SEARCH_ID => self::TITLE_SEARCH_KEY,
        self::DC_LOI_ID => self::LOI_KEY,
        self::DC_MLPA_ID => self::PURCHASE_CONTRACT_KEY,
        self::DC_ANCILLIARY_ID => self::ANCILLARY_KEY,
        self::DEFAULT_DOC_TYPE_ID => self::OTHER_KEY,
        self::DC_NDA_ID => self::NDA_KEY,
    ];

}