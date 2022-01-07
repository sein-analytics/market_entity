<?php


namespace App\Repository;


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

}