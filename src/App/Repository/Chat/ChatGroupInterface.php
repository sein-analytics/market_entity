<?php


namespace App\Repository\Chat;


interface ChatGroupInterface
{
    const DEFAULT_KEY = 'default';

    const COL_NAME_KEY = 'key';

    const COL_METHOD_KEY = 'method';

    const METHOD_CLASS_PATH_KEY = 'path';

    CONST GROUP_ID_KEY = 'id';

    const GROUP_USER_ID_KEY = 'user_id';

    const GROUP_UUID_KEY = 'uuid';

    const GROUP_NAME_KEY = 'group_name';

    const GROUP_IS_PRIVATE_KEY = 'is_private';

    const GROUP_COMM_ID_KEY = 'community_id';

    const GROUP_IMAGE_URL_KEY = 'image_url';

    const GROUP_TRACKER_ID_KEY = 'tracker_id';

    const STR_CLASS_PATH = 'Illuminate\Support\Str';

    const CHAT_TRACKER_CLASS_PATH = 'App\Repository\ChatTracker';

    const SQL_KEY = 'sql-key';

    const GROUP_ID_VAR = [
        self::DEFAULT_KEY => null,
        self::COL_NAME_KEY => self::GROUP_ID_KEY
    ];

    const GROUP_USER_ID_VAR = [
        self::COL_NAME_KEY => self::GROUP_USER_ID_KEY
    ];

    const GROUP_UUID_VAR = [
        self::COL_NAME_KEY => self::GROUP_UUID_KEY,
        self::COL_METHOD_KEY => 'Str',
        self::METHOD_CLASS_PATH_KEY => self::STR_CLASS_PATH
    ];

    const GROUP_NAME_VAR = [
        self::DEFAULT_KEY => 'group_chat',
        self::COL_NAME_KEY => self::GROUP_NAME_KEY
    ];

    const GROUP_ACCESS_IND_VAR = [
        self::DEFAULT_KEY => 1,
        self::COL_NAME_KEY => self::GROUP_IS_PRIVATE_KEY
    ];

    const GROUP_COMM_ID_VAR = [
        self::DEFAULT_KEY => null,
        self::COL_NAME_KEY => self::GROUP_COMM_ID_KEY
    ];

    const GROUP_IMG_UTL_VAR = [
        self::DEFAULT_KEY => null,
        self::COL_NAME_KEY => self::GROUP_IMAGE_URL_KEY
    ];

    const GROUP_TRACKER_ID_VAR = [
        self::COL_NAME_KEY => self::GROUP_TRACKER_ID_KEY,
        self::DEFAULT_KEY => null,
        self::COL_METHOD_KEY => 'addNewChatTrackerForUuid',
        self::METHOD_CLASS_PATH_KEY => self::CHAT_TRACKER_CLASS_PATH
    ];

    const GROUP_COLS_MAPPER = [
        self::GROUP_ID_KEY => self::GROUP_ID_VAR,
        self::GROUP_USER_ID_KEY => self::GROUP_USER_ID_VAR,
        self::GROUP_UUID_KEY => self::GROUP_UUID_VAR,
        self::GROUP_NAME_KEY => self::GROUP_NAME_VAR,
        self::GROUP_IS_PRIVATE_KEY => self::GROUP_ACCESS_IND_VAR,
        self::GROUP_COMM_ID_KEY => self::GROUP_COMM_ID_VAR,
        self::GROUP_IMAGE_URL_KEY => self::GROUP_IMG_UTL_VAR,
        self::GROUP_TRACKER_ID_KEY => self::GROUP_TRACKER_ID_VAR,
    ];

    const BASE_INSERT_ARR = [
        self::GROUP_ID_KEY => null,
        self::GROUP_USER_ID_KEY => null,
        self::GROUP_UUID_KEY => null,
        self::GROUP_NAME_KEY => null,
        self::GROUP_IS_PRIVATE_KEY => null,
        self::GROUP_COMM_ID_KEY => null,
        self::GROUP_IMAGE_URL_KEY => null,
        self::GROUP_TRACKER_ID_KEY => null,
    ];

    const GROUP_CHAT_UPDATES_SQL_BY_UUID = [
        self::GROUP_NAME_KEY => 'UPDATE ChatGroup SET group_name = ? WHERE uuid = ?',
        self::GROUP_IS_PRIVATE_KEY => 'UPDATE ChatGroup SET is_private = ? WHERE uuid = ?',
        self::GROUP_COMM_ID_KEY => 'UPDATE ChatGroup SET community_id = ? WHERE uuid = ?',
        self::GROUP_IMAGE_URL_KEY => 'UPDATE ChatGroup SET image_url = ? WHERE uuid = ?',
        self::GROUP_TRACKER_ID_KEY => 'UPDATE ChatGroup Set tracker_id =? WHERE uuid = ?'
    ];

    const GROUP_CHAT_UPDATES_SQL_BY_ID = [
        self::GROUP_NAME_KEY => 'UPDATE ChatGroup SET group_name = ? WHERE id = ?',
        self::GROUP_IS_PRIVATE_KEY => 'UPDATE ChatGroup SET is_private = ? WHERE id = ?',
        self::GROUP_COMM_ID_KEY => 'UPDATE ChatGroup SET community_id = ? WHERE id = ?',
        self::GROUP_IMAGE_URL_KEY => 'UPDATE ChatGroup SET image_url = ? WHERE id = ?',
        self::GROUP_TRACKER_ID_KEY => 'UPDATE ChatGroup Set tracker_id =? WHERE id = ?'
    ];

    const GROUP_ID_BY_USER_ID = 'groupIdByUserId';

    const GROUP_ID_BY_UUID = 'groupIdByUuid';

    const GROUP_ALL_BY_USER_ID = 'groupAllByUserId';

    const GROUP_ALL_BY_UUID = 'groupAllByUuid';

    const GROUP_MEMBERS_IDS = 'groupMemberIdsByGroupId';

    const GROUP_TRACKER_ID_BY_GROUP_ID = 'chatGroupTrackerIdByGroupId';

    const GROUP_DATA_BY_GROUP_ID = 'groupDataByGroupId';

    const FETCH_CHAT_GROUP_DATA_SQL = [
        self::GROUP_ID_BY_USER_ID => 'SELECT id FROM ChatGroup WHERE user_id = ?',
        self::GROUP_ID_BY_UUID => 'SELECT id FROM ChatGroup WHERE uuid = ?',
        self::GROUP_ALL_BY_USER_ID => 'SELECT * FROM ChatGroup WHERE user_id = ?',
        self::GROUP_ALL_BY_UUID => 'SELECT * FROM ChatGroup WHERE uuid = ?'
    ];

    const FETCH_CHAT_GROUP_DATA_BY_GROUP_ID_SQL = [
        self::GROUP_TRACKER_ID_BY_GROUP_ID =>
            [
                self::SQL_KEY => 'SELECT tracker_id FROM ChatGroup WHERE id = ?',
                self::COL_METHOD_KEY => 'fetchOne'
            ],
        self::GROUP_DATA_BY_GROUP_ID =>
            [
                self::SQL_KEY => 'SELECT * FROM ChatGroup WHERE id = ?',
                self::COL_METHOD_KEY => 'fetchAssociative'
            ]
    ];
}