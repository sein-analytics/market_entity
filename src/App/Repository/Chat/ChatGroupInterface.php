<?php


namespace App\Repository\Chat;


interface ChatGroupInterface
{
    const DEFAULT_KEY = 'default';

    const COL_NAME_KEY = 'key';

    const COL_METHOD_KEY = 'method';

    const METHOD_CLASS_PATH_KEY = 'path';

    const GROUP_ID_VAR = [
        self::DEFAULT_KEY => 'NULL',
        self::COL_NAME_KEY => 'id'
    ];

    const GROUP_USER_ID_VAR = [
        self::COL_NAME_KEY => 'user_id'
    ];

    const GROUP_UUID_VAR = [
        self::COL_NAME_KEY => 'uuid',
        self::COL_METHOD_KEY => 'Str',
        self::METHOD_CLASS_PATH_KEY => 'Illuminate\Support\Str'
    ];

    const GROUP_NAME_VAR = [
        self::DEFAULT_KEY => 'group_chat',
        self::COL_NAME_KEY => 'group_name'
    ];

    const GROUP_ACCESS_IND_VAR = [
        self::DEFAULT_KEY => 0,
        self::COL_NAME_KEY => 'is_private'
    ];

    const GROUP_COMM_ID_VAR = [
        self::DEFAULT_KEY => 'NULL',
        self::COL_NAME_KEY => 'community_id'
    ];

    const GROUP_IMG_UTL_VAR = [
        self::DEFAULT_KEY => 'NULL',
        self::COL_NAME_KEY => 'image_url'
    ];

    const GROUP_TRACKER_ID_VAR = [
        self::COL_NAME_KEY => 'tracker_id',
        self::COL_METHOD_KEY => 'addNewChatTrackerForUuid',
        self::METHOD_CLASS_PATH_KEY => 'App\Repository\ChatTracker'
    ];

    const GROUP_COLS_MAPPER = [
        self::GROUP_ID_VAR,
        self::GROUP_USER_ID_VAR,
        self::GROUP_UUID_VAR,
        self::GROUP_NAME_VAR,
        self::GROUP_ACCESS_IND_VAR,
        self::GROUP_COMM_ID_VAR,
        self::GROUP_IMG_UTL_VAR,
        self::GROUP_TRACKER_ID_VAR,
    ];
}