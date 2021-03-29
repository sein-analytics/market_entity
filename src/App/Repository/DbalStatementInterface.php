<?php


namespace App\Repository;


interface DbalStatementInterface
{
    const EXECUTE_MTHD = 'execute';

    const FETCH_ONE_MTHD = 'fetchOne';

    const FETCH_ASSO_MTHD = 'fetchAssociative';

    const FETCH_ALL_ASSO_MTHD = 'fetchAllAssociative';

    const FETCH_ALL_KEY_VAL_MTHD = 'fetchAllKeyValue';

    const FETCH_ALL_ASSO_IND_MTHD = 'fetchAllAssociativeIndexed';

    const QUERY_JUST_ID = 'id';

    const QUERY_ALL = '*';

    const UUID_COND = 'uuid';

    const USER_ID_COND = 'user_id';

}