<?php
namespace App\Repository\Community;
interface CommunityInterface
{
    const COMM_CLOSE_STATUS_STR_ARR = "12, 13";

    const COMM_ALL_STATUS_STR_ARR = "1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13";

    const BUYER_ROLES_STR_ARR = '2, 4';

    const SELLER_ROLES_STR_ARR = '2, 3';

    const COMM_PROFILES_KEY = 'profiles';

    const COMM_BUYERS_KEY = 'buyers';

    const COMM_SELLERS_KEY = 'sellers';

    const COMM_COMMUNITY_KEY = 'community';

    const COMM_DB_ID_KEY = 'id';

    const COMM_DB_OWNER_KEY = 'owner';

    const COMM_DB_NAME_KEY = 'name';

    const COMM_DB_DES_KEY = 'description';

    const COMM_DB_DATE_KEY = 'date_created';

    const COMM_DB_PRMRY_KEY = 'is_primary_group';

    const COMM_DB_AVATAR_KEY = 'avatar';

    const COMM_DB_UUID_KEY = 'uuid';

    //const COMM_INSERT_ARRAY = [];
}