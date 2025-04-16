<?php


namespace App\Repository;


use App\Entity\DueDiligenceRole;
use App\Entity\DueDiligenceStatus;
use App\Entity\DueDilReviewStatus;

interface DbalStatementInterface
{
    const COUNT_DB_KEY = 'count';

    const EXECUTE_MTHD = 'execute';

    const FETCH_ONE_MTHD = 'fetchOne';

    /**
     * @deprecated
     */
    const FETCH_ALL_MTHD = 'fetchAll';

    /**
     *@var string
     */
    const FETCH_ASSO_MTHD = 'fetchAssociative';

    const FETCH_ALL_ASSO_MTHD = 'fetchAllAssociative';

    const FETCH_NUMERIC_MTHD = 'fetchNumeric';

    const FETCH_ALL_KEY_VAL_MTHD = 'fetchAllKeyValue';

    const FETCH_ALL_ASSO_IND_MTHD = 'fetchAllAssociativeIndexed';

    const QUERY_JUST_ID = 'id';

    const QUERY_ALL = '*';

    const UUID_COND = 'uuid';

    const USER_ID_COND = 'user_id';

    const USER_ROLE_ID_COND = 'role_id';

    const USER_NAME_API_STRING = 'userName';

    const TBL_PROP_ENTITY_KEY = 'entity_name';

    const TBL_PROP_NULLABLE_KEY = 'is_nullable';

    const TBL_PROP_DEFAULT_KEY = 'default_value';

    const TBL_PROP_NONE_DEFAULT = 'None';

    const DEFAULT_START_DATE = '1970-01-01 00:00:00';

    const MKT_USER_ENTITY = \App\Entity\MarketUser::class;

    const DEAL_ENTITY = \App\Entity\Deal::class;

    const DD_ROLE_ENTITY = DueDiligenceRole::class;

    const DD_STATUS_ENTITY = DueDiligenceStatus::class;

    const DUE_DIL_ENTITY = \App\Entity\DueDiligence::class;

    const DD_ISSUE_STATUS_ENTITY = \App\Entity\DueDilIssueStatus::class;

    const DEAL_FILE_ENTITY = \App\Entity\DealFile::class;

    const MSG_PRIORITY_ENTITY = \App\Entity\MessagePriority::class;

    const LOAN_ENTITY = \App\Entity\Loan::class;

    const BID_ENTITY = \App\Entity\Bid::class;

    const DD_REVIEW_STATUS_ENTITY = DueDilReviewStatus::class;

    const MKT_USER_EXIST_QRY = "SELECT COUNT(id) FROM MarketUser WHERE id = ?";

    const DEAL_EXIST_QRY = "SELECT COUNT(id) FROM DeaL WHERE id = ?";

    const LAST_INSERT_ID_QRY = "SELECT LAST_INSERT_ID()";

    const PLATFORM_ADMINS_DATA = [1, 2, 26];

    const PERMISSION_DENIED_MSB = "Your user does not have permission for the requested action. Please contact Sein Analytics is you believe this is an error.";
}