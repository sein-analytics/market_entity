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

    const COMM_GROUPS_KEY = 'communityGroups';

    const COMM_DB_ID_KEY = 'id';

    const COMM_DB_OWNER_KEY = 'owner';

    const COMM_DB_NAME_KEY = 'name';

    const COMM_DB_DES_KEY = 'description';

    const COMM_DB_DATE_KEY = 'date_created';

    const COMM_DB_PRMRY_KEY = 'is_primary_group';

    const COMM_DB_AVATAR_KEY = 'avatar';

    const COMM_DB_UUID_KEY = 'uuid';

    const FETCH_COMM_GROUP_MTHD = 'fetchUserCommunities';

    const FETCH_COMM_PROFILES_MTHD = 'fetchUserCommunityProfiles';

    const FETCH_COMM_GROUP_USER_IDS_MTHD = 'fetchCommunityGroupUserIds';

    const FETCH_COMM_SPECIALITIES_MTHD = 'fetchMarketSpecialities';

    const FETCH_SPECIALITIES_SQL = 'SELECT uuid, speciality AS label FROM Speciality';

    const COMM_INV_DB_COMM_ID_KEY = 'community_id';

    const COMM_INV_DB_STATUS_ID_KEY = 'status_id';

    const COMM_INV_DB_USER_ID_KEY = 'user_id';

    const COMM_INV_DB_INVITE_KEY = 'invite_date';

    const COMM_INV_DB_EMAIL_KEY = 'email';

    const COMM_INV_DB_UUID_KEY = 'uuid';

    const RECENT_PURCHASES_JSON_KEY = 'recentPurchases';

    const RECENT_SALES_JSON_KEY = 'recentSales';

    const CALL_REPORT_JSON_KEY = 'callReportData';

    const PROFILE_USER_JSON_KEY = 'profileUser';

    //const COMM_INSERT_ARRAY = [];
}