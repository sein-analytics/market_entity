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

    const OTHER_KEY  = 'KEY';

    const DOC_TYPE_KEY_TO_ID = [
        self::INCOME_CREDIT_KEY => 1,
        self::ASSET_VALUE_KEY => 2,
        self::DEED_NOTE_KEY => 3,
        self::ORIG_CLOSING_KEY => 4,
        self::TITLE_SEARCH_KEY => 5,
        self::LOI_KEY => 6,
        self::PURCHASE_CONTRACT_KEY => 7,
        self::ANCILLARY_KEY => 8,
        self::OTHER_KEY => self::DEFAULT_DOC_TYPE_ID
    ];
}