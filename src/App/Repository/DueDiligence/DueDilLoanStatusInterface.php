<?php

namespace App\Repository\DueDiligence;

interface DueDilLoanStatusInterface
{
    const DDLS_QRY_ID_KEY = 'id';

    const DDLS_QRY_DD_ID_KEY = 'dd_id';

    const DDLS_QRY_LOAN_ID_KEY = 'ln_id';

    const DDLS_QRY_STATUS_ID_KEY = 'status_id';

    const DDLS_QRY_LOGGER_KEY = 'logger';

    const LOG_ACTION_KEY = "action";

    const LOG_DATE_KEY = "date";

    const LOG_FILES_KEY = "files";

    const LOG_USER_ID_KEY = "userId";

    const LOG_TEMP_KEY = "temp";

    const BASE_LOGGER_ARRAY = [
        self::LOG_ACTION_KEY => null,
        self::LOG_DATE_KEY => null,
        self::LOG_USER_ID_KEY => null,
        self::LOG_FILES_KEY => [
            self::LOG_TEMP_KEY => []
        ]
    ];

    const DD_LN_OPEN = 1;

    const DD_LN_FINISH = 2;

    const DD_LN_DECLINE = 3;

    const DD_LN_DELIVER = 4;

    const DD_LN_ACCEPT = 5;

    const DD_LN_REJECT = 6;

    const DD_LN_STATUS_ARRAY = [
        self::DD_LN_OPEN,
        self::DD_LN_FINISH,
        self::DD_LN_DECLINE,
        self::DD_LN_DELIVER,
        self::DD_LN_ACCEPT,
        self::DD_LN_REJECT
    ];
}